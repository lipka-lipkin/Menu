<?php

namespace App;

use App\Events\UserPush;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function makeToken()
    {
        $this->token = $this->createToken('authToken')->accessToken;
        return $this;
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function getPermission($permission)
    {
        return $this->permission()->where('name', $permission)->exists();
    }

    public function sendPush($data, $description = null)
    {
        return event(new UserPush($this, $data, $description));
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
