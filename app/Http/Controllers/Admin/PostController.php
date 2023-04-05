<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Post access|Post create|Post edit|Post delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Post create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Post edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Post delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $posts = Post::paginate(4);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'description' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::guard('admin')->user()->id;
        $Post = Post::create($data);

        return to_route('admin.posts.index')->with('message', 'Post Added Successfully!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit',  compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=>'required',
            'description' => 'required'
        ]);

        $post->update($request->all());

        return to_route('admin.posts.index')->with('message', 'Post Updated Successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('message', 'Post Deleted Successfully!');
    }
}
