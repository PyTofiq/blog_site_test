<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
            ->firstOrFail();
        $isUser = null;
        if (Auth::guard('author')->user()) {
            $isUser = Auth::guard('author')->user()->id == $blog->author_id;
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
            ->where('author_id', Auth::guard('author')->user()->id)
            ->firstOrFail();
        if ($old == null) {
            abort(404);
        }
        $categories = Category::all();
        return view('web.blogs.blog-edit', compact('old', 'categories'));
    }

    public function blogEdit(Request $request, $blogId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:5',
            'description' => 'required|string',
            'category' => 'array',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:20480',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $blog = Blog::findOrFail($blogId); // bashqasinin blogun editleye bilir. blog id ile
        if(Auth::guard('author')->user()->id == $blogId){
            $blog->title = $request->input('name');
            $blog->description = $request->input('description');
            $blog->author_id = Auth::guard('author')->user()->id;

            $categories = $request->input('category') ?? [];
            $blog->categories()->sync($categories);

            if ($request->hasFile('image')) {
                if ($blog->image) {
                    Storage::disk('public')->delete($blog->image); //duz sildiyini yoxlamaq
                }
                $year = now()->year;
                $month = now()->month;
                $path = "storage/images/{$year}/{$month}/{$blogId}";
                $imagePath = $request->file('image')->store($path, 'public');
                $blog->image = $imagePath;
            }

            $blog->save();

            return redirect()->route('profile')->with('success', 'Blog updated successfully');
        }
    }

    public function blogAddPage()
    {
        $categories = Category::all();
        return view('web.blogs.blog-add', compact('categories'));
    }

    public function blogAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:5',
            'description' => 'required|string',
            'category' => 'array',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:20480',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $blog = new Blog();
        $blog->title = $request->input('name');
        $blog->description = $request->input('description');
        $blog->author_id = Auth::guard('author')->user()->id;
        $blog->save();

        $categories = $request->input('category') ?? [];
        $blog->categories()->sync($categories);

        if ($request->hasFile('image')) {
            $imagePath = $this->saveImage($request->file('image'), $blog->id);
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image); // Delete the old image
            }
            $blog->image = $imagePath;
        }

        $blog->save();

        return redirect()->route('profile')->with('success', 'Blog added successfully');
    }


    public function blogDelete($id)
    {
        $blog = Blog::where('id', $id)->firstOrFail();
        if(Auth::guard('author')->user()->id == $id){

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        // Check if the folder is empty
        $year = now()->year;
        $month = now()->month;
        $path = "storage/images/{$year}/{$month}/{$id}";

        if (File::exists(public_path($path)) && count(File::allFiles(public_path($path))) === 0) {
            // If the folder is empty, delete it
            File::deleteDirectory(public_path($path));
        }

        $blog->delete();
        return redirect()->route('profile');
        }else{
            return redirect()->back();
        }
    }

    private function saveImage($file, $blogId)
    {
        $year = now()->year;
        $month = now()->month;
        $path = "storage/images/{$year}/{$month}/{$blogId}";

        return $file->store($path, 'public');
    }

}



