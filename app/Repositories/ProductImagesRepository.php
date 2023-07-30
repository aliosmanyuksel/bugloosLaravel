<?php

namespace App\Repositories;

use App\Models\ProductImage;
use App\Repositories\Interfaces\ProductImagesRepositoryInterface;

class ProductImagesRepository implements ProductImagesRepositoryInterface
{
    public function create(array $data)
    {
        return ProductImage::create($data);
    }
}
