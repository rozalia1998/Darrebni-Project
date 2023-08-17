<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile_phone',
        'role',
        'fcm_token'
    ];

    public function code(): HasOne
    {
        return $this->hasOne(Code::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'imporataces')
            ->withTimestamps();
    }

    public function feedback()
    {
        $this->hasMany(FeedBack::class);
    }


}
