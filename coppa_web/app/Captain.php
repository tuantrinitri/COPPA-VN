<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Captain extends Model
{
    protected $table = 'captains';

    protected $fillable = [
    	'id',
        'fullname',
        'phone',
        'vessel'
    ];

    public $timestamps = true;

    public function trips()
    {
        return $this->belongsToMany(Trip::class);
    }
}
