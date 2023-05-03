<?php

namespace App\Validator\Constraint\String;

use App\Validator\Constraint\AbstractConfigurableValidator;

class StringValidator extends AbstractConfigurableValidator
{
    public function supports(mixed $data): bool
    {
        return is_string($data);
    }

    public function validate(mixed $data): bool|array
    {
        $errors = array();

        if (strlen($data) < $this->context['minLenght']) {
            $errors['minLenght'] = $this->context['minLenghtMsg'];
        }

        if (strlen($data) >= $this->context['maxLenght']) {
            $errors['maxLenght'] = $this->context['maxLenghtMsg'];
        }

        if (empty($errors)) return true;

        if ($this->context['multipleMessages']) {
            return $errors;
        }

        return false;
    }

    public function setDefault()
    {
        $this->context = [
            'minLenght' => 3,
            'maxLenght' => 2048,
            'maxLenghtMsg' => 'This field is too long',
            'minLenghtMsg' => 'This field must be at least 3 characters long',
            'multipleMessages' => false,
        ];
    }
}
