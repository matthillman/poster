<?php

namespace App\Http\Controllers;

use App\Server;
use App\Member;
use App\Payout;
use Illuminate\Http\Request;

use DateTime;
use DateTimeZone;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return view('server.list', ['servers' => Server::orderBy('name', 'asc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'webhook_url' => 'required',
        ]);

		$server = new Server;
		$server->name = $request->name;
		$server->webhook_url = $request->webhook_url;
		$server->save();

        return redirect('/servers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
		$server->load('payouts.members');
		return view('server.payouts', ['server' => $server]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server)
    {
        dd($request);
    }

	public function addPayout(Request $request, Server $server) {
		$payout = new Payout;
		$payout->name = $request->name;
		$payout->blurb = $request->blurb;
		$z = new DateTimeZone($request->timezone);
		$d = new DateTime($request->order_effective_at, $z);
		// This is either 5, 6 or 7 but needs to be in 24 hour time, so add 12
		$d->setTime($request->payout_time + 12, 0);
		$payout->order_effective_at = $d->getTimestamp();

		$order = explode(';', $request->member_order);
		$members = [];

		foreach ($request->members as $member) {
			list($mID, $name) = explode(';', $member);
			$id = (int)str_replace('__', '', $mID);
			$member = strpos($mID, '__') === false ? Member::find($id) : new Member;
			$member->name = $name;
			$member->starting_rank = array_search($id, $order) + 1;
			$members[] = $member;
		}
		$server->payouts()->save($payout);
		$payout->members()->saveMany($members);

		$server->load('payouts');
		return redirect()->route('servers.show', [$server]);

	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {

		if ($server->payouts->count()) {
			$server->payouts->delete();
		}

        $server->delete();

        return redirect('/servers');
    }
}
