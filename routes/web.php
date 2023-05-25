<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ThemeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();
//add route for profile
Route::middleware('auth')->group(function () {
   Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
   Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
   Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   Route::put('password', [PasswordController::class, 'update'])->name('passwordController.update');
});

//student_faculty.blade.php
//Student routes
Route::get('/students', [StudentController::class, 'index'])->name('student_faculty');

Route::get('student_get', [StudentController::class, 'student_get'])->name('student_get');
Route::middleware('auth')->group(function () {
   Route::post('/student', [StudentController::class, 'store'])->name('student_store');
});
Route::put('/student/{studentId}', [StudentController::class, 'update'])->name('student_update');
Route::delete('/student/{studentId}', [StudentController::class, 'destroy'])->name('student_destroy');

//lang route
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

//tiny_mce
// Route::middleware('auth')->group(function () {
// Route::get('/', function () {
//    return redirect()->route('tiny_mce');
// });
Route::get('/', [PostController::class, 'index'])->name('tiny_mce');
Route::post('create_post', [PostController::class, 'store'])->name('create_post');

Route::get('post/{id}', [PostController::class, 'show'])->name('post_show');
Route::delete('post/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('edit_post');
Route::put('/post/update/{id}', [PostController::class, 'update'])->name('update_post');
// });

Route::post('/save-theme', [ThemeController::class, 'update'])->name('save_theme');

Route::get('/sso-entry', function (Request $request) {
   // This middleware will process the token and authenticate the user
   // You can then redirect the user to the 'tiny_mce' route
   return redirect()->route('tiny_mce');
})->middleware('sso');
