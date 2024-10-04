<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PilulierApiService
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;

    public function __construct(HttpClientInterface $httpClient, string $pilulierApiBaseUrl)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = rtrim($pilulierApiBaseUrl, '/'); // Ensure no trailing slash
    }

    /**
     * Sends a POST request to a specific endpoint.
     *
     * @param string $endpoint The API endpoint (e.g., '/open', '/close').
     *
     * @return bool True if the request was successful, false otherwise.
     */
    private function sendPostRequest(string $endpoint): bool
    {
        $url = $this->baseUrl . $endpoint;

        try {
            $response = $this->httpClient->request('POST', $url);

            if ($response->getStatusCode() === 200) {
                return true;
            }

            // Log or handle non-200 responses as needed
            return false;
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            return false;
        }
    }

    public function open(): bool
    {
        return $this->sendPostRequest('/open');
    }

    public function close(): bool
    {
        return $this->sendPostRequest('/close');
    }

    public function power(): bool
    {
        return $this->sendPostRequest('/power');
    }

    public function remote(): bool
    {
        return $this->sendPostRequest('/remote');
    }

    public function testMotor(): bool
    {
        return $this->sendPostRequest('/test-motor');
    }

    // Add more methods as needed
}