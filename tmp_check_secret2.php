<?php
require __DIR__ . '/bootstrap/app.php';

$secret = '4cy3tEEsROslJUGsMI3tQsfuzJPuXxmdVMUXKeTn';
$db = $app->make('db');
$client = $db->table('oauth_clients')->where('id', 5)->first();

if (!$client) {
    echo "Client 5 not found\n";
    exit(1);
}

$hasher = $app->make('hash');
$ok = $hasher->check($secret, $client->secret);

echo "client=5 name={$client->name} password_client={$client->password_client} revoked={$client->revoked}\n";
echo "secret match? " . ($ok ? 'yes' : 'no') . "\n";
