<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'records';

    protected $fillable = [
        'id',
        'fish_id',
        'long',
        'weight',
        'lat',
        'lng',
        'images',
        'catched_at'
    ];

    public $timestamps = true;

    public function trips()
    {
        return $this->belongsToMany(Trip::class);
    }
}