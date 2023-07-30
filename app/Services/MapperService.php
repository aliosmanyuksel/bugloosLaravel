<?php

namespace App\Services;

use Symfony\Component\Yaml\Yaml;

class MapperService
{
    public function map($data, $configFile): array
    {
        $config = Yaml::parseFile($configFile);
        $mappedData = [];

        foreach ($config as $field) {
            // Check if it's an array (nested object)
            if (isset($field['array'])) {
                foreach ($field['array'] as $nestedField) {
                    $apiField = $nestedField['apiField'];
                    $dbField = $nestedField['db']['field'];
                    
                    if ($apiField === 'image') {
                        $mappedData[$dbField] = $data[$apiField]; // this is now an array of image URLs
                    } else {
                        $mappedData[$dbField] = data_get($data, $apiField);
                    }
                }
            } else {
                $apiField = $field['apiField'];
                $dbField = $field['db']['field'];
                
                if ($apiField === 'image') {
                    $mappedData[$dbField] = $data[$apiField]; // this is now an array of image URLs
                } else {
                    $mappedData[$dbField] = data_get($data, $apiField);
                }
            }
        }

        return $mappedData;
    }
}
