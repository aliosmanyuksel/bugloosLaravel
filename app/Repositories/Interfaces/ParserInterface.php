<?php

// Define the namespace for the interface.
namespace App\Repositories\Interfaces;

/*
 * ParserInterface is an interface that declares a method for parsing data.
 * Any class that implements ParserInterface will need to define this method, ensuring a consistent API across all parser classes.
 * Interfaces are a powerful way to ensure that certain classes adhere to a specific contract or set of methods.
 */
interface ParserInterface
{
    /*
     * The parse method is declared, but not defined.
     * It is up to any class that implements this interface to define the method.
     * This method will take in a string of data and should return the parsed data.
     * @param mixed $data - The data to be parsed.
     * @return mixed - The parsed data.
     */
    public function parse($data);
}
