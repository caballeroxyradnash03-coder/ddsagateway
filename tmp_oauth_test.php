<?php
require __DIR__ . '/vendor/autoload.php';

$client = new GuzzleHttp\Client(['base_uri' => 'http://localhost:8000']);

try {
    $res = $client->post('/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => 1,
            'client_secret' => 'Z8bHK6atPaoqZjt4gBZXKZLW92Tp43ewpcnR8vNk',
        ],
    ]);

    echo "status: " . $res->getStatusCode() . "\n";
    echo $res->getBody();
} catch (GuzzleHttp\Exception\BadResponseException $e) {
    echo "status: " . $e->getResponse()->getStatusCode() . "\n";
    echo (string) $e->getResponse()->getBody();
}
