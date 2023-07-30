<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\APIService;
use App\Services\ParserService;
use App\Services\MapperService;
use App\Repositories\ProductRepository;
use App\Repositories\ProductImagesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class APIController extends Controller
{
    private APIService $apiService;
    private ParserService $parserService;
    private MapperService $mapperService;
    private ProductRepository $productRepository;
    private ProductImagesRepository $productImagesRepository;

    // We inject the services and repositories we are going to use through the constructor
    public function __construct(
        APIService              $apiService,
        ParserService           $parserService,
        MapperService           $mapperService,
        ProductRepository       $productRepository,
        ProductImagesRepository $productImagesRepository
    )
    {
        $this->apiService = $apiService;
        $this->parserService = $parserService;
        $this->mapperService = $mapperService;
        $this->productRepository = $productRepository;
        $this->productImagesRepository = $productImagesRepository;
    }

    // The fetchData function is responsible for getting the data from the external API
    // parsing the XML to an array, mapping the array to match our database fields,
    // and then saving the data to the database
    public function fetchData(): JsonResponse
    {
        try {
            $url = env('API_URL');
            $configFile = storage_path(env('CONFIG_PATH'));

            $data = $this->apiService->fetch($url);
            $contentType = $this->apiService->getContentType($url);
            $parsedData = $this->parserService->parse($data, $contentType);

            foreach ($parsedData['products'] as $product) {
                $mappedData = $this->mapperService->map($product, $configFile);

                // Separate the images data from the rest of the product data
                $imagesData = $mappedData['image'];
                unset($mappedData['image']);

                // Save the product data
                $product = $this->productRepository->create((array)$mappedData);

                // Save each image URL as a separate entry in the product_images table
                foreach ($imagesData as $imageUrl) {
                    $this->productImagesRepository->create([
                        'product_id' => $product->id,
                        'image' => $imageUrl,
                    ]);
                }
            }
            return response()->json(['message' => 'Products fetched, mapped and saved successfully']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'An error occurred while fetching, mapping, or saving the products.'], 500);
        }
    }


    // The getAllProducts function is responsible for getting all the products from our database
    // and then returning the data in the format the client accepts (JSON or XML)
    public function getAllProducts()
    {
        $products = $this->productRepository->getAll();

        if (request()->wantsJson() || request()->accepts('application/json')) {
            return response()->json($products);
        } elseif (request()->accepts('text/xml') || request()->accepts('application/xml')) {
            $xml = new \SimpleXMLElement('<root/>');
            foreach ($products->toArray() as $item) {
                $product = $xml->addChild('product');
                foreach ($item as $key => $value) {
                    if ($key == 'images') {
                        $images = $product->addChild('images');
                        foreach ($value as $image) {
                            $images->addChild('image', $image['image']);
                        }
                    } else if (!is_array($value)) {
                        $product->addChild($key, htmlspecialchars((string)$value));
                    }
                }
            }
            return response($xml->asXML(), 200, ['Content-Type' => 'application/xml']);
        }

        // Default response format is JSON
        return response()->json($products);
    }
}
