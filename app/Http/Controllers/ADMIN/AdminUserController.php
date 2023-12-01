<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Author;
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


class AdminUserController extends Controller
{

    public function usersPage(){
        $users = Author::all();
        return view('admin.users', compact('users'));
    }

    public function loginPage(){
        return view('admin.login');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return redirect()->route('admin-users')->with('success', 'Login successful');

        }

        return back()->withInput()->withErrors(['admin-login-email' => 'Invalid email or password']);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('blogs');
    }

}
