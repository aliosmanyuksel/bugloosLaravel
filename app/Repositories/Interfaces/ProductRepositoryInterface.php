<?php
namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function create(array $attributes);

    public function getAll(): Collection;
}
