<?php

namespace App\Repositories\Interfaces;

interface IUserRepository
{
    public function create(array $data);

    public function findByEmail(string $email);

    public function validateCredentials($user, $password);

    public function generatePasswordResetToken($user);

    public function validateToken($user, $token);

    public function resetPassword($user, $password);

}
