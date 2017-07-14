@extends('layouts.app')

@section('content')

@if (count($servers) > 0)
<div class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--4dp">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text fill">Current Servers</h2>
    </div>
    <div class="mdl-card__supporting-text">
		<div class="flex-vertical-centered">
			<ul class="app-list mdl-list">
			@foreach ($servers as $server)
				<li class="mdl-list__item">
					<span class="mdl-list__item-primary-content">
						<button class="mdl-button mdl-js-button" e-go="{{ route('servers.show', ['server' => $server->id]) }}">
							<i class="material-icons  mdl-list__item-avatar accent4 fixme">router</i>
							<span>{{ $server->name }}</span>
						</button>
					</span>
					<span class="mdl-list__item-secondary-content horizontal">
						<form action="{{ route('servers.destroy', ['server' => $server->id]) }}" method="POST">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
							<button type="submit" class="mdl-button mdl-js-button mdl-button--icon error" id="delete-{{ $server->id }}">
								<i class="material-icons">remove_circle</i>
							</button>
							<div class="mdl-tooltip" for="delete-{{ $server->id }}">Delete {{ $server->name }}</div>
						</form>
					</span>
				</li>
			@endforeach
			</ul>
		</div>
    </div>

</div>
@endif

<!-- New Server Form -->
<form action="{{ url('servers') }}" method="POST" class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--4dp">
    {{ csrf_field() }}
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">Add a Server</h2>
    </div>

    <div class="mdl-card__supporting-text">
        <div class="flex-vertical-centered">
            <!-- Display Validation Errors -->
            @include('common.errors')

            <!-- Server Name -->

            @include('common.textinput', ['name' => 'name'])
            @include('common.textinput', ['display_name' => 'Webhook URL', 'name' => 'webhook_url'])


            <!-- Add Server Button -->
            <p>
                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    <i class="material-icons">add_circle</i> Add Server
                </button>
            </p>
        </div>
    </div>
</form>

@endsection
