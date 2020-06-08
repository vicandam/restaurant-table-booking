<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'capacity', 'status'
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
