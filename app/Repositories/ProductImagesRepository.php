<?php

// Define the namespace for this class.
namespace App\Repositories;

// Import the ProductImage model from the App\Models namespace.
use App\Models\ProductImage;

// Import the ProductImagesRepositoryInterface.
use App\Repositories\Interfaces\ProductImagesRepositoryInterface;

/*
 * ProductImagesRepository is a class that implements the ProductImagesRepositoryInterface.
 * This class interacts with the 'product_images' table of the database.
 * It uses Laravel's Eloquent ORM for database operations.
 */
class ProductImagesRepository implements ProductImagesRepositoryInterface
{
    /*
     * The create method is used to create a new product image record in the 'product_images' table.
     * It takes an associative array of data and passes it to the create method of the ProductImage model.
     * The create method of the ProductImage model is a Laravel Eloquent method that creates a new record in the table.
     *
     * @param array $data - The data for the product image to be created.
     * @return \App\Models\ProductImage - The created ProductImage model instance.
     */
    public function create(array $data)
    {
        return ProductImage::create($data);
    }
}
