<?php

namespace App\Model;

class LoginDTO
{
    private ?string $email = null;
    private ?string $password = null;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return LoginDTO
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return LoginDTO
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}
