<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;

use DB;

class SearchController extends Controller {



    public function getSearch(Request $request)
    {
        $main_categories = Category::where('parent_id', null)->get();

        $listing = new Listing;
        $listing = $listing->where("approved","=",true);

        if(!empty($request->keyword)){

            $listing = $listing->where(function($query) use ($request){
                $query->where('title', 'LIKE', '%'. $request->keyword .'%')
                      ->orWhere('description', 'LIKE', '%'. $request->keyword .'%');
            });

        }

        if(!empty($request->categories)){
            $listing = $listing->whereHas('categories', function($query) use ($request) {
                $query->whereIn('id', $request->categories);
            });

        }

        if(!empty($request->lat) && !empty($request->lng)){
            $lat = $request->lat;
            $lng = $request->lng;
            $radius = empty($request->radius) ? 20 : $request->radius;

            $listing = $listing->whereRaw('SQRT( POW(69.1 * (latitude - '.$lat.'), 2) + POW(69.1 * ('.$lng.' - longitude) * COS(latitude / 57.3), 2)) < '.$radius);

        }

        $result_count = $listing->count();

        $listings = $listing->orderBy('created_at', 'desc')->paginate(10);
        $listings->setPath('');

        

        return view('frontend/search', array('listings' => $listings, 'main_categories' => $main_categories, 'result_count' => $result_count));

    }

}