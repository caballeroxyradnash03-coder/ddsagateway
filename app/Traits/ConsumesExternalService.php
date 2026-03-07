<?php

namespace App\Traits;

//include GuzzleHttp client for making HTTP requests to external services
use GuzzleHttp\Client;

trait ConsumesExternalService
{
    /**
     * Send a request to any external service
     *
     * @param string $method
     * @param string $requestUrl
     * @param array $form_params
     * @param array $headers
     * @return string
     */
    public function performRequest($method, $requestUrl, $form_params = [], $headers = [])
    {
        // Create a new Guzzle client
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        if (isset($this->secret)) {
            // If a secret is set, include it in the headers for authentication
            $headers['Authorization'] =  $this->secret;
        }

        // Prepare request options depending on HTTP method
        $options = [
            'headers' => $headers,
        ];

        // Use query parameters for GET requests, form_params for others
        if (!empty($form_params)) {
            if (strtoupper($method) === 'GET') {
                $options['query'] = $form_params;
            } else {
                $options['form_params'] = $form_params;
            }
        }

        // Perform the request
        // Disable throwing exceptions for 4xx/5xx so we can propagate the response body
        $options['http_errors'] = false;

        try {
            $response = $client->request($method, $requestUrl, $options);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // If the request failed before getting a response, return a structured error
            return json_encode([
                'error' => 'service_unavailable',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
        }

        // Return response body contents (may contain an error JSON from the target service)
        return $response->getBody()->getContents();
    }
}
