<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'families';

    protected $fillable = [
    	'id',
        'name',
        'image'
    ];

    public $timestamps = true;

    public function fishes()
    {
        return $this->belongsToMany(Fish::class);
    }
}
