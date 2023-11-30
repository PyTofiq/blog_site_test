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


class AdminCategoryController extends Controller
{
    public function categoriesPage(){
        $categories = Category::all();
        return view('admin.categories.categories', compact('categories'));
    }
    public function addCategoryPage(){
        return view('admin.categories.add');
    }

    public function addCategory(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|unique:categories',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|unique:categories,name,' . $category,
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
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
}
