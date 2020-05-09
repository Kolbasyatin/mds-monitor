<?php

declare(strict_types=1);


namespace App\Models;


class DecideResult
{

    private string $decideInformation;
    private bool $result;

    /**
     * DecideResult constructor.
     * @param bool $result
     * @param string $decideInformation
     */
    public function __construct(bool $result, string $decideInformation)
    {
        $this->decideInformation = $decideInformation;
        $this->result = $result;
    }

    public function isDecideIsPositive(): bool
    {
        return $this->result;
    }

    public function getDecideInformation(): string
    {
        return $this->decideInformation;
    }

}