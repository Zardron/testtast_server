<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function viewpost(){
                
        $post = Post::select("*")->orderBy("id", 'desc')->take(5)->get();
        return response()->json([
            'status'=>200,
            'post'=>$post
        ]);
    }

    public function post(Request $request){
        $validator = Validator::make($request->all(), [
            'post' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }else {
            $post = Post::create([
                'post'=>$request->post,
                'timestamp'=>$request->timestamp,
            ]); 


            return response()->json([
                'status' =>200,
                'message' =>'Post Successfully!',
            ]);
        }
    }
    
}
