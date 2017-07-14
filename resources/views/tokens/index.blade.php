@extends('layouts.app')

@section('content')
	<div class="mdl-cell mdl-cell--12-col flex-vertical-centered white">
		<h1>{{ $application->name }}</h1>
	</div>

	<div class="mdl-cell mdl-cell--6-col mdl-card mdl-shadow--4dp">
		<div class="mdl-card__title">
			<h2 class="mdl-card__title-text center">Device Tokens</h2>
		</div>

		<div class="mdl-card__supporting-text">
		<!-- Current Tokens -->
		@if (count($tokens) > 0)
			<div class="flex-vertical-centered">
				<ul
					class="token-list mdl-list"
					bg-name="device_tokens"
					bg-e-input-array="device_token_container"
				>
					@foreach ($tokens as $index => $token)
					<li class="mdl-list__item mdl-list__item--two-line">
						<span class="mdl-list__item-primary-content">
							<i class="material-icons  mdl-list__item-avatar accent4">person</i>
							<span>{{ $token->name }}</span>
							<span class="mdl-list__item-sub-title">{{ substr($token->device_token, 0, 20) }}…</span>
						</span>

						<span class="mdl-list__item-secondary-content">
						@if ($index === 0)
							<span class="mdl-list__item-secondary-info">Include in notification</span>
						@endif
							<span class="mdl-list__item-secondary-action">
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="use-{{ $token->device_token }}">
									<input
										type="checkbox"
										id="use-{{ $token->device_token }}"
										class="mdl-checkbox__input"
										name="tokens"
										bg-value="{{ $token->device_token }}"
									>
								</label>
							</span>
						</span>
					</li>
				@endforeach
				</ul>
			</div>
		@else
			<p>No tokens have been added for this application.</p>
		@endif
		</div>

		<!-- New Token Form -->
		<form action="{{ route('application.token.add', ['application' => $application->id]) }}" method="POST" class="mdl-card__actions divider-top flex-vertical-centered">
			{{ csrf_field() }}

			<h3 class="mdl-card__title-text center">Add New Token</h3>
			<!-- Token Name -->
            @include('common.textinput', ['name' => 'name'])

			<!-- Token… Token -->
            @include('common.textinput', ['name' => 'token'])

			<!-- Add Token Button -->
			<div>
				<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">
					Add Device Token
				</button>
			</div>
		</form>

	</div>

	<form action="{{ route('application.send_notification', ['application' => $application->id]) }}" method="POST"  class="mdl-cell mdl-cell--6-col mdl-card mdl-shadow--4dp">
		{{ csrf_field() }}
		<div class="mdl-card__title">
			<h2 class="mdl-card__title-text center">Send a Notification</h2>
		</div>

		<div class="mdl-card__supporting-text">
			<div class="flex-vertical-centered">
				<div>
					<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="content-available">
						<input
							type="checkbox"
							id="content-available"
							name="content-available"
							class="mdl-switch__input"
							bg-e-disable-related="sound|message"
						>
						<span class="mdl-switch__label">Send as a silent notification</span>
					</label>
				</div>

				@include('common.textinput', ['name' => 'message'])
				@include('common.textinput', ['name' => 'sound', 'display_name' => 'Sound File Name'])

				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<textarea class="mdl-textfield__input" type="text" rows="5" id="custom_data" name="custom_data"></textarea>
					<label class="mdl-textfield__label" for="custom_data">Custom Data</label>
				</div>

				<div id="device_token_container"></div>
			</div>
		</div>
		<div class="mdl-card__actions flex-vertical-centered">
			<div>
				<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">
					Send Notification
				</button>
			</div>
		</div>
	</form>

@endsection
