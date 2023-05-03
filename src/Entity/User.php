<?php

namespace App\Entity;

use App\Validator\Constraint;
use App\Validator\Constraint\String\EmailValidator;

class User
{
    #[Constraint(EmailValidator::class, 'Veuillez remplir l\'email')]
    private string $email;

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
}
