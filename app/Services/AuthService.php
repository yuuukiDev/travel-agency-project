<?php

namespace App\Services;

use App\Events\UserVerificationRequested;
use App\Exceptions\PasswordException;
use App\Exceptions\UserStatusException;
use App\Models\User;
use App\Notifications\PasswordChangedNotification;
use App\Utils\Constants;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Create a new class instance.
     */

    private function generateAccessToken (User $user)
    {
        return $user->createToken('Personal Access Token')->plainTextToken;
    }
    private function findOTP($data)
    {
        $user = User::whereEmail($data['email'])
            ->whereVerificationCode($data['code'])
            ->firstOrFail();

        return $user;
    }

    public function register($data)
    {
        $user = User::create($data);

        event(new UserVerificationRequested($user));

        return [
            'user' => $user,
            'access_token' => $this->generateAccessToken($user)
        ];
    }

    public function verify($data)
    {
        $user = $this->findOTP($data);

        $user->update([
            'is_active' => Constants::$USER_IS_ACTIVE,
            'verification_code' => null,
        ]);

        return [
            'user' => $user,
            'access_token' => $this->generateAccessToken($user)
        ];
    }

    public function login($data)
    {
        $user = User::whereEmail($data['email'])->firstOrFail();

        if (! Hash::check($data['password'], $user->password)) {
            throw PasswordException::incorrect();
        }

        if ($user->is_active != Constants::$USER_IS_ACTIVE) {
            throw UserStatusException::notActiveOrBlocked();
        }

        return [
            'user' => $user,
            'access_token' => $this->generateAccessToken($user)
        ];
    }

    public function forgetPassword($data)
    {
        $user = User::whereEmail($data['email'])->firstOrFail();

        event(new UserVerificationRequested($user));

        return $user;
    }

    public function checkOTP($data)
    {
        $user = $this->findOTP($data);

        return [
            'user' => $user,
            'access_token' => $this->generateAccessToken($user)
        ];
    }

    public function resetPassword($data)
    {

        $user = auth()->user();

        if (Hash::check($data['password'], $user->password)) {
            throw PasswordException::sameAsCurrent();
        }

        $user->update([
            'password' => $data['password'],
        ]);

        $user->tokens()->delete();

        $user->notify(new PasswordChangedNotification(env('ADMIN_EMAIL ')));

        return $user;
    }

    public function logout()
    {
        $user = auth()->user();

        $user->tokens()->delete();

        return $user;
    }
}
