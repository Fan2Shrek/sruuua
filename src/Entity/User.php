<?php

namespace App\Entity;

use App\Validator\Constraint;
use App\Validator\Constraint\String\EmailValidator;
use App\Validator\Constraint\String\PasswordValidator;

class User
{
    #[Constraint(EmailValidator::class, 'Veuillez remplir l\'email')]
    private string $email;

    #[Constraint(PasswordValidator::class, 'Password non valide', ['upper' => false])]
    private string $password;

    private int $id;


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
