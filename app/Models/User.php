<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'npp',
        'npp_supervisor',
        'password',
    ];

    public function ePresence()
    {
        return $this->hasMany(Epresence::class, 'id_users');
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Use bcrypt for password hashing
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = bcrypt($user->password);
        });
    }
}
