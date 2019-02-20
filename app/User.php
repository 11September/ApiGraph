<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "users";

    protected $fillable = [
        'name', 'email', 'password', 'type', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function scopeActive($query)
    {
        return $query->where('status', '=', 'active');
    }

    public function changeToken()
    {
        return $this->token = Hash::make(time());
    }

    public function deletePlayerId()
    {
        return $this->player_id = null;
    }

    public function email()
    {
        return $this->email;
    }

    public function getUserToken()
    {
        return $this->token;
    }
}
