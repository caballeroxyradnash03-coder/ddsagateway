<?php
require __DIR__ . '/bootstrap/app.php';
$db = $app->make('db');
$c = $db->table('oauth_clients')->where('id', 5)->first();
if (!$c) {
    echo "client not found\n";
    exit(1);
}
echo "secret: {$c->secret}\n";
