<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use App\Models\OpeningTime;
use App\Models\Setting;
use App\Models\Post;

use DB, URL, Settings, File, Image, Cache, Mailchimp;

class DefaultController extends Controller {

    public function getHome()
    {

        # cached frontpage listings for map
        $listings = Cache::remember('frontpage_listings', 60, function() {
            return Listing::where("approved","=",true)->get();
        });

        # cached markers
        $markers = Cache::remember('frontpage_markers', 60, function() use ($listings) {
            $markers = array();
            foreach($listings as $listing){
                $markers[] = array($listing->title, $listing->latitude, $listing->longitude);
            }
            return $markers;
        });

        # cached infoWindowContent
        $infoWindowContent = Cache::remember('frontpage_infowindowcontent', 60, function() use ($listings) {
            $infoWindowContent = array();
            foreach($listings as $listing){
                $logo_url = (isset($listing) && $listing->logo != null)?URL::to('img/listing/logo/'.$listing->logo):'';
                $logo_html =  ($logo_url != '')? '<img class="img-responsive" style="max-width:180px;max-height:80px;" alt="" src="'.$logo_url.'" />' : '' ;
                $infoWindowContent[] = array($logo_html.'<h3>'.$listing->title.'</h3><p>'.str_limit($listing->description, 120).' <a href="'.URL::to('listing/'.$listing->id.'/'.$listing->slug).'">[ read more ]</a></p>');
            }
            return $infoWindowContent;
        });

        $news = Post::where("type","=","news")->orderBy('created_at', 'desc')->take(3)->get();
    	$main_categories = Category::where('parent_id', null)->orderBy('order')->get();
        return view('frontend/home', array('markers' => $markers, 'infoWindowContent' => $infoWindowContent, 'main_categories' => $main_categories, 'news' => $news));
    }

    public function postSubscribeNewsletter(Request $request)
    {

        try {
            if(Setting::get("use_mailchimp") == "1") {
                Mailchimp::subscribe(Setting::get("mailchimp_list_id"), $request->email, [], true);
            }

            flash()->success('You have successfully subscribed to our newsletter.');
        } catch (Exception $e) {
            flash()->success('An error occured.');
        }

        return redirect('');

    }


    public function getPrivacyPolicy()
    {
        return view('frontend/privacypolicy');
    }

    public function getFAQ()
    {
        return view('frontend/faq');
    }

    public function getTermsConditions()
    {
        return view('frontend.termsconditions');
    }



}