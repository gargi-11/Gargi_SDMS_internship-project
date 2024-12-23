<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicationController;

Route::get('/', function () {
    return view('auth\login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('achievements', AchievementController::class);
    Route::get('/achievements/{achievement}/view-document', [AchievementController::class, 'view_document'])->name('achievements.view_document');
    
    Route::resource('internships', InternshipController::class);
    Route::get('/internships/{internship}/view-document', [InternshipController::class, 'view_document'])->name('internships.view_document');
    
    Route::resource('courses', CourseController::class);
    Route::get('/courses/{course}/view-document', [CourseController::class, 'view_document'])->name('courses.view_document');
    
    Route::resource('publications', PublicationController::class);
    Route::get('/publications/{publication}/view-document', [PublicationController::class, 'view_document'])->name('publications.view_document');
});

