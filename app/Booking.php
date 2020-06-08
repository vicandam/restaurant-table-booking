<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'table_id', 'date', 'time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
