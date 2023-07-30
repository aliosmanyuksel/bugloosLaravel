<?php

// Define the namespace for this class.
namespace App\Services;

// Import the ParserInterface.
//This is needed because the ParserInterface is not in the same namespace as this class.
use App\Repositories\Interfaces\ParserInterface;

/*
 * JsonParser is a class that implements the ParserInterface.
 * By implementing ParserInterface, JsonParser class must contain all methods defined in ParserInterface.
 * In this scenario, it implies that the JsonParser class must include a parse method.
 */
class JsonParser implements ParserInterface
{
    /*
     * parse is a method required by the ParserInterface.
     * It takes a JSON string and decodes it into a PHP variable.
     * @param string $data - The JSON string to be parsed.
     * @return mixed - The value encoded in JSON. In case of failure, it returns NULL.
     */
    public function parse($data)
    {
        // json_decode is a PHP function that decodes a JSON string.
        return json_decode($data, true); // The second parameter is set to true to return the data as an associative array
    }
}
