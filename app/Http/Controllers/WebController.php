<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class WebController extends Controller
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
            ->firstOrFail();
        $categories = Category::all();
        return view('web.blogs.blog-edit', compact('old', 'categories'));
    }

    public function blogEdit(Request $request, $blogId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'array',
        ]);

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
            $imagePath = $request->file('image')->store('uploads/blogs', 'public');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'array',
        ]);

        $blog = new Blog();
        $blog->title = $request->input('name');
        $blog->description = $request->input('description');
        $blog->author_id = auth()->user()->id;
        $blog->save();

        $categories = $request->input('category') ?? [];
        $blog->categories()->sync($categories);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/blogs', 'public');
            $blog->image = basename($imagePath);
        }


        $blog->save();

        return redirect()->route('profile')->with('success', 'Blog added successfully');
    }


    public function blogDelete($id)
    {
        $blog = Blog::where('id', $id)->firstOrFail();
        if ($blog->image) {
            $imagePath = public_path('uploads/blogs/' . $blog->image);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }


        $blog->delete();
        return redirect()->route('profile');

    }

    public function loginPage()
    {
        return view('web.login');
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status == 0) {
                // Only allow login if the user's status is 0
                return redirect()->route('profile');
            } else {
                // Logout if the user's status is not 0
                Auth::logout();
                return redirect()->route('login-page')->withErrors(['error' => 'Your account is not authorized to access.']);
            }
        }

        return redirect()->route('login-page')->withErrors(['error' => 'Invalid email or password']);
    }

    public function registerPage()
    {
        return view('web.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Create a new user instance
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->status = 0; // Setting the status to 0 for a regular user

        // Save the user to the database
        $user->save();

        // You can optionally log in the user after registration
        auth()->login($user);

        return redirect()->route('profile');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('blogs');
    }

    public function profilePage()
    {
        $user = auth()->user();
        $blogs = Blog::where('author_id', $user->id)->get();
        return view('web.profile', compact(
            'user',
            'blogs',
        ));
    }

}
