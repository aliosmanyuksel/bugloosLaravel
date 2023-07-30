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
     * The fetch method takes a URL as input and returns the body of the HTTP response.
     * It uses Laravel's HTTP client to make the request. If the request fails, it throws an exception.
     *
     * @param string $url The URL to fetch.
     * @return string The body of the HTTP response.
     * @throws \Exception If the request fails.
     */
    public function fetch(string $url): string
    {
        $response = Http::get($url);

        // If the request fails (4xx or 5xx HTTP status code), throw an exception.
        if ($response->failed()) {
            throw new \Exception('Failed to fetch API data');
        }

        // Return the body of the HTTP response.
        return $response->body();
    }

    public function getContentType($url)
    {
        $response = Http::get($url);

        // If the request fails (4xx or 5xx HTTP status code), throw an exception.
        if ($response->failed()) {
            throw new \Exception('Failed to fetch API data');
        }

        // Return the body of the HTTP response.
        return $response->header('Content-Type');
    }
}
