<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class NewsController extends Controller {

    public function getIndex()
    {
        $posts = Post::where("type","=","news")->orderBy('created_at', 'desc')->get();
        return view('frontend.news.index', array('posts' => $posts));
    }

    public function getPost($id, $slug = "")
    {
     
        $post = Post::find($id);

        if(!$post){
            flash()->error('This News Article does not exist.');
            return redirect('');
        }

        if($slug != $post->slug){
            return redirect('news/'.$post->id.'/'.$post->slug, 301);
        }

        return view('frontend.news.post', array('post' => $post));

    }

}