<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    protected $table = 'fishes';

    protected $fillable = [
    	'id',
        'name',
        'image'
    ];

    public $timestamps = true;

    public function families()
    {
        return $this->belongsToMany(Family::class);
    }
}
