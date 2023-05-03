<?php

namespace App\Validator\Constraint\String;

use App\Validator\Exception\OptionNotExist;
use App\Validator\Interface\ValidatorConfigurableInterface;
use App\Validator\Interface\ValidatorInterface;

class PasswordValidator implements ValidatorInterface, ValidatorConfigurableInterface
{
    private array $ctx;

    public function supports(mixed $data): bool
    {
        return is_string($data);
    }

    public function validate(mixed $data): bool
    {
        return filter_var($data, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Configure the password parameters
     */
    public function configure(array $ctx)
    {
        $this->setDefault();
        foreach ($ctx as $option => $value) {
            if (!isset($this->ctx[$option])) {
                $optList = '';
                foreach ($this->ctx as $opt => $a) {
                    $optList .= $opt . ' ';
                }
                throw new OptionNotExist(sprintf("%s class does not have %s option.\nAvailable option are : %s", __CLASS__, $option, $optList));
            }
            $this->ctx[$option] = $value;
        }
    }

    public function setDefault()
    {
        $this->ctx = [
            'special' => true,
            'numeric' => true,
            'upper' => true,
            'regex' => false,
        ];
    }
}
