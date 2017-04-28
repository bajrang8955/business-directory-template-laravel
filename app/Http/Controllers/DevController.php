<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;

use Geocoder;

class DevController extends Controller {


    /**
     * Function to update Geolocations after import
     * EXPERIMENTAL !!
     * @return [type] [description]
     */
    public function getUpdateGeolocations()
    {

        $listings = Listing::where(function($query) {
            $query->whereNull('longitude')
                  ->orWhereNull('latitude');
        })->whereNotNull("address")->where("address","!=","")->get();

        foreach($listings as $listing)
        {

            $param = array("address"=>$listing->address);
            $response = \Geocoder::geocode('json', $param);
            $response_obj = json_decode($response);
            
            if($response_obj->status = "OK" && $response_obj->status  != "ZERO_RESULTS"){
                $listing->latitude = $response_obj->results[0]->geometry->location->lat;
                $listing->longitude = $response_obj->results[0]->geometry->location->lng;
                //$formatted_address = $response_obj->results[0]->formatted_address;
            }    

            print("Updated: ".$listing->title."<br/>");

            $listing->save(); 
        }

        print("Update Geolocations completed.");


        exit();

    }


}