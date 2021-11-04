<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendController;
use Illuminate\Support\Facades\Auth;


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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();
Route::get('/news',[App\Http\Controllers\MarketNewsController::class, 'index'])->name('market');
Route::post('/news1',[App\Http\Controllers\MarketNewsController::class, 'main']);
Route::get('/profile', [PostController::class, 'index'])->name('profile');
Route::post('/profile', [PostController::class, 'store']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/delete/{id}', [PostController::class, 'destroy']);

Route::get('/profile/{id}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile_show');
Route::get('/charts', [App\Http\Controllers\ChartController::class, 'index'])->name('charts');
Route::get('/marketpages', [App\Http\Controllers\MarketStockController::class, 'handle']);

Route::post('/posts/{post}/likes', [PostLikeController::class, 'store'])->name('posts.likes');
Route::delete('/posts/{post}/likes', [PostLikeController::class, 'destroy'])->name('posts.likes');

Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);
Route::get('/editprofile', [App\Http\Controllers\EditProfileController::class, 'index'])->name('profile-edit');
Route::post('/editprofile/update', [App\Http\Controllers\EditProfileController::class, 'updateProfile'])->name('profile.update');

Route::group(['middleware' => ['auth']], function (){
Route::get('/users', [App\Http\Controllers\FollowController::class, 'index'])->name("users");
Route::post('/follow/{user}', [App\Http\Controllers\FollowController::class, 'follow']);
Route::delete('/unfollow/{user}', [App\Http\Controllers\FollowController::class, 'unfollow']);
});

Route::post('/comment', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::get('test', [App\Http\Controllers\TestController::class, 'index'])->name('test');

//Route::get('trade-markets', [App\Http\Controllers\StocksMarketController::class, 'index'])->name('trade-markets');
//Route::get('test-1', [App\Http\Controllers\WorkController::class, 'index']);
//Route::get('test-2', [App\Http\Controllers\WorkController::class, 'ajax_index']);

Route::get('test_trade', function () {
    $response = file_get_contents(dirname(__DIR__) . '/public/temp.json');
    $e = json_decode($response);
    if (request()->ajax()) {
        return response()->json(array($e));
    }
    return view('test_trade')->with(['e' => $e]);
})->name('test_trade');



Route::get('/markets', [App\Http\Controllers\MarketController::class, 'index'])->name('markets');
Route::get('/markets/transaction/{symbol}', [App\Http\Controllers\MarketController::class, 'transaction'])->name('transaction');
Route::post('/markets/transaction/sell/{symbol}', [App\Http\Controllers\MarketController::class, 'sell'])->name('sell');
Route::post('/markets/transaction/buy/{symbol}', [App\Http\Controllers\MarketController::class, 'purchaseStock'])->name('buy');
Route::post('/markets/quotes', [App\Http\Controllers\MarketController::class, 'quotes']);
Route::get('/markets/quotes', function(){
    return redirect('market');
});
