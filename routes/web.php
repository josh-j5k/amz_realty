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
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/{listing}', 'show')->name('show');
    });


Route::middleware('auth')->group(function () {
    Route::prefix('listings')->group(function () {
        Route::post('/', [ListingController::class, 'store'])->name('store');
        Route::post('/{listing}', [ListingController::class, 'update'])->name('update');
        Route::delete('/{listing}', [ListingController::class, 'delete'])->name('delete');
    });
    Route::post('bookmark', function () { });
    Route::prefix('au/{user_id}')->name('user.')
        ->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/messages', [DashboardController::class, 'messages'])->name('dashboard.messages');
            Route::get('/saved', [DashboardController::class, 'saved'])->name('dashboard.saved');
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::post('/profile', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
});

require __DIR__ . '/auth.php';
