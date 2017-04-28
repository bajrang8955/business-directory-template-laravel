<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\User;
use App\Models\Category;
use App\Models\OpeningTime;
use App\Models\Claim;
use Auth, File, Image, Hash, Mail, Validator;

class ListingController extends Controller {

    public function getIndex(Request $request)
    {
        $listings = new Listing;

        if(!empty($request->q))
        {
            $listings = $listings->where("title","LIKE","%".$request->q."%");
        }

        $listings = $listings->orderBy('created_at', 'desc')->paginate(20);

        $listings->setPath('');
    	return view('backend/listing/index', array('listings' => $listings));

    }

    public function getCreate()
    {
        $listing = new Listing();
        $users = User::all();
    	$main_categories = Category::where('parent_id', null)->get();
        return view('backend/listing/createedit', array('main_categories' => $main_categories, 'listing' => $listing, 'users' => $users));
    }

    public function getEdit($listingid)
    {

        $listing = Listing::find($listingid);
        $users = User::all();

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

        return view('backend/listing/createedit', array('listing' => $listing, 'main_categories' => $main_categories, 'selected_categories' => $selected_categories, 'openingtimes' => $openingtimes, 'users' => $users));
    }

    public function postCreateEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:50',
            'description' => 'max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


      	$newListing = false;
        $listing = Listing::find($request->id);

        if(!$listing){
        	$listing = new Listing;
        	$newListing = true;

            if(isset($request->user))
            {
                $listing->user_id = empty($request->user)? Auth::user()->id : $request->user ;
            }
        	
        }

        $listing->title = $request->title;
        $listing->slug = str_slug($request->title);
        $listing->description = $request->description;
        $listing->address = $request->address;
        $listing->service_area = $request->service_area;
        $listing->email = $request->email;
        $listing->website = $request->website;
        $listing->facebook = $request->facebook;
        $listing->twitter = $request->twitter;
        $listing->phone = $request->phone;
        $listing->phone_afterhours = $request->phone_afterhours;
        $listing->longitude = $request->lng;
        $listing->latitude = $request->lat;
        $listing->verified = $request->verified;
        $listing->approved = $request->approved;
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
        

        return redirect('admin/listings');

    }

    public function getVerifyListings()
    {
        $listings = Listing::where("verified","=",false)->get();
        return view('backend/listing/verifylistings', array('listings' => $listings));
    }

    public function postAjaxVerify(Request $request)
    {

        $listing = Listing::find($request->id);

        if($listing){

            // already verified
            if($listing->verified){
                return response()->json([ 'success' => true, ]);
            }

            $listing->phone = $request->phone;
            $listing->email = $request->email;
            $listing->verified = true;

            // if listing does not belong to a user check user acc with email or create user acc
            if($listing->user_id == NULL)
            {

                $user = User::where("email","=",$request->email)->first();


                if(!$user){
                    // create user
                    $user = new User;
                    $user->email = $request->email;
                    $user->confirmed = true;

                    $rnd_password = str_random(8);
                    $user->password = Hash::make($rnd_password);

                    if($user->save()){
                        Mail::send('emails.yourlisting', ['email' => $user->email, 'password' => $rnd_password, 'listingid' => $listing->id], function($message) use ($user) {
                            $message->to($user->email)->subject('Manage Your Listing');
                        });

                        Mailchimp::subscribe(Setting::get("mailchimp_list_id"), $user->email, null, false);

                        
                    }
                }

                if($user){
                    $listing->user_id = $user->id;
                }
                
            }


            if($listing->save()){
                return response()->json([ 'success' => true, ]);
            }
        }

        return response()->json([ 'success' => false, ]);
        
    }

    public function getApproveListings()
    {
        $listings = Listing::where("approved","=",false)->where("spam","=",false)->get();
        return view('backend/listing/approvelistings', array('listings' => $listings));
    }

    public function postAjaxApprove(Request $request)
    {

        $listing = Listing::find($request->id);

        if($listing){          
            $listing->approved = true;
            if($listing->save()){
                return response()->json([ 'success' => true, ]);
            }
        }

        return response()->json([ 'success' => false, ]);
        
    }

    public function postAjaxSpam(Request $request)
    {

        $listing = Listing::find($request->id);

        if($listing){          
            $listing->spam = true;
            if($listing->save()){
                return response()->json([ 'success' => true, ]);
            }
        }

        return response()->json([ 'success' => false, ]);
        
    }

    public function getDelete($listingid)
    {
    	$listing = Listing::find($listingid);

    	if($listing){
    		if($listing->delete()){
    			flash()->success('Listing deleted successfully.');
    		}else{
    			flash()->error('Can not delete Listing.');
    		}
    	}else{
    		flash()->error('Can not find Listing in database.');
    	}

    	return redirect('admin/listings');

    }

    public function getClaims()
    {
        $claims = Claim::all();
        return view('backend.listing.claims', array('claims' => $claims));
    }

    public function postAjaxClaimAssignListing(Request $request)
    {
        $claim = Claim::find($request->id);

        if($claim){

            $listing = Listing::find($claim->listing_id);

            if($listing && $listing->user_id == NULL)
            {

                $listing->user_id = $claim->user_id;
                if($listing->save())
                {
                    $claim->delete();

                    $user = User::find($listing->user_id);

                    if($user)
                    {
                        Mail::send('emails.claimsuccess', array(), function($message) use ($user) {
                            $message->to($user->email)->subject('Listing claimed successfully');
                        });
                    }

                    return response()->json([ 'success' => true, ]);

                }
            }

            
        }

        return response()->json([ 'success' => false, ]);

    }

    public function postAjaxClaimDelete(Request $request)
    {
        $claim = Claim::find($request->id);

        if($claim){
            if($claim->delete()){
                return response()->json([ 'success' => true, ]);
            }
        }

        return response()->json([ 'success' => false, ]);
    }


}