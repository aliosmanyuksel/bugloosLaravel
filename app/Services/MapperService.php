<?php

// Define the namespace for the service.
namespace App\Services;

// Import the Yaml class from the Symfony\Component\Yaml namespace.
use Symfony\Component\Yaml\Yaml;

/*
 * The MapperService class is responsible for mapping the API data to our database schema.
 * The mapping configuration is defined in a YAML file.
 */
class MapperService
{
    /*
     * The map function takes API data and a configuration file, 
     * and then maps the data according to the rules defined in the configuration file.
     * @param array $data - The data retrieved from the API.
     * @param string $configFile - The path to the configuration file.
     * @return array - The mapped data, ready to be saved to the database.
     */
    public function map($data, $configFile): array
    {
        // Parse the configuration file
        $config = Yaml::parseFile($configFile);
        $mappedData = [];

        // Iterate over each field defined in the configuration file
        foreach ($config as $field) {
            // Check if the field is an array (nested object in the API data)
            if (isset($field['array'])) {
                foreach ($field['array'] as $nestedField) {
                    $apiField = $nestedField['apiField']; // The field's name in the API data
                    $dbField = $nestedField['db']['field']; // The field's name in our database
                    
                    // If the API field is 'image', the value should be an array of image URLs
                    if ($apiField === 'image') {
                        $mappedData[$dbField] = $data[$apiField]; 
                    } else {
                        // Use Laravel's data_get helper function to retrieve the value from the API data
                        $mappedData[$dbField] = data_get($data, $apiField);
                    }
                }
            } else {
                $apiField = $field['apiField'];
                $dbField = $field['db']['field'];
                
                // Same as above
                if ($apiField === 'image') {
                    $mappedData[$dbField] = $data[$apiField];
                } else {
                    $mappedData[$dbField] = data_get($data, $apiField);
                }
            }
        }

        // Return the mapped data
        return $mappedData;
    }
}
