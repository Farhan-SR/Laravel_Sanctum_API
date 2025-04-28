<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Post::all();
        return response()->json([
            'status' => true,
            'message' => " all post",
            'data'=> $data,
        ],200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [ 
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateUser->errors()->all(),
            ], 401);
        }

$img = $request->image;

$ext = $img->getClientOriginalExtension();
$imageName = time(). '.'. $ext ;
$img->move(public_path().'\uploads',$imageName);



        $post = Post::create([
            
            'title' => $request->title,
            'description' =>  $request->description,
            'image' => $imageName, 
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'post' => $post,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = Post::select(
            'id',
            'title',
            'description',
            'image'

        )->where(['id' => $id])->get();

        return response()->json([
            'status' => true,
            'message' => ' data  created successfully',
            'post' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateUser = Validator::make(
            $request->all(),
            [ 
                'title' => 'required',
                'description' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg,gif', // ✅ make image optional
            ]
        );
    
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateUser->errors()->all(),
            ], 401);
        }
    
        // Find the post first
        $post = Post::find($id);
    
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
            ], 404);
        }
    
        $imageName = $post->image; // Default is old image
    
        // If a new image is uploaded
        if ($request->hasFile('image')) {
            $path = public_path('/uploads');
    
            // Delete the old image
            if (!empty($post->image) && file_exists($path . '/' . $post->image)) {
                unlink($path . '/' . $post->image);
            }
    
            // Upload new image
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $img->move($path, $imageName);
        }
    
        // Update post
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'Post updated successfully',
            'post' => $post,
        ], 200);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imagePath = Post::select('image')->where('id',$id)-get();
        $filePath = public_path().'/uploads'. $imagePath[0]['image'];
        unlink($filePath);

        $post = Post::where('id', $id)->delete();
        return response()->json([
            'status' => true,
            'message'=> "deleted",
            'post'=> $post ,
        ],200);
    }
}
