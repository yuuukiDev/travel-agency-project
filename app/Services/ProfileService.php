<?php

namespace App\Services;

use App\Exceptions\PasswordException;
use App\Notifications\PasswordChangedNotification;
use App\Notifications\UserDeletedNotification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    /**
     * Create a new class instance.
     */
    private function handleAvatarUpdate($user, $avatar) // not working
    {
        $avatarPath = $avatar->store('avatars', 'public');

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => $avatarPath]);
    }

    private function changePassword($user, $data)
    {
        if ($data['current_password'] === $data['password']) {
            throw PasswordException::sameAsCurrent();
        }

        if (! Hash::check($data['current_password'], $user->password)) {
            throw PasswordException::incorrect();
        }
        $user->update(['password' => Hash::make($data['password'])]);

    }

    public function updateProfile($data, $user)
    {

        if (isset($data['avatar'])) {
            $this->handleAvatarUpdate($user, $data['avatar']);
        }

        $user->update(Arr::except($data, ['current_password', 'password', 'password_confirmation', 'avatar']));

        if (isset($data['current_password']) && isset($data['password'])) {
            $this->changePassword($user, $data);

            $user->notify(new PasswordChangedNotification(config('app.admin_email')));

        }

        return $user;
    }

    public function deleteUser($data, $user)
    {

        if (! Hash::check($data['password'], $user->password)) {
            throw PasswordException::incorrect();
        }

        $user->delete();

        $user->notify(new UserDeletedNotification(config('app.admin_email')));

        return $user;
    }
}
