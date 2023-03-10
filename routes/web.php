<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInviteController;
use App\Http\Controllers\UserLevelController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', [UserController::class, 'index'])
    ->middleware(['auth'])
    ->name('users.index');

Route::get('/users/{user}/edit', [UserLevelController::class, 'edit'])
    ->middleware(['auth'])
    ->name('userlevels.edit');

Route::put('/users/{user}', [UserLevelController::class, 'update'])
    ->middleware(['auth'])
    ->name('userlevels.update');

Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('users.destroy');

Route::get('/users/invite', [UserInviteController::class, 'create'])
    ->middleware(['auth'])
    ->name('userinvites.create');

Route::post('/users/invite', [UserInviteController::class, 'store'])
    ->middleware(['auth'])
    ->name('userinvites.store');

// show the 'create new user' screen
Route::get('/users/create', [UserController::class, 'create'])
    ->middleware('signed')
    ->name('users.create');

// create the new user
Route::post('/users/store',[UserController::class, 'store'])
    ->name('users.store');

require __DIR__.'/auth.php';
