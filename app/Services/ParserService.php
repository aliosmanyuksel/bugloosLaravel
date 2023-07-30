<?php

namespace App\Services;

use App\Services\JsonParser;
use App\Services\XmlParser;

class ParserService
{
    protected \App\Services\JsonParser $jsonParser;
    protected \App\Services\XmlParser $xmlParser;

    public function __construct(JsonParser $jsonParser, XmlParser $xmlParser)
    {
        $this->jsonParser = $jsonParser;
        $this->xmlParser = $xmlParser;
    }

    /**
     * @throws \Exception
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
