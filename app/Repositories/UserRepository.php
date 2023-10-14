<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements IUserRepository
{
    public function create(array $data)
    {
        try {
            return User::create($data);
        } catch (Exception $e) {
            // log and handel error
        }
    }

    public function findByEmail(string $email)
    {

        return User::where('email', $email)->first();
    }

    public function validateCredentials($user, $password)
    {
        return Hash::check($password, $user->password);
    }

    public function generatePasswordResetToken($user)
    {
        $token = Str::random(60);
        $user->password_reset_token = $token;
        $user->password_reset_token_expiry = now()->addHours(1);
        $user->save();
        return;
    }

    public function validateToken($user, $token)
    {
        return $user->password_reset_token == $token && $user->password_reset_token_expiry > now();
    }
    
    public function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }
}
