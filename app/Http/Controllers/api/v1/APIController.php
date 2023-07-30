<?php

// Define the namespace for this class.
namespace App\Http\Controllers\api\v1;

// Import necessary classes.
use App\Http\Controllers\Controller;
use App\Services\APIService;
use App\Services\ParserService;
use App\Services\MapperService;
use App\Repositories\ProductRepository;
use App\Repositories\ProductImagesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/*
 * APIController is a controller that handles API requests related to products.
 * It uses services and repositories to handle different aspects of the data fetching, parsing, mapping, and storage processes.
 */
class APIController extends Controller
{
    // These properties hold instances of the services and repositories used by this controller.
    private APIService $apiService;
    private ParserService $parserService;
    private MapperService $mapperService;
    private ProductRepository $productRepository;
    private ProductImagesRepository $productImagesRepository;

    /*
     * The constructor method is used to inject the necessary services and repositories into this controller.
     */
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

    /*
     * The fetchData method is responsible for fetching, parsing, mapping, and storing product data from an external API.
     * If successful, it returns a JSON response with a success message.
     * If an error occurs at any point in the process, it logs the error and returns a JSON response with an error message.
     *
     * @return \Illuminate\Http\JsonResponse - A JSON response indicating the success or failure of the operation.
     */
    public function fetchData(): JsonResponse
    {
        try {
            // Fetch data and parse it.
            $url = env('API_URL');
            $configFile = storage_path(env('CONFIG_PATH'));

            $data = $this->apiService->fetch($url);
            $contentType = $this->apiService->getContentType($url);
            $parsedData = $this->parserService->parse($data, $contentType);

            // Map and store data.
            foreach ($parsedData['products'] as $product) {
                $mappedData = $this->mapperService->map($product, $configFile);

                // Separate images data and save product and images data.
                $imagesData = $mappedData['image'];
                unset($mappedData['image']);
                $product = $this->productRepository->create((array)$mappedData);

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

    /*
     * The getAllProducts method is responsible for retrieving all stored products and returning them in a client-accepted format.
     * The format can be JSON or XML.
     * If no specific format is requested, the default format is JSON.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response - The response containing the products data in the requested format.
     */
    public function getAllProducts()
    {
        // Fetch all products.
        $products = $this->productRepository->getAll();

        // Determine the response format and return the data.
        if (request()->wantsJson() || request()->accepts('application/json')) {
            return response()->json($products);
        } elseif (request()->accepts('text/xml') || request()->accepts('application/xml')) {
            // Build XML and return it.
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

        // Default response format is JSON.
        return response()->json($products);
    }
}
