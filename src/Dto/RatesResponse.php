<?php
declare(strict_types=1);

namespace Rstrawbe\Rates\Dto;

final readonly class RatesResponse
{
    public function __construct(
        private string $disclaimer,
        private string $license,
        private int $timestamp,
        private string $base,
        private Rates $rates
    )
    {
    }

    public static function fromArray($data): RatesResponse
    {
        return new RatesResponse(
            $data['disclaimer'],
            $data['license'],
            $data['timestamp'],
            $data['base'],
            new Rates($data['rates'])
        );
    }

    public function getDisclaimer(): string
    {
        return $this->disclaimer;
    }

    public function getLicense(): string
    {
        return $this->license;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getBase(): string
    {
        return $this->base;
    }

    public function getRates(): Rates
    {
        return $this->rates;
    }
}