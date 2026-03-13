<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use Nyholm\Psr7\ServerRequest;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Nyholm\Psr7\Factory\Psr17Factory;

// Grab the most recent token from DB
$token = DB::table('oauth_access_tokens')->orderBy('created_at', 'desc')->first();
if (! $token) {
    echo "No token found\n";
    exit(1);
}

$bearer = 'Bearer ' . \trim($token->id);

// Create a PSR-7 request like Passport middleware does
$psrFactory = new Psr17Factory();
$psrRequest = new ServerRequest('GET', 'http://localhost/users1', [
    'Authorization' => $bearer,
]);

$server = $app->make(\League\OAuth2\Server\ResourceServer::class);

try {
    $validated = $server->validateAuthenticatedRequest($psrRequest);
    echo "Validated request. Attributes:\n";
    print_r($validated->getAttributes());
} catch (\Throwable $e) {
    echo "Exception: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    if (method_exists($e, 'getErrorType')) {
        echo "Error type: " . $e->getErrorType() . "\n";
    }
    if (method_exists($e, 'getHttpStatusCode')) {
        echo "HTTP status: " . $e->getHttpStatusCode() . "\n";
    }
    echo "Trace first line: " . $e->getTraceAsString() . "\n";
}
