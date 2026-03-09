<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\SecureProfilePhotoService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'photo' => [
                'nullable',
                'file',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:2048',
            ],
        ], [
            'photo.file' => 'La foto debe ser un archivo válido.',
            'photo.mimetypes' => 'La foto debe ser JPG, PNG o WEBP.',
            'photo.max' => 'La foto no debe exceder los 2 MB.',
        ])->validateWithBag('updateProfileInformation');

        $attributes = [
            'name' => $input['name'],
            'email' => $input['email'],
        ];

        $oldPhotoPath = $user->profile_photo_path;

        if (isset($input['photo'])) {
            $stored = app(SecureProfilePhotoService::class)->store($input['photo'], $user->id);
            $attributes['profile_photo_path'] = $stored['ruta'];
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $attributes);
        } else {
            $user->forceFill($attributes)->save();
        }

        if (
            isset($attributes['profile_photo_path']) &&
            $oldPhotoPath &&
            $oldPhotoPath !== $attributes['profile_photo_path']
        ) {
            Storage::disk('private')->delete($oldPhotoPath);
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
