<?php
declare(strict_types=1);

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Rstrawbe\Rates\Dto\RatesResponse;
use Rstrawbe\Rates\Dto\Request\RatesParams;
use Rstrawbe\Rates\Exceptions\Validation\RatesResponseException;
use Rstrawbe\Rates\Validators\RatesResponseValidator;

class RatesResponseValidatorTest extends TestCase
{
    private ?RatesResponseValidator $validator = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new RatesResponseValidator();
    }

    private function mockData(): array
    {
        return [
            'disclaimer' => 'Usage subject to terms: https://openexchangerates.org/terms',
            'license' => 'https://openexchangerates.org/license',
            'timestamp' => 1726923590,
            'base' => 'USD',
            'rates' => [
                'AZN' => 1.7,
                'EUR' => 0.895215,
                'GBP' => 0.75092,
            ]
        ];
    }

    public function testSuccessResponse()
    {
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($this->mockData()));
        $ratesResponse = null;
        try {
            $ratesResponse = $this->validator->validated($response, new RatesParams());
        } catch (\Exception $e) {}

        self::assertTrue($ratesResponse instanceof RatesResponse);
    }

    public function testIncorrectBase() {
        $this->expectException(RatesResponseException::class);
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($this->mockData()));
        $this->validator->validated($response, (new RatesParams())
            ->setBase('EUR'));
    }

    public function testIncorrectStructure() {
        $mockData = $this->mockData();
        unset($mockData['disclaimer'], $mockData['license']);
        $this->expectException(RatesResponseException::class);
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($mockData));
        $this->validator->validated($response, new RatesParams());
    }

    public function testIncorrectRatesStructure() {
        $mockData = $this->mockData();
        $mockData['rates'] = ['test'];
        $this->expectException(RatesResponseException::class);
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($mockData));
        $this->validator->validated($response, new RatesParams());
    }
}
