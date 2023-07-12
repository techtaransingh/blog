<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Detail;
use App\Models\Comment;
use App\Models\User;


class PostController extends Controller
{
    public function view(Request $request){
        return view('post');
    }
    public function submit(Request $request){
        // echo 'hello submit';die;
        $request->validate([
            'title'=>'required|unique:post',
            'description'=>'required',
            'post_status'=>'required',
            'post_type'=>'required',
            'image'=>'required',
            'post_tags'=>'required',
           
        ]);
       
    $post = Post::create(['title'=>$request->title,'description'=>$request->description]);
   
    $detail = Detail::create(['post_status'=>$request->post_status,
    'post_type'=>$request->post_type,
    'post_tags'=>$request->post_tags]);
    $image = time() . '.' . $request->file('image')->extension();

        $request->file('image')->move(public_path('images'), $image);
        if ($detail) {

            $detail->image = $image;
            $detail->author_id = auth()->user()->id;
            $detail->post_id = $post->id;
            $detail->save();
             
            $request->session()->flash('success', 'data submitted successfully');

        } else {
            $request->session()->flash('error', 'data not submitted successfully');
        }

        return back();
    }
    public function detail(Request $request, $id){
        
        $post_detail = Post::find($id);
    //   dd($post_detail);
        $comments_list = $post_detail->allComments;
        $comments_count = $post_detail->allComments->count();
      
     return view('posts',['post_detail'=>$post_detail,'comments_list'=>$comments_list,'comments_count' => $comments_count]);
    }
    public function comment(Request $request,$id){
        // echo 'hello comment';die;
        $request->validate([
            'comment'=>'required',
        ]);
        
        $comment_created = Comment::create(['comment'=>$request->comment]);
        if($comment_created){
            
            // $post_id = $id; ehvn nhi krida 
            $user_id = auth()->user()->id;
            $comment_created->post_id= $id;
            $comment_created->user_id= $user_id;
            $comment_created->save();
            $request->session()->flash('success', 'comment submitted successfully');

        } 
        else {

            $request->session()->flash('error', 'comment not submitted successfully');
        }
        
        return back();
        }
    
}
