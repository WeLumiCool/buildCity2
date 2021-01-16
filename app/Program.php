<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{

    protected $fillable = ['cost', 'closing_amount'];

    public function desk()
    {
        return $this->belongsTo(Desk::class);
    }
}
