<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Image;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Cache;
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


       return view(
                    'posts.index',
                     [
                        'posts' => BlogPost::latest()->withCount('comments')->with('user')->with('tags')->get(),
                     ]
                  );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $blogPost = Cache::remember("blog-posts-{$id}", 60, function() use ($id) {
            return BlogPost::with('comments')->with('tags')->findOrFail($id);
        });

        $sessionId = session()->getId();

        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1 ) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
        ) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::forever($usersKey, $usersUpdate);

        if (!Cache::has($counterKey)) {
            Cache::forever($counterKey, 1);
        } else {
            Cache::increment($counterKey, $difference);    
        }

        $counter = Cache::get($counterKey);
      
        return view('posts.show', [
            'post' => $blogPost,
            'counter' => $counter,
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
