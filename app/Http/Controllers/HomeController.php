<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $id = auth()->user()->id;
        $detail = User::Find($id)->posts;
        $posts_list = [];
        if($detail){

            foreach($detail as $single_post_detail){

                $posts_list[$single_post_detail->post_id] = [

                    'author_name' => User::find($single_post_detail->author_id)->name,
                    'post_type' => $single_post_detail->post_type,
                    'post_title' => Post::find($single_post_detail->post_id)->title,
                    'post_description'=>Post::find($single_post_detail->post_id)->description,
                    'post_image'=>$single_post_detail->image,
                    'logged_in_id'=> $single_post_detail->post_id,
                ];
            }
        }


// dd($posts_list);
        return view('index',['posts_list'=>$posts_list]);
        // dd($posts);
      
    }
}
