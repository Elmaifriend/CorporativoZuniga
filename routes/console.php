<?php

use App\Console\Commands\NotifyDuePayments;
use App\Console\Commands\NotifyEarlyPayments;
use App\Console\Commands\NotifyLatePayments;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(NotifyEarlyPayments::class)->everyMinute();
Schedule::command(NotifyDuePayments::class)->everyMinute();
Schedule::command(NotifyLatePayments::class)->everyMinute();
