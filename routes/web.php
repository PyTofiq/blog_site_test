<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/create-user', [AdminController::class, 'createUser']);
Route::get('/create-blog', [AdminController::class, 'createBlog']);




Route::get('/admin/login', [AdminController::class, 'loginPage'])->name('admin-login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin-login-post');
Route::get('/logout', [AdminController::class, 'logout'])->name('admin-logout');

Route::middleware(['author'])->group(function (){
    Route::get('/profile', [WebController::class, 'profilePage'])->name('profile');
    Route::get('/blog-add', [WebController::class, 'blogAddPage'])->name('blog-add-page');
    Route::post('/blog-add', [WebController::class, 'blogAdd'])->name('blog-add-post');
    Route::get('/blog-edit/{id}', [WebController::class, 'blogEditPage'])->name('blog-edit-page');
    Route::post('/blog-edit/{id}', [WebController::class, 'blogEdit'])->name('blog-edit-post');
    Route::get('/blog-delete/{id}', [WebController::class, 'blogDelete'])->name('blog-delete');


});

Route::middleware(['auth', 'admin'])->group(function () {
    // ADMIN PANEL
    Route::get('/admin', function () {
        return redirect()->route('admin-users');
    });
Route::get('/admin/users', [AdminController::class, 'usersPage'])->name('admin-users');


Route::get('/admin/blogs', [AdminController::class, 'blogsPage'])->name('admin-blogs');
// Route::get('/admin/blogs/add', [AdminController::class, 'addBlogPage'])->name('admin-blogs-add-page');
// Route::post('/admin/blog/add', [AdminController::class, 'addCategory'])->name('admin-blog-add');
Route::get('/admin/blogs/edit/{id}', [AdminController::class, 'editBlogPage'])->name('admin-blog-edit-page');
Route::post('/admin/blog/edit/{id}', [AdminController::class, 'editBlog'])->name('admin-blog-edit');
Route::get('/admin/blog/delete{id}',[AdminController::class, 'deleteBlog'])->name('admin-blog-delete');


    Route::get('/admin/categories', [AdminController::class, 'categoriesPage'])->name('admin-categories');
    Route::get('/admin/categories/add', [AdminController::class, 'addCategoryPage'])->name('admin-category-add-page');
    Route::post('/admin/category/add', [AdminController::class, 'addCategory'])->name('admin-category-add');
    Route::get('/admin/categories/edit/{id}', [AdminController::class, 'editCategoryPage'])->name('admin-category-edit-page');
    Route::post('/admin/category/edit/{id}', [AdminController::class, 'editCategory'])->name('admin-category-edit');
    Route::get('/admin/category/delete{id}',[AdminController::class, 'deleteCategory'])->name('admin-category-delete');

// ADMIN PANEL END


});



Route::get('/blogs', [WebController::class, 'blogs'])->name('blogs');
Route::get('/blog-category/{id}', [WebController::class, 'blogCategoryPage'])->name('blog-category');
Route::get('/blog/details/{id}', [WebController::class, 'blogDetails'])->name('blog-details');

Route::get('/login', [WebController::class, 'loginPage'])->name('login-page');
Route::get('/register', [WebController::class, 'registerPage'])->name('register-page');
Route::post('/register', [WebController::class, 'register'])->name('register-post');
Route::get('/logout', [WebController::class, 'logout'])->name('logout');
Route::post('/login', [WebController::class, 'login'])->name('login-post');




Route::redirect('/', '/blogs');
