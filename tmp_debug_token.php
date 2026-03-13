<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

$app->make('config')->set('database.default', env('DB_CONNECTION', 'mysql'));

$token = DB::table('oauth_access_tokens')->orderBy('created_at', 'desc')->first();

print_r($token);
