<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreateRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use App\Category;
// use Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return \view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('posts.create')->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        // upload the image
        $image = $request->image->store('posts');
        // create post
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'image' => $image,
            'category_id' =>$request->category
        ]);
        // flash
        \session()->flash('success', 'Post has been created successfully.');
        // redirect
        return \redirect(\route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title','description','published_at','content']);
        if($request->hasFile('image')){
            $image=$request->image->store('posts');
            // Storage::delete($post->image);
            $post->deleteImage();
            $data['image'] = $image;
        }
        $post->update($data);
        \session()->flash('success','Post udpated successfully.');
        return \redirect(\route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= Post::withTrashed()->where('id',$id)->firstOrFail();
        if ($post->trashed()) {
            // Storage::delete($post->image);
            $post->deleteImage();
            $post->forceDelete();
        }else{
            $post->delete();
        }
         // flash
        session()->flash('success', 'Post has been deleted successfully.');
         // redirect
        return \redirect()->back();
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Displays all the trashed posts
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed(){
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->withPosts($trashed);
    }

    /**
     * Restore trashed posts form the storage
     * @return \Illuminate\Http\Response
     */
    public function restore($id){
        $post= Post::withTrashed()->where('id',$id)->firstOrFail();
        $post->restore();
        session()->flash('success', 'Post has been restored successfully.');
        return redirect()->back();
    }



        // introducing API in cms
        public function get(){
            return \response()->json(Post::get());
        }
        public function getid($id){
            return \response()->json(Post::find($id));
        }
        public function delete($id){
            return \response()->json(Post::destroy($id));
        }
        public function post(Request $request){
            $post = new Post();
            $post->title = $request->input('title');
            $post->description = $request->input('description');
            $post->content = $request->input('content');
            $post->image = $request->input('image');
            $post->published_at = $request->input('published_at');
            $post->created_at = $request->input('created_at');
            $post->updated_at = $request->input('updated_at');

            $post->save();
            return \response()->json(Post::get());
        }
        public function put(Request $request, $id){
            $post = Post::find($id);
            $post->title = $request->input('title');
            $post->description = $request->input('description');
            $post->content = $request->input('content');
            $post->image = $request->input('image');
            $post->published_at = $request->input('published_at');
            $post->created_at = $request->input('created_at');
            $post->updated_at = $request->input('updated_at');
            $post->save();
            return \response()->json(Post::get());
        }
}
