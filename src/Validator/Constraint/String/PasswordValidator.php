<?php

namespace App\Validator\Constraint\String;

use App\Validator\Exception\OptionNotExist;
use App\Validator\Interface\ValidatorConfigurableInterface;
use App\Validator\Interface\ValidatorInterface;

class PasswordValidator implements ValidatorInterface, ValidatorConfigurableInterface
{
    private array $context;

    public function supports(mixed $data): bool
    {
        return is_string($data);
    }

    public function validate(mixed $data): bool|array
    {
        $isValid = true;
        $errors = array();

        if ($this->context['upper']) {
            $isValid &= preg_match('/[A-Z]/', $data);
            $errors['upper'] = $this->context['upperMsg'];
        }

        if ($this->context['numeric']) {
            $isValid &= preg_match('/[1-9]/', $data);
            $errors['numeric'] = $this->context['numericMsg'];
        }

        if ($this->context['special']) {
            $isValid &=  preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data);
            $errors['special'] = $this->context['specialMsg'];
        }

        if (strlen($data) <= $this->context['lenght']) {
            $isValid = false;
            $errors['lenght'] = sprintf('Password must be at least %d character long', $this->context['lenght']);
        }

        if ($this->context['multipleMessages']) {
            return $errors;
        }

        return $isValid;
    }

    /**
     * Configure the password parameters
     */
    public function configure(array $ctx)
    {
        $this->setDefault();
        foreach ($ctx as $option => $value) {
            if (!isset($this->context[$option])) {
                $optList = '';
                foreach ($this->context as $opt => $a) {
                    $optList .= $opt . ' ';
                }
                throw new OptionNotExist(sprintf("%s class does not have %s option.\nAvailable option are : %s", __CLASS__, $option, $optList));
            }
            $this->context[$option] = $value;
        }
    }

    public function setDefault()
    {
        $this->context = [
            'special' => true,
            'numeric' => true,
            'upper' => true,
            'lenght' => 8,
            'regex' => false,
            'multipleMessages' => false,
            'upperMsg' => 'Password must contains an uppercase',
            'numericMsg' => 'Password must contains an digit',
            'specialMsg' => 'Password must contains an special character',
        ];
    }
}
