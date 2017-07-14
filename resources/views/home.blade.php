@extends('layouts.app')

@section('content')
<div class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--4dp">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text fill center">Today's Payouts</h2>
    </div>

    <div class="mdl-card__supporting-text flex-vertical-centered wide">
		@foreach ($servers as $server)
		<h3 class="list-heading fill">{{ $server->name }}</h3>
		@if (count($server->payouts) > 0)
			<div class="flex-vertical-centered">
				<ul class="mdl-list full-width compact">
					@foreach ($server->payouts->sortBy('name') as $payout)
					<li class="mdl-list__item mdl-list__item--two-line">
						<span class="mdl-list__item-primary-content">
							<i class="material-icons  mdl-list__item-avatar accent4">monetization_on</i>
							<span>{{ $payout->name }}</span>
							<ol class="mdl-list__item-sub-title horizontal">
								@foreach ($payout->members->sortBy('todays_order') as $member)
								<li>{{ $member->name }}</li>
								@endforeach
							</ol>
						</span>
					</li>
				@endforeach
				</ul>
			</div>
		@else
			<p>No payouts have been added for this server.</p>
		@endif
		@endforeach
    </div>
</div>
@endsection
