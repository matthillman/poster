<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>Shard Mafia Webhook</title>


    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/Square.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Notifications">
    <link rel="apple-touch-icon-precomposed" href="images/Square.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/Square.png">
    <meta name="msapplication-TileColor" content="#000000">

    <link rel="shortcut icon" href="/favicon.ico">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.red-indigo.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: -apple-system-body, 'Helvitica Neue', Sans-serif;
        }
    </style>
</head>
<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
					<img src="/images/Logo.png" srcset="/images/Logo@2x.png 2x, /images/Logo.png 1x" height="45px">
                </a>
                <div class="mdl-layout-spacer"></div>
                <!-- Right Side Of Navbar -->
                <nav class="mdl-navigation mdl-layout--large-screen-only">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <a class="mdl-navigation__link" href="{{ url('/login') }}">
							<span>Login</span>
						</a>
                        <a class="mdl-navigation__link" href="{{ url('/register') }}">
                        	<span>Register</span>
						</a>
                    @else
						<a class="mdl-navigation__link" href="{{ url('/home') }}">
							<span>Home</span>
						</a>
						<a class="mdl-navigation__link" href="{{ url('/servers') }}">
							<span>Servers</span>
						</a>
                        <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--white">
                            <span>{{ Auth::user()->name }}</span>
                            <i class="material-icons" role="presentation">arrow_drop_down</i>
                        </button>
                        <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect user-menu" for="accbtn">
                            <li class="mdl-menu__item mdl-js-ripple-effect mdl-button--primary" bg-e-go="{{ url('/logout') }}">
								<i class="material-icons">remove_circle</i>Logout
                            </li>
                        </ul>
                    @endif
                </nav>
            </div>
        </header>

        <main class="mdl-layout__content">
            <div class="page-content mdl-grid">
            @yield('content')
            </div>
        </main>

		@include('common.snackbar')

    </div>
    <!-- JavaScripts -->
     <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
     <script src="{{ mix('js/main.js') }}"></script>
	 @stack('scripts')
</body>
</html>
