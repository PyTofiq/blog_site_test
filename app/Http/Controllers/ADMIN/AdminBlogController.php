<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class AdminBlogController extends Controller
{

    public function blogsPage(){
        $blogs = Blog::with(['authors','categories'])
        ->get();

        return view('admin.blogs.blogs', compact(
            'blogs'
        ));
    }

    public function editBlogPage($blog){
        $old = Blog::with('categories')
        ->where('id', $blog)->first(); // blog yoxdursa 404 olmalidir, cunki ashagidaki setrler ishlemeyecek
        $categories = Category::all();
        $authors = User::where('status', 0)->get();
        // return $old->categories;
        return view('admin.blogs.edit', compact(
        'old',
        'categories',
        'authors'
    ));
    }
    public function editBlog(Request $request, $blogId)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'array', // gonderilen kateqoriyanin olub olmadigini yoxlamaq.
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $blog = Blog::findOrFail($blogId);
        $blog->title = $request->input('name');
        $blog->description = $request->input('description');
        $blog->author_id = $request->input('author');

        $categories = $request->input('category') ?? [];
        $blog->categories()->sync($categories);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete('uploads/blogs/' . $blog->image);
            }
            $imagePath = $request->file('image')->store('uploads/blogs', 'public'); // duzgun yere upload etmir
            $blog->image = basename($imagePath);
        }




        $blog->save();

        return redirect()->route('admin-blogs')->with('success', 'Blog updated successfully');
    }

    public function deleteBlog($id){
        $blog = Blog::where('id', $id)->first();  // blog yoxdursa 404 olmalidir, cunki ashagidaki setrler ishlemeyecek
        if ($blog->image) {
            $imagePath = public_path('uploads/blogs/' . $blog->image); //duzgun yerden silmir

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $blog->delete();
        return redirect()->back();

    }
}
