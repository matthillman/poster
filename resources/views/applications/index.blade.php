@extends('layouts.app')

@section('content')

@if (count($servers) > 0)
<div class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--4dp">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text fill">Current Applications</h2>
    </div>
    <div class="mdl-card__supporting-text">
		<div class="flex-vertical-centered">
			<ul class="app-list mdl-list">
			@foreach ($applications as $application)
				<li class="mdl-list__item mdl-list__item--two-line">
					<span class="mdl-list__item-primary-content">
						<button class="mdl-button mdl-js-button" bg-e-go="{{ route('application.tokens', ['application' => $application->id]) }}">
							<i class="material-icons  mdl-list__item-avatar accent4 fixme">phone_iphone</i>
							<span>{{ $application->name }}</span>
							<span class="mdl-list__item-sub-title">{{ $application->bundle_id }}</span>
						</button>
					</span>
					<span class="mdl-list__item-secondary-content horizontal">
						@if ($application->certificate === null)
							<i class="material-icons warning" id="missing-cert-{{ $application->id }}">warning</i>
							<div class="mdl-tooltip" for="missing-cert-{{ $application->id }}">No push certificate found for {{ $application->bundle_id }}</div>
						@else
							<i class="material-icons success" id="good-cert-{{ $application->id }}">check_circle</i>
							<div class="mdl-tooltip" for="good-cert-{{ $application->id }}">Push certificate found</div>
						@endif
						<form action="{{ url('application/'.$application->id) }}" method="POST">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
							<button type="submit" class="mdl-button mdl-js-button mdl-button--icon error" id="delete-{{ $application->id }}">
								<i class="material-icons">remove_circle</i>
							</button>
							<div class="mdl-tooltip" for="delete-{{ $application->id }}">Delete {{ $application->name }}</div>
						</form>
					</span>
				</li>
			@endforeach
			</ul>
		</div>
    </div>

</div>
@endif

<!-- New Application Form -->
<form action="{{ url('application') }}" method="POST" class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--4dp">
    {{ csrf_field() }}
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">Add an Application</h2>
    </div>

    <div class="mdl-card__supporting-text">
        <div class="flex-vertical-centered">
            <!-- Display Validation Errors -->
            @include('common.errors')

            <!-- Application Name -->

            @include('common.textinput', ['name' => 'name'])

            <div>
                <div class="bundle_id_menu">
					@include('common.textinput', ['name' => 'bundle_id', 'display_name' => 'Bundle ID'])

                    <button id="bundle_id-menu" class="mdl-button mdl-js-button mdl-button--icon" type="button">
                        <i class="material-icons">arrow_drop_down</i>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="bundle_id-menu">
                        <li disabled>Found in Certificates:</li>
                    @foreach ($bundle_ids as $bundle_id)
                        <li class="mdl-menu__item" bg-e-filltext="bundle_id">{{ $bundle_id }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>

            <!-- Add Application Button -->
            <p>
                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    <i class="material-icons">add_circle</i> Add Application
                </button>
            </p>
        </div>
    </div>
</form>

@endsection
