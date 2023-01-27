<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'apartment_id',
        'content',
        'guest_name',
        'guest_email'
    ];

    public function apartment()
    {
        return $this->belongsTo('App\Model\Apartment');
    }
}
