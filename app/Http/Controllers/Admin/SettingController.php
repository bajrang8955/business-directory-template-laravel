<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller {



	public function getIndex()
    {

    	$settings = Setting::all();

    	//$result = Setting::where("key","=","test")->first();
    	//print($result->value);

    	//$settings = Settings();
    	return view('backend/setting/index', array("settings" => $settings));

    }


    public function postIndex(Request $request)
    {

    	$settings = Setting::all();

    	foreach($settings as $setting){
    		$cur_key = $setting->key;
    		$setting->value = $request->$cur_key;
    		$setting->save();
    	}


    	flash()->success('Settings updated successfully.');
    	return redirect('admin/settings');

    }

}