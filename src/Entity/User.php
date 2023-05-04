<?php

namespace App\Entity;

use Sruuua\Validator\Constraint;
use Sruuua\Validator\Constraint\String\EmailValidator;
use Sruuua\Validator\Constraint\Int\IntegerValidator;
use Sruuua\Validator\Constraint\String\PasswordValidator;
use Sruuua\Validator\Constraint\String\StringValidator;

class User
{
    #[Constraint(IntegerValidator::class, 'boloss', ctx: ['minValue' => 20, 'maxValue' => 50, 'multipleMessages' => true, 'multipleOf' => 2])]
    private int $id;

    #[Constraint(EmailValidator::class, 'Veuillez remplir l\'email')]
    private string $email;

    #[Constraint(PasswordValidator::class, 'Mot de passe non conforme', ['multipleMessages' => true, 'upperMsg' => 'Veuillez mettre une majuscule', 'numericMsg' => 'Veuillez mettre un nombre'])]
    private string $password;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }
}
