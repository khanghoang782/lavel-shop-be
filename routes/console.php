<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use App\Mail\MailTrapTest;
use Illuminate\Support\Facades\Mail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

