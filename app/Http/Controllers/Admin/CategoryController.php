<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller {

    public function getIndex()
    {
        $main_categories = Category::where('parent_id', null)->orderBy('order')->get();
    	return view('backend/category/index', array('main_categories' => $main_categories));
    }

    public function getEdit($categoryid)
    {
        $category = Category::find($categoryid);
        $categories = Category::where('parent_id', null)->get();
        return view('backend/category/createedit', array('category' => $category, 'categories' => $categories));
    }

    public function getCreate()
    {
        $category = new Category();
    	$categories = Category::where('parent_id', null)->get();
        return view('backend/category/createedit', array('category' => $category, 'categories' => $categories));
    }

    public function postCreateEdit(Request $request)
    {
    	$newCategory = false;
        $category = Category::find($request->id);

        if(!$category){
        	$category = new Category;
        	$newCategory = true;
        }

        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        $category->icon = (!is_null($request->icon))?$request->icon:null;
        $category->icon_color = (!is_null($request->icon_color))?$request->icon_color:null;
        $category->icon_bgcolor = (!is_null($request->icon_bgcolor))?$request->icon_bgcolor:null;
        $category->parent_id = (is_numeric($request->parentid))?$request->parentid:null;
        $category->order = (isset($request->order) && is_numeric($request->order))?$request->order:0;

        if($category->save()){
        	if($newCategory){
        		flash()->success('Category created successfully.');
        	}else{
        		flash()->success('Category updated successfully.');
        	}
        }else{
        	flash()->error('Error occured while saving category.');
        }
        

        return redirect('admin/categories');

    }

    public function getDelete($categoryid)
    {
        $category = Category::find($categoryid);

        if($category){
            if($category->delete()){
                flash()->success('Category deleted successfully.');
            }else{
                flash()->error('Can not delete Category.');
            }
        }else{
            flash()->error('Can not find Category in database.');
        }

        return redirect('admin/categories');

    }


}