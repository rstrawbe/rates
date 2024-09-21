<?php
declare(strict_types=1);

namespace Rstrawbe\Rates\Dto;

final readonly class Rates
{
    public function __construct(
        private array $rates,
    )
    {}

    public function all(): array
    {
        return $this->rates;
    }

    public function one(string $currency): ?float
    {
        if (array_key_exists($currency, $this->rates)) {
            return $this->rates[$currency];
        }
        return null;
    }
}