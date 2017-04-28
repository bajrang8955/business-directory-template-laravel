<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class NewsController extends Controller {

    public function getIndex(Request $request)
    {
        $posts = Post::where("type","=","news")->orderBy('created_at', 'desc')->get();
    	return view('backend.news.index', array('posts' => $posts));
    }

    public function getCreate()
    {
        $post = new Post;
        return view('backend.news.createedit', array('post' => $post));
    }

    public function getEdit($id)
    {
        $post = Post::find($id);
        return view('backend.news.createedit', array('post' => $post));
    }

    public function getDelete($id)
    {
        $post = Post::find($id);

        if($post){
            if($post->delete()){
                flash()->success('News Post deleted successfully.');
            }else{
                flash()->error('Can not delete News Post.');
            }
        }else{
            flash()->error('Can not find News Post in database.');
        }

        return redirect('admin/news');
    }

    public function postCreateEdit(Request $request)
    {
        $newPost = false;
        $post = Post::find($request->id);

        if(!$post){
            $post = new Post;
            $newPost = true;
        }

        $post->title = $request->title;
        $post->slug = str_slug($request->title);
        $post->content = $request->content;
        $post->type = "news";

        if($post->save())
        {
            if($newPost)
            {
                flash()->success('News article created successfully.');
            }else{
                flash()->success('News article updated successfully.');
            }
            
        }else{
            flash()->error('Error occured while saving news article.');
        }

        return redirect('admin/news');


    }
  


}