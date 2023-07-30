<?php

namespace App\Services; // Define the namespace for this class.

use App\Repositories\Interfaces\ParserInterface;

// Import the ParserInterface.
//This is needed because the ParserInterface is not in the same namespace as this class.

/*
 * XmlParser is a class that implements the ParserInterface.
 * This means that this class must contain all methods defined in ParserInterface.
 * In this case, it means that the XmlParser class must have a parse method.
 */
class XmlParser implements ParserInterface
{
    /*
     * The parse method is required by the ParserInterface.
     * It takes in a string of data and attempts to parse it as XML.
     * @param string $data - The data to be parsed.
     * @return \SimpleXMLElement - The parsed data, as a SimpleXMLElement object.
     */
    public function parse($xml): array
    {
        $xmlObject = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true);

        // Adjust the 'products' array to ensure each product is an array item
        $products = [];
        foreach ($phpArray['products'] as $product) {
            // If 'images' is not an array (only one image), make it an array
            if (isset($product['images']) && !is_array($product['images'])) {
                $product['images'] = [$product['images']];
            }
            $products[] = $product;
        }

        // Replace the 'products' item with our new products array
        $phpArray['products'] = $products;
        //dd($phpArray);
        return $phpArray;
    }


}

