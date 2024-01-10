<?php

namespace App\Utils;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class MercadoPago
{
    private string $mpBaseUrl;
    private string $mpVersion;
    private string $mpPublicKey;
    private string $mpAccessToken;
    private string $clientId;
    private string $clientSecret;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mpBaseUrl = env('MERCADOPAGO_BASE_URL');

        $this->mpVersion = env('MERCADOPAGO_VERSION');

        $this->clientId = env('MERCADOPAGO_CLIENT_ID');

        $this->clientSecret = env('MERCADOPAGO_CLIENT_SECRET');

        $environment = env('MERCADO_PAGO_ENVIRONMENT', 'TEST');

        if ($environment === "TEST")
        {
            $this->mpPublicKey = env('MERCADOPAGO_PUBLIC_KEY_TEST');

            $this->mpAccessToken =  env('MERCADOPAGO_ACCESS_TOKEN_TEST');
        }

        if ($environment === "PROD")
        {
            $this->mpPublicKey = env('MERCADOPAGO_PUBLIC_KEY_PROD');

            $this->mpAccessToken =  env('MERCADOPAGO_ACCESS_TOKEN_PROD');
        }
    }

    /**
     * @param string|null $version
     * @return string
     */
    public function url(string|null $version = null) : string
    {
        $version = $version ?? $this->mpVersion;

        return $this->mpBaseUrl . $version;
    }

    /**
     * @param string $endpoint
     * @param string|null $version
     * @return Response
     */
    public function get(string $endpoint, string|null $version = null) : Response
    {
        $url = $this->url($version) . $endpoint;

        return Http::withToken($this->mpAccessToken)->get($url);
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @param string|null $version
     * @param array $headers
     * @return Response
     */
    public function post(string $endpoint, array $data = [], string|null $version = null, array $headers = []) : Response
    {
        $url = $this->url($version) . $endpoint;

        return Http::withHeaders($headers)->withToken($this->mpAccessToken)->post($url, $data);
    }
}
