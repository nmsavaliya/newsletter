<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostCreateRequest;
use App\Models\Post;
use App\Events\PostCreatedEvent;


class PostController extends Controller
{
    /**
     * Store a newly created POST in DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        try {
            $post_create = Post::create($request->all());
            PostCreatedEvent::dispatch($post_create);
            return response()->json(['success'=>true,'message'=>'Post created successfully','post'=>$post_create]);
        } catch (\Exception $e) {
            return response()->json(['success'=>true,'message'=>$e->getMessage()],500);
        }
    }
}
