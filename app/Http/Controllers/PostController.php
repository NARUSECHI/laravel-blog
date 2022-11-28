<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    const LOCAL_STORAGE_FOLDER ='public/images/';
    private $post;
    
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $post_list = $this->post->latest()->get();

        return view('posts.index')
            ->with('post_list',$post_list);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        # Validate the request
        $request->validate([
            'title'=> 'required|min:1|max:50',
            'body'=>'required|min:1|max:1000',
            'image'=>'required|mimes:jpg,jpeg,png,gif|max:1048'
        ]);

        # Save the request to the database
        $this->post->user_id = Auth::user()->id;
        //Owner of the post  = User who is logged in.
        $this->post->title = $request->title;
        $this->post->body = $request->body;
        $this->post->image = $this->saveImage($request);
        $this->post->save();

        // Redirect to homepage
        return redirect()->route('index');
    }

    private function saveImage($request)
    {
        //Change the name of the image to Current time to avoid overwriting
        $image_name = time() . "." .$request->image->extension();
        //Save the image inside storage/app/public/images
        $request->image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        return  $image_name;
    }

    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        return view('posts.show')
            ->with('post',$post);
    }

    public function edit($id)
    {
        $post =$this->post->findOrFail($id);

        if($post->user->id != Auth::user()->id)
        {
            return redirect()->back();
        }

        return view('posts.edit')
            ->with('post',$post);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required|min:1|max:50',
            'body' =>'required|min:1|max:1000',
            'image' => 'mimes:jpg,jpeg,png,gif|max:1048'
        ]);

        $post = $this->post->findOrFail($id);
        $post->title=$request->title;
        $post->body = $request->body;

        // if there is a new image:
            if($request->image){
                // Delete the old image from the local storage folder
                $this->deleteImage($post->image);
                
                $post->image = $this->saveImage($request);
            }

            $post->save();

            return redirect()->route('post.show',$id);
    }

    public function deleteImage($image_name)
    {
        $image_path =self::LOCAL_STORAGE_FOLDER.$image_name;

        if(Storage::dish('local')->exists($image_path))
        {
            storage::disk('local')->delete($image_path);
        }
    }

    public function destroy($id)
    {
        $post=$this->post->findOrFail($id);

        if($post->user->id != Auth::user()->id)
        {
            return redirect()->back();
        }

        //写真が消せない

        $post->delete();

        return redirect()->route('index');
    }


}
