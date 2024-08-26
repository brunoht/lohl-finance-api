<?php

namespace App\Queries;

use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductById extends Query
{
    protected function query() : Builder
    {
        return Product::where($this->params);
    }
}
