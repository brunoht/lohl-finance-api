<?php

namespace App\Traits;

Trait HasStatusCode
{
    public static array $statusCode = [
        200 => 'success',
        401 => 'unauthorized',
        404 => 'not found'
    ];
}
