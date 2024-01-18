<?php

namespace App\Helpers;

class Whatsapp
{
    private string $wppBaseUrl;

    public function __construct()
    {
        $this->wppBaseUrl = env('WPP_BASE_URL');
    }

    public function get(string $endpoint)
    {
        //
    }

    public function post(string $endpoint, array $data)
    {
        //
    }
}
