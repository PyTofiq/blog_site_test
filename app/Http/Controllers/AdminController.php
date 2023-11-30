<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;



class AdminController extends Controller
{
    public function createUser()
    {
        $user = User::create([
            'name' => 'Test admin',
            'email' => 'test@test.com',
            'password' => Hash::make('test123'),
            'status' => 1,
        ]);

        return response()->json($user, 201);
    }

    public function createBlog(){
        $blog = Blog::create([
            'title'=> 'Test title',
            'description' => 'Test desc',
            'image' => 'default.png',
            'author_id' => 3,
        ]);
        return response()->json($blog, 201);
    }


    public function usersPage(){
        $users = User::all();
        return view('admin.users', compact('users'));
    }
    public function blogsPage(){
        $blogs = Blog::with(['authors','categories'])
        ->get()
        ;

        return view('admin.blogs.blogs', compact(
            'blogs'
        ));
    }
    public function editBlogPage($blog){
        $old = Blog::with('categories')
        ->where('id', $blog)->firstOrFail();
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'array',
        ]);

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
            $imagePath = $request->file('image')->store('uploads/blogs', 'public');
            $blog->image = basename($imagePath);
        }




        $blog->save();

        return redirect()->route('admin-blogs')->with('success', 'Blog updated successfully');
    }

    public function deleteBlog($id){
        $blog = Blog::where('id', $id);
        if ($blog->image) {
            $imagePath = public_path('uploads/blogs/' . $blog->image);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $blog->delete();
        return redirect()->back();

    }

    public function categoriesPage(){
        $categories = Category::all();
        return view('admin.categories.categories', compact('categories'));
    }
    public function addCategoryPage(){
        return view('admin.categories.add');
    }

    public function addCategory(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $name = $request->input('name');
        $new = new Category();
        $new->name = $name;
        $new->save();
        return redirect()->route('admin-categories');
    }

    public function editCategoryPage(Request $request, $category){
        $old = Category::where('id', $category)->firstOrFail();
        return view('admin.categories.edit', compact('old'));
    }

    public function editCategory(Request $request, $category){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $update = Category::where('id', $category)->firstOrFail();
        $update->name = $request->input('name');
        $update->update();
        return redirect()->route('admin-categories');
    }

    public function deleteCategory($id){
        $category = Category::where('id', $id);
        $category->delete();
        return redirect()->back();

    }


    public function loginPage(){
        return view('admin.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status == 1) {
                return redirect()->route('admin-users')->with('success', 'Login successful');
            } else {
                Auth::logout();
                return back()->withInput()->withErrors(['admin-login-email' => 'Your account is inactive']);
            }
        }

        return back()->withInput()->withErrors(['admin-login-email' => 'Invalid email or password']);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('blogs');
    }
}
