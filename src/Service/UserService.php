<?php

namespace App\Service;

class UserService
{
    /**
     * @param string $password
     * @return string
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param string $inputPassword
     * @param string $password
     * @return bool
     */
    public static function validatePassword(string $inputPassword, string $password): bool
    {
        return password_verify($inputPassword, $password);
    }
}
