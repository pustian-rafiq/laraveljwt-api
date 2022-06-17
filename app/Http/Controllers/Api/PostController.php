<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //Get all post for logged user
    public function getPostByPerson(){
        $posts_by_person = Post::where('page_id',null)->get();
        return response()->json([
            'success' => true,
            'data' => PostResource::collection($posts_by_person)
        ]);
    }





     //store post
     public function store(Request $request,$page_id=null){
        $validateData = $request->validate([
            'post_content' => "required|string",
        ]);

        $data = new Post();

        $data->post_content = $request->post_content;
        $data->user_id = Auth::id();
        if($page_id){
            $data->page_id = $page_id;
        }
       
        $data->save();

        return response()->json([
            'success' => true,
            'message' => "Post created successfully"
        ]);
    }
}