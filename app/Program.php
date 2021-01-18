<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{

    protected $fillable = ['cost', 'closing_amount'];

    public function desks()
    {
        return $this->hasMany(Desk::class);
    }
}
