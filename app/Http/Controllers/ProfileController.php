<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordValidationRequest;
use App\Http\Requests\ProfileRequest;
use App\Notifications\PasswordChangedNotification;
use App\Notifications\UserDeletedNotification;
use App\Services\ProfileService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    use APIResponder;

    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function update(ProfileRequest $request): JsonResponse
    {

        $user = $this->profileService->updateProfile($request->validated(), auth()->user());

        $user->notify(new PasswordChangedNotification(config('app.admin_email')));

        return $this->successResponse($user, 'Profile updated successfully!');
    }

    public function destroy(PasswordValidationRequest $request): JsonResponse
    {
        $user = $this->profileService->deleteUser($request->validated(), auth()->user());

        $user->notify(new UserDeletedNotification(config('app.admin_email')));

        return $this->successResponse($user, 'Your account has been deleted successfully!');
    }
}
