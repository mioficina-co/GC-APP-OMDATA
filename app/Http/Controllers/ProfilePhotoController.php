<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    public function show(Request $request, User $user)
    {
        abort_unless($request->user() && $request->user()->is($user), 403);

        abort_unless(
            $user->profile_photo_path && Storage::disk('private')->exists($user->profile_photo_path),
            404
        );

        return Storage::disk('private')->response(
            $user->profile_photo_path,
            'profile-photo.jpg',
            [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'inline; filename="profile-photo.jpg"',
                'X-Content-Type-Options' => 'nosniff',
                'Cache-Control' => 'private, max-age=300',
            ]
        );
    }
}
