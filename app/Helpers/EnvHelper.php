<?php

namespace App\Helpers;

use Auth;

class EnvHelper
{
	public static function isDev() {
		return config('app.env') === 'local';
	}

	public function dev() {
		return static::isDev();
	}
}