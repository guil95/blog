<?php

namespace App\Domain\Capabilities;

trait VoCapabilities
{
    private string $value;

    public function getValue(): string
    {
        return $this->value;
    }
}
