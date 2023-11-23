<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class BlogController extends Controller
{
    public function blogs()
    {
        $blogs = Blog::with(['categories', 'authors'])->paginate(10);
        return view('web.blogs.blogs', compact(
            'blogs'
        ));
    }

    public function blogCategoryPage($id)
    {
        $category = Category::where('id', $id)->firstOrFail(); //test
        $blogs = $category->blogs()->with(['categories', 'authors'])->get();
        return view('web.blogs.blog-category', compact('category', 'blogs'));
    }

    public function blogDetails($id)
    {
        $blog = Blog::with(['categories', 'authors'])
            ->where('id', $id)
            ->first();
        $isUser = null;
        if (auth()->user()) {
            $isUser = auth()->user()->id == $blog->author_id;
        }
        $blogs = Blog::with(['categories', 'authors'])
            ->where('author_id', $blog->author_id)
            ->where('id', '!=', $id)
            ->get();
        return view('web.blogs.blog-details', compact('blog', 'isUser', 'blogs'));

    }

    public function blogEditPage($blog)
    {
        $old = Blog::with('categories')
            ->where('id', $blog)
            ->where('author_id', auth()->user()->id)
            ->first();
        if($old == null){
            abort(404);
        }
        $categories = Category::all();
        return view('web.blogs.blog-edit', compact('old', 'categories'));
    }

    public function blogEdit(Request $request, $blogId)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|min:5',
            'description' => 'required|string',
            'category' => 'array',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:20480',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $blog = Blog::findOrFail($blogId);
        $blog->title = $request->input('name');
        $blog->description = $request->input('description');
        $blog->author_id = auth()->user()->id;

        $categories = $request->input('category') ?? [];
        $blog->categories()->sync($categories);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete('uploads/blogs/' . $blog->image);
            }
            $imagePath = $request->file('image')->store('storage/uploads/blogs', 'public');
            $blog->image = basename($imagePath);
        }


        $blog->save();

        return redirect()->route('profile')->with('success', 'Blog updated successfully');
    }

    public function blogAddPage()
    {
        $categories = Category::all();
        return view('web.blogs.blog-add', compact('categories'));
    }

    public function blogAdd(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|min:5',
            'description' => 'required|string',
            'category' => 'array',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:20480',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $blog = new Blog();
        $blog->title = $request->input('name');
        $blog->description = $request->input('description');
        $blog->author_id = auth()->user()->id;
        $blog->save();

        $categories = $request->input('category') ?? [];
        $blog->categories()->sync($categories);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('storage/uploads/blogs', 'public');
            $blog->image = basename($imagePath);
        }


        $blog->save();

        return redirect()->route('profile')->with('success', 'Blog added successfully');
    }


    public function blogDelete($id)
    {
        $blog = Blog::where('id', $id)->first();
        if ($blog->image) {
            $imagePath = storage_path('uploads/blogs/' . $blog->image);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }


        $blog->delete();
        return redirect()->route('profile');

    }

}
