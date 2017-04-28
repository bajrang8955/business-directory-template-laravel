<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;


class CategoryController extends Controller {

    public function getIndex($categoryid, $slug = "")
    {
        $category = Category::find($categoryid);

        if(!$category){
            flash()->error('This category does not exist.');
            return redirect('');
        }

        if($slug != $category->slug){
            return redirect('category/'.$category->id.'/'.$category->slug, 301);
        }

        $listings = $category->listings()->where("approved","=",true)->orderBy('created_at', 'desc')->paginate(10);
        $listings->setPath('');

        $main_categories = Category::where('parent_id', null)->get();

        return view('frontend/category', array('category' => $category, 'listings' => $listings, 'main_categories' => $main_categories));

    }

}