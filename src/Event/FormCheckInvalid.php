<?php

declare(strict_types=1);

namespace Libdevo\FormShieldBundle\Event;

class FormCheckInvalid
{
    protected ?string $value = null;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
