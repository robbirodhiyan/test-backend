<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Epresence extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_users',
        'type',
        'is_approve',
        'waktu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function getWaktuAttribute($value)
    {
        return Carbon::parse($value);
    }
}
