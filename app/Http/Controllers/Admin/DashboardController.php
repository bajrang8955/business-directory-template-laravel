<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;

class DashboardController extends Controller {

    public function getIndex()
    {
    	$usercount = User::count();
    	$listingcount = Listing::where("approved","=",true)->count();
    	return view('backend/dashboard', array('usercount' => $usercount, 'listingcount' => $listingcount));
    }

}