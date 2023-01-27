<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Apartment extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'rooms_number',
        'bathrooms_number',
        'beds_number',
        'square_meters',
        'price_per_night',
        'address',
        'latitude',
        'longitude',
        'is_visible',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function messages()
    {
        return $this->hasMany('App\Model\Message');
    }

    public function apartment_images()
    {
        return $this->hasMany('App\Model\Apartment_image');
    }

    public function services()
    {
        return $this->belongsToMany('App\Model\Service');
    }

    public function sponsorships()
    {
        return $this->belongsToMany('App\Model\Sponsorship')->withPivot(['transaction_code', 'starting_time','ending_time']);
    }

    public function apartment_visualizations()
    {
        return $this->hasMany('App\Model\Apartment_visualization');
    }
}
