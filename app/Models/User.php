<?php

namespace App\Models;

use App\Traits\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Symfony\Component\HttpFoundation\StreamedResponse;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, MustVerifyEmail, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'profile_picture',
        'phone',
        'birthdate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'phone',
        'birthdate'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'date'
    ];

    /**
     * Generate Personal Access Token for authentication.
     * @param bool $rememberMe
     * @return mixed
     */
    public function createPersonalAccessToken(?bool $rememberMe = false)
    {
        $tokenResult = $this->createToken('Personal Access Token', ['*']);
        $token = $tokenResult->accessToken;

        if ($rememberMe) {
            $token->expires_at = now()->addWeeks(1);
        }

        $token->save();

        return [
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
        ];
    }

    /**
     * Profile Image
     */

    /**
     * Get profile image helper
     * @return StreamedResponse|null
     */
    public function getProfileImage(): ?StreamedResponse
    {
        if ($this->profile_picture) {
            // Save web link image in db
            if (str_starts_with($this->profile_image, 'http')) return $this->profile_image;

            return Storage::disk('public')->response('profile_pictures/' . $this->profile_picture);
        }

        return null;
    }

    /**
     * Set profile image helper
     * @param $image Image Request Image (must be validated)
     * @return string String with the path of the image
     */
    public function setProfileImage($image): string
    {
        $path = $image->store('profile_images');
        $this->fill(['profile_image' => $path])->save();

        return $path;
    }
}
