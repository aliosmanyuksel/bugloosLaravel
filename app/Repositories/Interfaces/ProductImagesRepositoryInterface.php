<?php

// Define the namespace for the interface.
namespace App\Repositories\Interfaces;

/*
 * ProductImagesRepositoryInterface is an interface that declares a method for creating product images.
 * Any class that implements ProductImagesRepositoryInterface will need to define this method, ensuring a consistent API across all product images repository classes.
 */
interface ProductImagesRepositoryInterface
{
    /*
     * The create method is declared but not defined.
     * It's up to any class that implements this interface to define the method.
     * This method will take in an associative array of data and should handle the creation of a product image in the database.
     *
     * @param array $data - The data for the product image to be created.
     */
    public function create(array $data);
}
