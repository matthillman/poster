@extends('layouts.app')

@section('content')

<form class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--4dp login-card" role="form" method="POST" action="{{ url('/register') }}">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">Register</h2>
    </div>
    <div class="mdl-card__supporting-text">
        {{ csrf_field() }}
        <div class="login-form flex-vertical-centered">

            @include('common.textinput', ['name' => 'name'])
            @include('common.textinput', ['name' => 'email', 'display_name' => 'E-Mail Address'])
            @include('common.textinput', ['name' => 'password', 'password' => true])
            @include('common.textinput', ['name' => 'password_confirmation', 'display_name' => 'Confirm Password', 'password' => true])

        </div>
    </div>
    <div class="mdl-card__actions login-actions flex-vertical-centered">
        <div>
            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">
                Register
            </button>
        </div>
    </div>
</form>
@endsection
