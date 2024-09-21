<?php
declare(strict_types=1);

namespace Rstrawbe\Rates;

use GuzzleHttp\Client;

final readonly  class ApiClientFactory
{
    public static function create($config = []): ApiClient
    {
        $apiKey = getenv('APP_KEY');
        if (array_key_exists('app_key', $config)) {
            $apiKey = $config['app_key'];
            unset($config['app_key']);
        }

        $config = array_merge([
            'base_uri' => 'https://openexchangerates.org/api',
            'timeout'  => 5.0,
        ], $config);

        return new ApiClient(new Client($config), $apiKey);
    }

}