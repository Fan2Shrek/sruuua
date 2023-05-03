<?php

namespace App\Validator;

use App\Validator\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Constraint
{
    private string $validator;

    private ?string $message = null;

    public function __construct(string $validator, ?string $message = null)
    {
        $this->validator = $validator;
        $this->message = $message ?? 'This cannot be empty';
    }

    /**
     * Get the value of validator
     */
    public function getValidator(): string
    {
        return $this->validator;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
