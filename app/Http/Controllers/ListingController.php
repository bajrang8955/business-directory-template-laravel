<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Category;
use App\Models\OpeningTime;
use App\Models\Setting;
use App\Models\Claim;
use Auth, File, Image, Validator, Entrust;


class ListingController extends Controller {

    public function getCreate()
    {
        $listing = new Listing();
        $main_categories = Category::where('parent_id', null)->get();
        return view('frontend/listing/createedit', array('main_categories' => $main_categories, 'listing' => $listing));
    }

    public function getEdit($listingid)
    {

        $listing = Listing::find($listingid);

        if(!$listing){
            flash()->warning('Can`t find this listing.');
            return redirect('my-listings');
        }

        if($listing->user_id != Auth::user()->id && !Entrust::hasRole('admin')){
        	flash()->error('You are not allowed to edit this listing.');
        	return redirect('my-listings');
        }

        $openingtimes = OpeningTime::where("listing_id","=",$listingid)->get();

        $openingtimes = array();
        $openingtimes['Monday'] = OpeningTime::where("weekday","=","Monday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Tuesday'] = OpeningTime::where("weekday","=","Tuesday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Wednesday'] = OpeningTime::where("weekday","=","Wednesday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Thursday'] = OpeningTime::where("weekday","=","Thursday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Friday'] = OpeningTime::where("weekday","=","Friday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Saturday'] = OpeningTime::where("weekday","=","Saturday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Sunday'] = OpeningTime::where("weekday","=","Sunday")->where("listing_id","=",$listingid)->first();


        $main_categories = Category::where('parent_id', null)->get();
        $selected_categories = $listing->categories()->select('categories.id AS id')->lists('id')->all();
        return view('frontend/listing/createedit', array('listing' => $listing, 'main_categories' => $main_categories, 'selected_categories' => $selected_categories, 'openingtimes' => $openingtimes));
    }

    public function postCreateEdit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:50',
            'description' => 'max:2000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


    	$newListing = false;
        $listing = Listing::find($request->id);

        if($listing){
            if($listing->user_id != Auth::user()->id && !Entrust::hasRole('admin')){
                flash()->error('You are not allowed to edit this listing.');
                return redirect('my-listings');
            }
        }

        if(!$listing){
            if(Auth::user()->listings()->count() >= (int)Setting::get("user_listings_limit")){
                flash()->error('You reached the limit of allowed listings.');
            }

        	$listing = new Listing;
        	$newListing = true;
        	$listing->user_id = Auth::user()->id;
        }

        $listing->title = $request->title;
        $listing->slug = str_slug($request->title);
        $listing->description = $request->description;
        $listing->address = $request->address;
        $listing->service_area = $request->service_area;
        $listing->email = $request->email;
        $listing->facebook = $request->facebook;
        $listing->twitter = $request->twitter;
        $listing->website = $request->website;
        $listing->phone = $request->phone;
        $listing->phone_afterhours = $request->phone_afterhours;
        $listing->longitude = $request->lng;
        $listing->latitude = $request->lat;
        $listing->approved = false;
        $listing->spam = false;

        // logo
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $filename  = str_random(16) . '.' . $image->getClientOriginalExtension();

            $path = public_path('img/listing/logo/'.$filename);

            $img = Image::make($image->getRealPath())->resize(300, 300, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); });
            Image::canvas($img->width(),$img->height(), '#ffffff')->insert($img)->save($path, 100);

            $listing->logo = $filename;
        }


        if($listing->save()){

            // categories
            $listing->categories()->detach();
            if(is_array($request->categories)){
                foreach($request->categories as $cid){
                    $listing->categories()->attach($cid);
                }
            }

            // opening times
            $listing->openingtimes()->delete();
            $openingtimes = array();

            if(!empty($request->monday_start))
                $openingtimes[] = new OpeningTime(['weekday' => 'Monday', 'start' => $request->monday_start, 'end' => $request->monday_end]);
            if(!empty($request->tuesday_start))
                $openingtimes[] = new OpeningTime(['weekday' => 'Tuesday', 'start' => $request->tuesday_start, 'end' => $request->tuesday_end]);
            if(!empty($request->wednesday_start))
                $openingtimes[] = new OpeningTime(['weekday' => 'Wednesday', 'start' => $request->wednesday_start, 'end' => $request->wednesday_end]);
            if(!empty($request->thursday_start))
                $openingtimes[] = new OpeningTime(['weekday' => 'Thursday', 'start' => $request->thursday_start, 'end' => $request->thursday_end]);
            if(!empty($request->friday_start))
                $openingtimes[] = new OpeningTime(['weekday' => 'Friday', 'start' => $request->friday_start, 'end' => $request->friday_end]);
            if(!empty($request->saturday_start))
                $openingtimes[] = new OpeningTime(['weekday' => 'Saturday', 'start' => $request->saturday_start, 'end' => $request->saturday_end]);
            if(!empty($request->sunday_start))
                $openingtimes[] = new OpeningTime(['weekday' => 'Sunday', 'start' => $request->sunday_start, 'end' => $request->sunday_end]);

            $listing->openingtimes()->saveMany($openingtimes);


        	if($newListing){
        		flash()->success('Listing submitted successfully.');
        	}else{
        		flash()->success('Listing updated successfully.');
        	}
        }else{
        	flash()->error('Error occured while saving listing.');
        }
        

        return redirect('my-listings');

    }

    public function getMyListings()
    {
    	$listings = Auth::user()->listings()->orderBy('created_at', 'desc')->paginate(10);
        $listings->setPath('');

    	return view('frontend/listing/mylistings', array('listings' => $listings));
    }

    public function getListing($listingid, $slug = "")
    {
        $listing = Listing::find($listingid);

        if(!$listing){
            flash()->error('This listing does not exist.');
            return redirect('');
        }

        if($slug != $listing->slug){
            return redirect('listing/'.$listing->id.'/'.$listing->slug, 301);
        }

        if($listing->approved == false && !Entrust::hasRole('admin')){
            flash()->warning('The requested listing is under review.');
            return redirect('');
        }

        $phone_encoded = $this->strToHex($listing->phone);
        $phone_after_encoded = $this->strToHex($listing->phone_afterhours);
        $email_encoded = $this->strToHex($listing->email);


        // opening times for view
        $openingtimes = array();
        $openingtimes['Monday'] = OpeningTime::where("weekday","=","Monday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Tuesday'] = OpeningTime::where("weekday","=","Tuesday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Wednesday'] = OpeningTime::where("weekday","=","Wednesday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Thursday'] = OpeningTime::where("weekday","=","Thursday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Friday'] = OpeningTime::where("weekday","=","Friday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Saturday'] = OpeningTime::where("weekday","=","Saturday")->where("listing_id","=",$listingid)->first();
        $openingtimes['Sunday'] = OpeningTime::where("weekday","=","Sunday")->where("listing_id","=",$listingid)->first();

        return view('frontend/listing/view',
            array('listing' => $listing,
                'openingtimes' => $openingtimes,
                'phone_encoded' => $phone_encoded,
                'phone_after_encoded' => $phone_after_encoded,
                'email_encoded' => $email_encoded
                ));
    }

    public function getDelete($listingid)
    {
        $listing = Listing::find($listingid);

        if($listing){

            if($listing->user_id != Auth::user()->id){
                flash()->error('Permission denied.');
            }else{
                if($listing->delete()){
                    flash()->success('Listing deleted successfully.');
                }else{
                    flash()->error('Can not delete Listing.');
                }
            }

        }else{
            flash()->error('Can not find Listing in database.');
        }

        return redirect('my-listings');

    }

    public function getClaim($listingid)
    {
        $listing = Listing::find($listingid);

        if($listing && $listing->user_id == NULL){

            $claim = Claim::where("user_id",Auth::user()->id)->where("listing_id",$listing->id)->first();

            if(!$claim){
                $claim = new Claim(); 
                $claim->listing_id = $listing->id;
                $claim->user_id = Auth::user()->id;

                if($claim->save()){
                    flash()->success("Thank you for claiming this listing. We will review your claim and send you an email soon.");
                }else{
                    flash()->success("Error occured while claiming this listing.");
                }   

            }else{
                flash()->success("Thank you for claiming this listing. We will review your claim and send you an email soon.");
            }

       

        }else{
            flash()->success("You can't claim this listing.");
        }


        return back();


    }


    public function strToHex($string){
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return strToUpper($hex);
    }

}