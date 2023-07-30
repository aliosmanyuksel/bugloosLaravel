<?php
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $attributes)
    {
        return Product::create($attributes);
    }

    public function getAll(): Collection
    {
        return Product::all()->load('images');
    }
}
