<?php

// Define the namespace for the interface.
namespace App\Repositories\Interfaces;

/*
 * The APIServiceInterface is an interface that declares a method for fetching data from an API.
 * Any class that implements APIServiceInterface will need to define this method, ensuring a consistent API across all API service classes.
 * Interfaces are a powerful way to ensure that certain classes adhere to a specific contract or set of methods.
 */
interface APIServiceInterface
{
    /*
     * The fetch method is declared, but not defined.
     * It is up to any class that implements this interface to define the method.
     * This method will take in a URL string and should return the fetched data as a string.
     * @param string $url - The URL to fetch data from.
     * @return string - The fetched data.
     */
    public function fetch(string $url): string;
}
