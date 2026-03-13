<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

use Nyholm\Psr7\ServerRequest;
use League\OAuth2\Server\ResourceServer;

$client = new GuzzleHttp\Client(['base_uri' => 'http://localhost:8000']);

$res = $client->post('/oauth/token', [
    'form_params' => [
        'grant_type' => 'client_credentials',
        'client_id' => 3,
        'client_secret' => 'Z8bHK6atPaoqZjt4gBZXKZLW92Tp43ewpcnR8vNk',
    ],
]);

$body = json_decode((string) $res->getBody(), true);
$token = $body['access_token'];

echo "access_token length=" . strlen($token) . "\n";

echo "token starts with: " . substr($token, 0, 20) . "\n";

$psr = new ServerRequest('GET', 'http://localhost/users1', [
    'Authorization' => 'Bearer ' . $token,
]);

$server = $app->make(ResourceServer::class);

try {
    $validated = $server->validateAuthenticatedRequest($psr);
    echo "Validated request. attrs: " . json_encode($validated->getAttributes()) . "\n";
} catch (\Throwable $e) {
    echo "Exception: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    if (method_exists($e, 'getErrorType')) {
        echo "Error type: " . $e->getErrorType() . "\n";
    }
    if (method_exists($e, 'getHttpStatusCode')) {
        echo "HTTP status: " . $e->getHttpStatusCode() . "\n";
    }
}
