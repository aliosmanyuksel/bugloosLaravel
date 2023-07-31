<?php

// Define the namespace for the class.
namespace App\Services;

// Import the ParserInterface which this class implements.
use App\Repositories\Interfaces\ParserInterface;

/*
 * XmlParser is a class that implements the ParserInterface.
 * The class is responsible for parsing XML data and converting it into a PHP array.
 */
class XmlParser implements ParserInterface
{
    /*
     * The parse method takes a string of XML data and converts it into a PHP associative array.
     * If the 'products' key in the XML data is not an array, it converts it into an array. This ensures consistent data structure.
     * If the 'images' key in each product is not an array, it converts it into an array. This ensures that each product can have multiple images.
     * @param string $xml - The XML data to be parsed.
     * @return array - The parsed data, as a PHP associative array.
     */
    public function parse($xml): array
    {
        // Load the XML string as a SimpleXMLElement object.
        $xmlObject = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        
        // Convert the SimpleXMLElement object to JSON.
        $json = json_encode($xmlObject);
        
        // Decode the JSON to a PHP array.
        $phpArray = json_decode($json, true);

        // Ensure that the 'products' key is an array.
        $products = [];
        foreach ($phpArray['products'] as $product) {
            // If 'images' is not an array (only one image), make it an array
            if (isset($product['images']) && !is_array($product['images'])) {
                $product['images'] = [$product['images']];
            }
            $products[] = $product;
        }

        // Replace the 'products' key with the new array.
        $phpArray['products'] = $products;

        // Return the PHP array.
        return $phpArray;
    }
}
