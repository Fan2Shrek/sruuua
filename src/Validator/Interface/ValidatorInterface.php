<?php

namespace App\Validator\Interface;

interface ValidatorInterface
{
    /**
     * Validate all types of data and return an bool
     * 
     * @param mixed $data
     * 
     * @return bool
     */
    public function validate(mixed $data): bool;

    /**
     * Check if the validator can support a type of data
     * 
     * @param mixed $data
     * 
     * @return bool
     */
    public function supports(mixed $data): bool;
}
