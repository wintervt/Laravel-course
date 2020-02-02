<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());
    
        //will create comments_count property

       return view('posts.index',
            ['posts' => BlogPost::withCount('comments')->get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$request->session()->reflash();
        return view('posts.show', [
            'post' => BlogPost::with('comments')->findOrFail($id)
        ]);
    }

     public function create()
    {
       // $this->authorize('posts.create');

       return view('posts.create');
    }

    public function store(StorePost $request)
    {
       $validatedData = $request->validated();
       $validatedData['user_id'] = $request->user()->id;

       $blogPost = BlogPost::create($validatedData);

       if ($request->hasFile('thumbnail')) {
        $path = $request->file('thumbnail')->store('thumbnails');
        $blogPost->image()->save(
            Image::create(["path" => $path])
        );
       }    
       
       $request->session()->flash('status', 'Blog post was created!');

       return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blogpost!");
        // };
        // instead of defining a Gate like above use below shorthand:
         $this->authorize('update', $post);

        return view('posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $id)
    {

        $post = BlogPost::findOrFail($id);

       $this->authorize('update', $post);

        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('status', 'Blog post was updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, "You can't delete this blogpost!");
        // };
        $this->authorize('delete', $post);

        $post->delete();

        $request->session()->flash('status', 'Blog post was deleted!');
        return redirect()->route('posts.index');
    }

}
