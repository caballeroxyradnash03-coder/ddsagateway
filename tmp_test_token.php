<?php

function post($url, $data) {
    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data),
            'ignore_errors' => true,
        ],
    ];
    $context = stream_context_create($opts);
    return file_get_contents($url, false, $context);
}

$tokenResp = post('http://localhost:8000/oauth/token', [
    'grant_type' => 'client_credentials',
    'client_id' => 5,
    'client_secret' => '4cy3tEEsROslJUGsMI3tQsfuzJPuXxmdVMUXKeTn',
]);

$token = json_decode($tokenResp, true);
if (!isset($token['access_token'])) {
    echo "TOKEN FAILED:\n" . $tokenResp . "\n";
    exit(1);
}

echo "got token: " . substr($token['access_token'],0,20) . "...\n";

// call /users2 with bearer
$opts = [
    'http' => [
        'method' => 'GET',
        'header' => "Authorization: Bearer " . $token['access_token'] . "\r\n",
        'ignore_errors' => true,
    ],
];
$res = file_get_contents('http://localhost:8000/users2', false, stream_context_create($opts));
echo "users2 response:\n" . $res . "\n";