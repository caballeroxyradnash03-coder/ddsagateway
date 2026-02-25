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
        $response = $client->request($method, $requestUrl, $options);

        // Return response body contents
        return $response->getBody()->getContents();
    }
}