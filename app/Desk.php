<?php

namespace App;

use App\Program;
use Illuminate\Database\Eloquent\Model;

class Desk extends Model
{

    protected $fillable = ['user_id', 'program_id', 'balance', 'is_closed'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'desk_users');
    }
//    public function owners()
//    {
//        return $this->hasMany();
//    }
    public function program()
    {
        return $this->hasMany(Program::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
