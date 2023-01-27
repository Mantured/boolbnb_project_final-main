<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Apartment_image extends Model
{
    protected $fillable = [
        'apartment_id',
        'image_path'
    ];

    public function apartment()
    {
        return $this->belongsTo('App\Model\Apartment');
    }
}
