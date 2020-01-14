<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table = 'trips';

    protected $fillable = [
    	'id',
        'from_date',
        'to_date',
        'description'
    ];

    public $timestamps = true;

    public function captains()
    {
        return $this->belongsToMany(Captain::class);
    }

    public function records()
    {
        return $this->belongsToMany(Record::class);
    }
}
