<?php

namespace App\Actions;

class Action
{
    protected function required($params, $key)
    {
        return $params[$key];
    }

    protected function optional($params, $key)
    {
        return $params[$key] ?? null;
    }

    protected function setParams($params = []) : void
    {
        //
    }

    protected function handle()
    {
        return null;
    }

    public function run()
    {
        return $this->handle();
    }
}
