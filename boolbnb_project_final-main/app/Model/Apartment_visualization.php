<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Apartment_visualization extends Model
{
    protected $fillable = [
        'apartment_id',
        'visualization_date',
        'ip_address'
    ];

    public function apartment()
    {
        return $this->belongsTo('App\Model\Apartment');
    }
}
