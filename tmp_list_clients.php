<?php

require __DIR__ . '/bootstrap/app.php';

$db = $app->make('db');
$clients = $db->table('oauth_clients')->select('id','name','secret','password_client','revoked')->get();

foreach ($clients as $c) {
    echo "{$c->id} | {$c->name} | password_client={$c->password_client} | revoked={$c->revoked}\n";
}
