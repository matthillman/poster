var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.sass(['app.scss', '../../../node_modules/dialog-polyfill/dialog-polyfill.css'])
		// .styles('../../../node_modules/dialog-polyfill/dialog-polyfill.css')
        .browserify('main.js')
        .version(['css/app.css', 'js/main.js']);
});
