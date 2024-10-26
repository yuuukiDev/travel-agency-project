<?php

namespace App\Services;

use App\Exceptions\PasswordException;
use App\Notifications\PasswordChangedNotification;
use App\Notifications\UserDeletedNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Arr;

class ProfileService
{
    /**
     * Create a new class instance.
     */


     public function updateProfile($data)
     {
        $user = auth()->user(); 


        if(isset($data['avatar'])){

            $avatar = $data['avatar']->store('avatars', 'public');

            if($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->update([
                'avatar' => $avatar
            ]);
        }
        $user->update(Arr::except($data, ['current_password', 'password', 'password_confirmation', 'avatar']));

        if (isset($data['current_password']) && isset($data['password'])) {

            if ($data['current_password'] === $data['password']) {
                throw PasswordException::sameAsCurrent();
            }

            if (!Hash::check($data['current_password'], $user->password)) {
                throw PasswordException::incorrect();
            }

            $user->update(['password' => $data['password']]);

            $user->notify(new PasswordChangedNotification(env('ADMIN_EMAIL ')));

            return $user;
        }
     }

     public function deleteProfile($data)
     {
        $user = auth()->user();

        if(!Hash::check($data['password'], $user->password)) {
                throw PasswordException::incorrect();
        }

        $user->delete();

        $user->notify(new UserDeletedNotification(env('ADMIN_EMAIL ')));

        return $user;
     }
}