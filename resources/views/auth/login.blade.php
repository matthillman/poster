@extends('layouts.app')

@section('content')
<form class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--4dp login-card" role="form" method="POST" action="{{ url('/login') }}">
	{{ csrf_field() }}
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text fill center">Bomgar Mobile Notifications</h2>
    </div>
    <div class="mdl-card__supporting-text">
        <div class="login-form flex-vertical-centered">

            @include('common.textinput', ['name' => 'email', 'display_name' => 'E-Mail Address'])
            @include('common.textinput', ['name' => 'password', 'password' => true])

            <div>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="remember">
                    <input type="checkbox" id="remember" name="remember" class="mdl-checkbox__input">
                    <span class="mdl-checkbox__label">Remember Me</span>
                </label>
            </div>

        </div>
    </div>
    <div class="mdl-card__actions login-actions flex-vertical-centered">
        <div>
            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">
                Login
            </button>
        </div>
        <div><a class="" href="{{ url('/password/reset') }}">Forgot Your Password?</a></div>
    </div>
</form>
@endsection
