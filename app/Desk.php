<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desk extends Model
{

    protected $fillable = ['user_id', 'program_id', 'balance', 'is_closed'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'desk_users');
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
