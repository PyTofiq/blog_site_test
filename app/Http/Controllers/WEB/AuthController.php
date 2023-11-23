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


class AuthController extends Controller
{
    public function loginPage()
    {
        return view('web.login');
    }
    public function login()
    {
        $credentials = request(['email', 'password']);

        $validator = Validator::make($credentials,[
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
}
