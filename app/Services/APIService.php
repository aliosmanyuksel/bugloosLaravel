<?php

// Define the namespace for the class.
namespace App\Services;

use App\Repositories\Interfaces\APIServiceInterface;
// Import the Facade for Laravel's HTTP client.
use Illuminate\Support\Facades\Http;

/*
 * APIService is a class that provides a method for making HTTP GET requests.
 */
class APIService implements APIServiceInterface
{
    /*
     * The fetch method takes a URL as input and returns the body of the HTTP response and Content-Type.
     * It uses Laravel's HTTP client to make the request. If the request fails, it throws an exception.
     *
     * @param string $url The URL to fetch.
     * @return array The body of the HTTP response and Content-type.
     * @throws \Exception If the request fails.
     */
    public function fetch(string $url): array
    {
        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch API data');
        }

        return [
            'body' => $response->body(),
            'content_type' => $response->header('Content-Type'),
        ];
    }

}
