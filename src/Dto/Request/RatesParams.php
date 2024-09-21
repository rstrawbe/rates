<?php
declare(strict_types=1);

namespace Rstrawbe\Rates\Dto\Request;

final class RatesParams
{
    private string $base = 'USD';
    /**
     * @var string[] $symbols
     */
    private array $symbols = [];
    private bool $prettyPrint = false;
    private bool $showAlternative = false;


    public function getBase(): string
    {
        return $this->base;
    }

    public function setBase(string $base): RatesParams
    {
        $this->base = $base;
        return $this;
    }

    public function getSymbols(): array
    {
        return $this->symbols;
    }

    /**
     * @param string[] $symbols
     * @return $this
     */
    public function setSymbols(array $symbols): RatesParams
    {
        $this->symbols = $symbols;
        return $this;
    }

    public function isPrettyPrint(): bool
    {
        return $this->prettyPrint;
    }

    public function setPrettyPrint(bool $prettyPrint): RatesParams
    {
        $this->prettyPrint = $prettyPrint;
        return $this;
    }

    public function isShowAlternative(): bool
    {
        return $this->showAlternative;
    }

    public function setShowAlternative(bool $showAlternative): RatesParams
    {
        $this->showAlternative = $showAlternative;
        return $this;
    }

    public function all(): array
    {
        return [
            'base' => $this->base,
            'symbols' => implode(',', $this->symbols),
            'prettyprint' => $this->prettyPrint,
            'show_alternative' => $this->showAlternative,
        ];
    }
}