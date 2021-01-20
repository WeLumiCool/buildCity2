<?php

namespace App;

use App\Program;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Desk extends Model
{

    protected $fillable = ['user_id', 'program_id', 'balance', 'is_closed'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'desk_users');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function public_store($program_id, $user_id)
    {
        $desk = new Desk();
        $desk->program_id = $program_id;
        $desk->user_id = $user_id;
        $desk->code = self::get_code();
        $desk->is_closed = false;
        $desk->save();
    }

    public static function get_code()
    {
        $str = '';
        do {
            $str = '';
            for ($i = 0; $i < 6; $i++) {
                $str .= rand(0, 9);
            }
        } while (Desk::where('code', $str)->exists());
        return $str;
    }
}
