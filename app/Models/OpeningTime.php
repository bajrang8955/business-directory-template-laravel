<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningTime extends Model
{
    protected $table = 'openingtimes';

    protected $fillable = array( 'weekday', 'start', 'end' );

    public $timestamps = false;



    public function listing()
    {
        return $this->belongsTo('App\Models\Listing');
    }
    
}
