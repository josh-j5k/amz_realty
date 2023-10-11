<?php


use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;


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


Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/', function () {
    return Inertia::render('Home');
})->name('Home');
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('Contact');
Route::get('/about-us', function () {
    return Inertia::render('About');
})->name('About');

Route::prefix('listings')->group(function () {
    Route::name('listings.')->group(function () {
        Route::get('/', [ListingController::class, 'index'])->name('index');
        Route::get('/create', [ListingController::class, 'create'])->name('create');
        Route::post('/', [ListingController::class, 'store'])->name('store');
        Route::get('/{listing}', [ListingController::class, 'show'])->name('show');
    });
});





Route::middleware('auth')->group(function () {
    Route::get('/au/{user_id}', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
