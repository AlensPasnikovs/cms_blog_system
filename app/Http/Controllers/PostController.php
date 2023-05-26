<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request) {
      $posts = Post::all();
      $timeTaken = $request->query('time_taken', 'N/A');
      return view('tiny_mce.index', compact('posts'))->with('timeTaken', $timeTaken);
   }
   public function posts() {
      $posts = Post::all();
      return view('tiny_mce.index', compact('posts'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create() {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(PostRequest $request) {
      $post = new Post();
      $post->title = $request->post_title;
      $post->content = $request->post_content;
      //image upload
      if ($request->hasFile('post_image')) {
         //get timestamp.image_original_name to avoid duplicate name
         $image = $request->file('post_image');
         $fileName = time() . '.' . $image->getClientOriginalName();
         $image->storeAs('public/photos/posts', $fileName);
         $post->image = $fileName;
      }
      $post->save();
      //redirect to posts page with success message
      return redirect()->route('tiny_mce')->with('success', __('validation.post_created'));
   }

   function getPostOrRedirect($id) {
      $post = Post::find($id);
      if (!$post) {
         abort(redirect()->route('tiny_mce')->withErrors(['error' => __('validation.post_not_found')]));
      }
      return $post;
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Post  $post
    * @return \Illuminate\Http\Response
    */
   public function show($id) {
      $post = $this->getPostOrRedirect($id);
      return view('tiny_mce.show_post', compact('post'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Post  $post
    * @return \Illuminate\Http\Response
    */
   public function edit($id) {
      $post = $this->getPostOrRedirect($id);
      return response()->json([
         'title' => $post->title,
         'content' => $post->content,
         'image' => $post->image
      ]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Post  $post
    * @return \Illuminate\Http\Response
    */
   public function update(PostRequest $request, $id) {
      $post = $this->getPostOrRedirect($id);
      $post->title = $request->post_title;
      $post->content = $request->post_content;
      //image upload
      if ($request->hasFile('post_image')) {
         //get timestamp.image_original_name to avoid duplicate name
         $image = $request->file('post_image');
         $fileName = time() . '.' . $image->getClientOriginalName();
         $image->storeAs('public/photos/posts', $fileName);
         //delete the old image
         if ($post->image) {
            Storage::delete('public/photos/posts/' . $post->image);
         }
         $post->image = $fileName;
      }
      $post->save();
      return redirect()->route('tiny_mce')->with('success', __('validation.post_updated'));
   }


   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Post  $post
    * @return \Illuminate\Http\Response
    */
   public function destroy($id) {
      $post = $this->getPostOrRedirect($id);
      Storage::delete('public/photos/posts/' . $post->image);
      $post->delete();
      return redirect()->route('tiny_mce')->with('success', __('validation.post_deleted'));
   }
}
