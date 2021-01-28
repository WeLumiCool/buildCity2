<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'email_verified_at', 'parent_id',
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

    public function desks()
    {
        return $this->belongsToMany(Desk::class, 'desk_users');
    }

    public function owners()
    {
        return $this->hasMany(Desk::class);
    }
    public function parent()
    {
        return $this->belongsTo(User::class,'parent_id');
    }
    public function children()
    {
        return $this->hasMany(User::class,'parent_id');
    }
}
