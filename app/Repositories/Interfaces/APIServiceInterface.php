<?php
namespace App\Repositories\Interfaces;

interface APIServiceInterface
{
    public function fetch(string $url): string;
}
