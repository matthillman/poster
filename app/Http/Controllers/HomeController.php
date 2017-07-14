<?php

namespace App\Http\Controllers;

use App\Server;
use App\Http\Requests;
use Illuminate\Queue\QueueManager;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['servers' => Server::orderBy('name', 'asc')->get()]);
    }
}
