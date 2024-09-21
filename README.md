# Exchange Rates Client

### Install

`$ composer require rstrawbe/rates`

### Examples

```php
$apiClient = ApiClientFactory::create([
    'app_key' => getenv('API_KEY'),
]);

try {
    $result = $apiClient->getRates();
    print_r($result);
} catch (\Exception $e) {
    print_r($e->getMessage());
}

// Request params
$params = (new RatesParams())
    ->setBase('USD')
    ->setSymbols(['EUR', 'GBP', 'AZN']);
    
try {
    $result = $apiClient->getRates($params);
    print_r($result);
} catch (\Exception $e) {
    print_r($e->getMessage());
}

```