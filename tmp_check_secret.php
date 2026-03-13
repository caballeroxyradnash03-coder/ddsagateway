<?php
require __DIR__ . '/bootstrap/app.php';

$secret = 'OrhRFtjYeeqlicv3fLzxAADYFAPmPv8JYc0RSRBB';
$db = $app->make('db');
$client = $db->table('oauth_clients')->where('id', 4)->first();

if (!$client) {
    echo "Client 4 not found\n";
    exit(1);
}

$hasher = $app->make('hash');
$ok = $hasher->check($secret, $client->secret);

echo "client=4 name={$client->name} password_client={$client->password_client} revoked={$client->revoked}\n";
echo "secret match? " . ($ok ? 'yes' : 'no') . "\n";
