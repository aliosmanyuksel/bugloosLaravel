<?php

// Define the namespace for the service.
namespace App\Services;

// Importing the classes needed for parsing different data formats.
use App\Services\JsonParser;
use App\Services\XmlParser;

/*
 * The ParserService class is responsible for parsing data.
 * It uses different parsing strategies depending on the data format.
 * The specific parsing strategies are provided by JsonParser and XmlParser classes.
 */
class ParserService
{
    // The JsonParser is used for parsing JSON data.
    protected JsonParser $jsonParser;

    // The XmlParser is used for parsing XML data.
    protected XmlParser $xmlParser;

    // The constructor of the class injects the JsonParser and XmlParser classes.
    public function __construct(JsonParser $jsonParser, XmlParser $xmlParser)
    {
        $this->jsonParser = $jsonParser;
        $this->xmlParser = $xmlParser;
    }

    /*
     * The parse method is responsible for parsing the provided data.
     * It checks the content type of the data and uses the appropriate parser for it.
     * If the content type is not supported, it throws an Exception.
     * @param mixed $data - The data to be parsed.
     * @param string $contentType - The content type of the data.
     * @return mixed - The parsed data.
     * @throws \Exception - If the content type is not supported.
     */
    public function parse($data, $contentType)
    {
        if ($contentType == 'application/json') {
            return $this->jsonParser->parse($data);
        } else if ($contentType == 'application/xml') {
            return $this->xmlParser->parse($data);
        } else {
            throw new \Exception('Invalid content type');
        }
    }
}
