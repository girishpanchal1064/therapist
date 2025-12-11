<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule session activation - runs every minute
Schedule::command('sessions:activate')->everyMinute();

// Schedule session ending - runs every minute to check for expired sessions
Schedule::command('sessions:end')->everyMinute();
