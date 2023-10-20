<?php


use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Resources\ListingResource;
use App\Models\Listing;

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
    $listing = ListingResource::collection(Listing::latest()->limit(4)->get());
    return Inertia::render(
        'Home',
        ['listings' => $listing]
    );
})->name('Home');
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('Contact');
Route::get('/about-us', function () {
    return Inertia::render('About');
})->name('About');

Route::prefix('listings')
    ->controller(ListingController::class)->name('listings.')
    ->group(function () {
        Route::get('/',  'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::post('/{listing}', 'update')->name('update');
        Route::delete('/{listing}', 'destroy')->name('delete');
        Route::get('/{listing}', 'show')->name('show');
    });


Route::middleware('auth')->prefix('au/{user_id}')->name('user.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/messages', [DashboardController::class, 'messages'])->name('dashboard.messages');
        Route::get('/saved', [DashboardController::class, 'saved'])->name('dashboard.saved');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

require __DIR__ . '/auth.php';
