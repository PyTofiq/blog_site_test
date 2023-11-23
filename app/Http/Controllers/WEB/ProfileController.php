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


class ProfileController extends Controller
{
    public function profilePage()
    {
        $user = auth()->user();
        $blogs = Blog::where('author_id', $user->id)->get();
        return view('web.profile', compact(
            'user',
            'blogs',
        ));
    }
    public function profileEditPage(){
        $old = auth()->user();
        return view('web.profile-edit', compact('old'));
    }
    public function profileEdit(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
}
