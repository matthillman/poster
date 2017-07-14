@extends('layouts.app')

@section('content')
	<div class="mdl-cell mdl-cell--12-col flex-vertical-centered white">
		<h1>{{ $server->name }}</h1>
		<span>{{ $server->webhook_url }}</span>
	</div>

	<div class="mdl-cell mdl-cell--6-col mdl-card mdl-shadow--4dp">
		<div class="mdl-card__title">
			<h2 class="mdl-card__title-text center">Payouts</h2>
		</div>

		<div class="mdl-card__supporting-text">
		<!-- Current Tokens -->
		@if (count($server->payouts) > 0)
			<div class="flex-vertical-centered">
				<ul class="mdl-list full-width">
					@foreach ($server->payouts as $payout)
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
		</div>
	</div>

	<!-- New Payout Form -->
	<form action="{{ route('servers.addPayout', [$server]) }}" method="POST" class="payout-form mdl-cell mdl-cell--6-col mdl-card mdl-shadow--4dp flex-vertical-centered">
		{{ csrf_field() }}

		<h3 class="mdl-card__title-text center">Add New Payout</h3>

		@include('common.textinput', ['name' => 'name'])
		@include('common.textinput', ['name' => 'blurb', 'display_name' => 'Text blurb to include with the reminder'])
		@include('common.dateinput', ['name' => 'order_effective_at', 'display_name' => 'Order Effective On'])

		<div class="wrap">
			<label class="fake">Payout Time</label>
			<div class="spread">
				<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
					<input type="radio" id="option-1" class="mdl-radio__button" name="payout_time" value="5">
					<span class="mdl-radio__label">5 PM</span>
				</label>
				<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
					<input type="radio" id="option-2" class="mdl-radio__button" name="payout_time" value="6">
					<span class="mdl-radio__label">6 PM</span>
				</label>
				<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
					<input type="radio" id="option-3" class="mdl-radio__button" name="payout_time" value="7" checked>
					<span class="mdl-radio__label">7 PM</span>
				</label>
			</div>
		</div>

		<div class="drowpdown-textfield wrap">
			@include('common.textinput', ['name' => 'timezone', 'display_name' => 'Payout Timezone'])
			<button id="timezone-menu" class="mdl-button mdl-js-button mdl-button--icon" type="button">
				<i class="material-icons">arrow_drop_down</i>
			</button>
			@include('common.timezonelist', ['name' => 'timezone'])
		</div>

		<div class="wrap">
			<h4 class="subhead">Members <i class="material-icons" e-add-row>add_circle</i></h4>
			<div class="mdl-list full-width sortable" e-sortable="member_order"></div>
			<input type="hidden" id="member_order" name="member_order" value="1;2;3">
		</div>

		<div class="wrap center">
			<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">
				Add Payout
			</button>
		</div>
	</form>

@endsection
