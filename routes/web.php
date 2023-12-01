<?php

use App\Http\Controllers\ADMIN\AdminBlogController;
use App\Http\Controllers\ADMIN\AdminCategoryController;
use App\Http\Controllers\ADMIN\AdminUserController;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\BlogController;
use App\Http\Controllers\WEB\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware(['author'])->group(function () {
    // profile
    Route::get('/profile', [ProfileController::class, 'profilePage'])->name('profile');
    Route::get('/profile-edit', [ProfileController::class, 'profileEditPage'])->name('profile-edit-page');
    Route::post('/profile-edit', [ProfileController::class, 'profileEdit'])->name('profile-edit');
    // blog
    Route::get('/blog-add', [BlogController::class, 'blogAddPage'])->name('blog-add-page');
    Route::post('/blog-add', [BlogController::class, 'blogAdd'])->name('blog-add-post');
    Route::get('/blog-edit/{id}', [BlogController::class, 'blogEditPage'])->name('blog-edit-page');
    Route::post('/blog-edit/{id}', [BlogController::class, 'blogEdit'])->name('blog-edit-post');
    Route::get('/blog-delete/{id}', [BlogController::class, 'blogDelete'])->name('blog-delete');
});

Route::get('/admin/login', [AdminUserController::class, 'loginPage'])->name('admin-login');
Route::post('/admin/login', [AdminUserController::class, 'login'])->name('admin-login-post');

Route::middleware(['auth', 'admin'])->group(function () {
    // ADMIN PANEL
    Route::get('/admin', function () {
        return redirect()->route('admin-users');
    });

    Route::get('/admin/logout', [AdminUserController::class, 'logout'])->name('admin-logout');
    Route::get('/admin/users', [AdminUserController::class, 'usersPage'])->name('admin-users');

    Route::get('/admin/blogs', [AdminBlogController::class, 'blogsPage'])->name('admin-blogs');
    Route::get('/admin/blogs/edit/{id}', [AdminBlogController::class, 'editBlogPage'])->name('admin-blog-edit-page');
    Route::post('/admin/blog/edit/{id}', [AdminBlogController::class, 'editBlog'])->name('admin-blog-edit');
    Route::get('/admin/blog/delete/{id}', [AdminBlogController::class, 'deleteBlog'])->name('admin-blog-delete');

    Route::get('/admin/categories', [AdminCategoryController::class, 'categoriesPage'])->name('admin-categories');
    Route::get('/admin/categories/add', [AdminCategoryController::class, 'addCategoryPage'])->name('admin-category-add-page');
    Route::post('/admin/category/add', [AdminCategoryController::class, 'addCategory'])->name('admin-category-add');
    Route::get('/admin/categories/edit/{id}', [AdminCategoryController::class, 'editCategoryPage'])->name('admin-category-edit-page');
    Route::post('/admin/category/edit/{id}', [AdminCategoryController::class, 'editCategory'])->name('admin-category-edit');
    Route::get('/admin/category/delete/{id}', [AdminCategoryController::class, 'deleteCategory'])->name('admin-category-delete');
    // ADMIN PANEL END
});

Route::get('/blogs', [BlogController::class, 'blogs'])->name('blogs');
Route::get('/blog-category/{id}', [BlogController::class, 'blogCategoryPage'])->name('blog-category');
Route::get('/blog/details/{id}', [BlogController::class, 'blogDetails'])->name('blog-details');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login-page');
Route::post('/login', [AuthController::class, 'login'])->name('login-post');
Route::get('/register', [AuthController::class, 'registerPage'])->name('register-page');
Route::post('/register', [AuthController::class, 'register'])->name('register-post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::redirect('/', '/blogs');


// // tab
// Debugbar::info('Info');
// Debugbar::error('error ');
// Debugbar::warning('warning');
// Debugbar::addMessage('some message');

// // timeline tab
// Debugbar::startMeasure('something', 'this is for timeline tab');

// // exceptions tab
// try{
//     throw new Exception('Try message');
// }catch(Exception $e){
//     Debugbar::addException($e);
// }
