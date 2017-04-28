<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingCategories extends Model
{
    protected $table = 'listing_categories';

    public function listing()
    {
        return $this->belongsTo('App\Models\Listing');
    }
   
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
