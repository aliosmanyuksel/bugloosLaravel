<?php

// Define the namespace for the interface.
namespace App\Repositories\Interfaces;

// Import the Collection class from the Illuminate\Support namespace.
use Illuminate\Support\Collection;

/*
 * ProductRepositoryInterface is an interface that declares methods for creating a product and retrieving all products.
 * Any class that implements ProductRepositoryInterface will need to define these methods, ensuring a consistent API across all product repository classes.
 */
interface ProductRepositoryInterface
{
    /*
     * The create method is declared but not defined.
     * It's up to any class that implements this interface to define the method.
     * This method will take in an associative array of data and should handle the creation of a product in the database.
     *
     * @param array $attributes - The data for the product to be created.
     */
    public function create(array $attributes);

    /*
     * The getAll method is declared but not defined.
     * It's up to any class that implements this interface to define the method.
     * This method should return a collection of all products in the database.
     *
     * @return Collection - A collection of all products.
     */
    public function getAll(): Collection;
}
