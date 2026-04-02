<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Account\User;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'name',
        'phone',
        'profile_picture_path',
        'user_id',
    ];

    protected $appends = [
        'profile_picture_path_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProfilePicturePathUrlAttribute(): string
    {
        /** @disregard */
        return $this->profile_picture_path
            ? Storage::disk('public')->url($this->profile_picture_path)
            : asset('static/img/default-profile-picture.svg');
    }
}
