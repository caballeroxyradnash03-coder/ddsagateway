<?php
require __DIR__ . '/vendor/autoload.php';

$base = 'http://localhost:8000';
$client = new GuzzleHttp\Client(['base_uri' => $base]);

try {
    $tokenRes = $client->post('/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => 3,
            'client_secret' => 'z4WtgKh2MXuVbYhDplNu8WWOZ9qmNjjuPzzyq7rz',
        ],
    ]);

    $token = json_decode((string) $tokenRes->getBody(), true)['access_token'];
    echo "TOKEN: $token\n";

    $res = $client->get('/users1', [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
        ],
    ]);

    echo "status: " . $res->getStatusCode() . "\n";
    echo (string) $res->getBody() . "\n";
} catch (GuzzleHttp\Exception\BadResponseException $e) {
    echo "status: " . $e->getResponse()->getStatusCode() . "\n";
    echo (string) $e->getResponse()->getBody() . "\n";
}
