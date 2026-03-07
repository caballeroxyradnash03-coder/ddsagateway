<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

$client = DB::table('oauth_clients')->where('id', 3)->first();
print_r($client);
