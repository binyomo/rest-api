<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index()
    {
    	$posts = Post::latest()->paginate(5);

    	return new PostResource(true, 'List Data Post', $posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
        	return response()->json($validator->errors(), 422);
        }

        $post = Post::create([
        	'title' => $request->title,
            'desc' => $request->desc,
            'content' => $request->content
        ]);

        return new PostResource(true, 'Data Post Berhasil Ditambahkan', $post);
    }

    public function show(Post $post)
    {
        return new PostResource(true, 'Data Post Ditemukan', $post);
    }

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
        	return response()->json($validator->errors(), 422);
        }
        
        $post->update([
        	'title' => $request->title,
            'desc' => $request->desc,
            'content' => $request->content
        ]);

        return new PostResource(true, 'Data Post Berhasil Diubah', $post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return new PostResource(true, 'Data Post Berhasil Dihapus', null);
    }
}

