<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration'
    ];

    public function apartments()
    {
        return $this->belongsToMany('App\Model\Apartment')->withPivot(['transaction_code', 'starting_time','ending_time']);
    }
}
