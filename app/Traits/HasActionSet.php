<?php

namespace App\Traits;

Trait HasActionSet
{
    public static function set($params = []) : self
    {
        $action = new self();
        $action->setParams($params);
        return $action;
    }
}
