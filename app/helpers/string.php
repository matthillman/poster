<?php

use \Illuminate\Support\Str;

if (!function_exists('title')) {
	function title($string) {
		return Str::title(snake_case(studly_case($string), ' '));
	}
}

if (!function_exists('nullify_empty')) {
	function nullify_empty($string) {
		return $string == "" ? null : $string;
	}
}
