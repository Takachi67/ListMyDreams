<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
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
    return view('dashboard');
})->name('/');

Route::get('/mentions-legales', function () {
    return view('legalNotice');
})->name('/mentions-legales');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('wishlists', WishlistController::class)->except('edit', 'update', 'show');
    Route::get('profile', [UserController::class, 'profile'])->name('users.profile');
    Route::get('wishlists/edit/{id}', [WishlistController::class, 'edit'])->name('wishlists.edit');
    Route::get('wishlists/duplicate/{id}', [WishlistController::class, 'duplicate'])->name('wishlists.duplicate');
    Route::post('wishlists.update', [WishlistController::class, 'update'])->name('wishlists.update');
    Route::resource('friends', FriendController::class);
    Route::post('wishlists.reserve', [WishlistController::class, 'reserve'])->name('wishlists.reserve');
    Route::post('wishlists.unreserve', [WishlistController::class, 'unreserve'])->name('wishlists.unreserve');
    Route::post('wishlists.publish', [WishlistController::class, 'publish'])->name('wishlists.share');
    Route::post('wishlists.updateItem', [WishlistController::class, 'updateItem'])->name('wishlists.updateItem');
    Route::post('friends.request', [FriendController::class, 'request'])->name('friends.request');
    Route::post('friends.accept', [FriendController::class, 'accept'])->name('friends.accept');
    Route::post('friends.decline', [FriendController::class, 'decline'])->name('friends.decline');
    Route::post('friends.remove', [FriendController::class, 'remove'])->name('friends.remove');
    Route::post('messenger.send', [MessageController::class, 'send'])->name('messenger.send');
    Route::post('users.update', [UserController::class, 'update'])->name('users.update');
    Route::post('notifications.see', [NotificationController::class, 'see'])->name('notifications.see');
    Route::resource('reservations', ReservationController::class);
    Route::post('reservations.hasBought', [ReservationController::class, 'hasBought'])->name('reservations.hasBought');
    Route::post('reservations.saveNotes', [ReservationController::class, 'saveNotes'])->name('reservations.saveNotes');
    Route::post('questions.ask', [QuestionController::class, 'ask'])->name('questions.ask');
    Route::post('questions.answer', [QuestionController::class, 'answer'])->name('questions.answer');
    Route::post('questions.showAnswer', [QuestionController::class, 'showAnswer'])->name('questions.showAnswer');
});

Route::get('wishlists/{id}', [WishlistController::class, 'show'])->name('wishlists.show');

require __DIR__.'/auth.php';
