<?php

use App\Http\Controllers\AttendsController;
use App\Http\Controllers\SubjectsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/index', function () {
    return Inertia::render('Menu/Index');
})->name('Index');

Route::middleware(['auth:sanctum', 'verified'])->get('/aindex', function () {
    return Inertia::render('Menu/AttendIndex');
})->name('AttendIndex');
Route::middleware(['auth:sanctum', 'verified'])->get('/show/{subject_id}', function ($subject_id) {
    return Inertia::render('Menu/Show',['subject_id'=>$subject_id]);
})->name('Show');

Route::middleware(['auth:sanctum', 'verified'])->get('/edit/{subject_id}', function ($subject_id) {
    return Inertia::render('Menu/Edit',['subject_id'=>$subject_id]);
})->name('Show');
Route::post('/subject/save', [SubjectsController::class,'create']);

Route::get('/subject/index', [SubjectsController::class,'index']);
Route::get('/attend/index', [AttendsController::class,'index']);
Route::get('/subject/show/{subject_id}', [SubjectsController::class,'show']);
Route::post('/subject/edit/{subject_id}', [SubjectsController::class,'edit']);
Route::post('/subject/attend/{subject_id}', [AttendsController::class,'create']);
Route::delete('/subject/delete/{subject_id}', [SubjectsController::class,'delete']);
Route::middleware(['auth:sanctum', 'verified'])->get('/add', function () {
    return Inertia::render('Menu/AddSubject');
})->name('add');
