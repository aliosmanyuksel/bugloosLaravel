<?php

// Define the namespace for this class.
namespace App\Repositories;

// Import the Product model from the App\Models namespace.
use App\Models\Product;

// Import the ProductRepositoryInterface.
use App\Repositories\Interfaces\ProductRepositoryInterface;

// Import Laravel's Collection class.
use Illuminate\Support\Collection;

/*
 * ProductRepository is a class that implements the ProductRepositoryInterface.
 * This class interacts with the 'products' table of the database.
 * It uses Laravel's Eloquent ORM for database operations.
 */
class ProductRepository implements ProductRepositoryInterface
{
    /*
     * The create method is used to create a new product record in the 'products' table.
     * It takes an associative array of data and passes it to the create method of the Product model.
     * The create method of the Product model is a Laravel Eloquent method that creates a new record in the table.
     *
     * @param array $attributes - The data for the product to be created.
     * @return \App\Models\Product - The created Product model instance.
     */
    public function create(array $attributes): Product
    {
        return Product::create($attributes);
    }

    /*
     * The getAll method is used to retrieve all product records from the 'products' table.
     * It uses the all method of the Product model, which is a Laravel Eloquent method that retrieves all records from the table.
     * The load method is used to eager load the 'images' relationship of the product.
     * This means that all related product images are loaded in the same query, improving performance.
     *
     * @return \Illuminate\Support\Collection - A collection of all Product model instances.
     */
    public function getAll(): Collection
    {
        return Product::all()->load('images');
    }
}
