<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function posts(){
        $latestPost = Post::latest()->first();
        $post =Post::where('status','published')->orderBy('created_at','DESC')->paginate(7);
        $featured_posts=Post::where('status','published')->where('featured','1')->orderBy('created_at','DESC')->take(2)->get();
        return view('posts',compact('post', 'latestPost', 'featured_posts'));
    }
    public function singlePost($slug){
        $post=Post::where('status','published')->where('slug',$slug)->firstorfail();
        // $related_posts=Post::where('status','published')->where('category_id',$post->category_id)->where('id','!=',$post->id)->orderBy('created_at','DESC')->take(2)->get();
        return view('showpost',compact('post'));
    }

    public function index()
    {
      {
           $post = Post::all();

           return view('admin.posts.index',compact('post'));
        }
    }

    public function create()
    {
        //
        return view("admin.posts.create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required|min:3",
            "excerpt" => "required|min:3",
            "image" => "required|image|mimes:png,jpg,jpeg|max:2048",
            "links" => "required|min:3",
            "status" => "nullable",
            "featured" => "nullable",
            "authorID" => "nullable"

        ]);
        if ($request->has("image")) {
            $file = $request->image;
            $imageName = "images/posts/" . time() . "_" . $file->getClientOriginalName();
            $file->move(public_path("images/posts"), $imageName);
            $title = $request->title;


          Post::create([
                "title" => $title,
                "slug" => Str::slug($title),
                "excerpt" => $request->excerpt,
                "image" => $imageName,
                "links" => $request->links,
                "status" => $request->status,
                "featured" =>$request->featured,
                "authorID" => $request->authorID
            ]);
        }


        return redirect('/admin/posts')->withSuccess('Post succesfully added');
    }

    public function edit($id)
    {

        return view("admin.posts.edit")->with([
            "post" => Post::findOrFail($id),

        ]);
    }


    public function update(Request $request, Post $post, $id)
    {
        $post = Post::find($id);
        $this->validate($request, [
            // "title" => "required|min:3"
            // "excerpt" => "required|min:5",
            // "image" => "image|mimes:png,jpg,jpeg|max:2048"
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/posts';
            $file = $request->image;
            $profileImage = "images/posts/" . time() . "_" . $file->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        $title = $request->title;
        $post->update($input);

        // $post->update([
        //    "title" => $title,
        //    "slug" => Str::slug($title),
        //    "excerpt" => $request->excerpt,
        //     "links" => $request->links,
        //     "status" => $request->status,
        //     "featured" =>$request->featured,
        //     "authorID" => $request->authorID,
        // ]);

        return redirect('/admin/posts')
        ->withSuccess("Post updated");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, $id)
    {
        //delete data
        $post = Post::findOrFail($id);
        $image_path = public_path("images/posts/" . $post->image);
        if (File::exists($image_path)) {
            unlink($image_path);
        }
        $post->delete();
        return redirect('/admin/posts')
            ->withSuccess("Post deleted");
    }

}
