<?php
declare(strict_types=1);

namespace Rstrawbe\Rates;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;
use Rstrawbe\Rates\Dto\RatesResponse;
use Rstrawbe\Rates\Dto\Request\RatesParams;
use Rstrawbe\Rates\Exceptions\Validation\RatesResponseException;
use Rstrawbe\Rates\Validators\RatesResponseValidator;

final readonly class ApiClient
{
    public function __construct(
        private ClientInterface               $client,
        #[\SensitiveParameter] private string $apiKey
    )
    {
    }

    /**
     * @link https://docs.openexchangerates.org/reference/latest-json
     * @throws RatesResponseException|GuzzleException
     */
    public function getRates(?RatesParams $params = null): RatesResponse
    {
        if (is_null($params)) {
            $params = new RatesParams();
        }

        $data = array_merge([
            'app_id' => $this->apiKey
        ], $params->all());

        $response = $this->client->request('GET', 'latest.json', [
            'query' => $data
        ]);

        return (new RatesResponseValidator())
            ->validated($response, $params);
    }
}