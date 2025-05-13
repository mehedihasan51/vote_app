<?php

use App\Models\Survey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Auth\ApplyController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\SocialLinksController;
use App\Http\Controllers\Api\Frontend\FaqController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\FirebaseTokenController;
use App\Http\Controllers\Api\Frontend\HomeController;
use App\Http\Controllers\Api\Frontend\NewsController;
use App\Http\Controllers\Api\Frontend\PostController;
use App\Http\Controllers\Api\Frontend\EventController;
use App\Http\Controllers\Api\Frontend\FocusController;
use App\Http\Controllers\Api\Frontend\LeaderController;
use App\Http\Controllers\Api\Frontend\SurveyController;
use App\Http\Controllers\Api\Auth\SocialLoginController;
use App\Http\Controllers\Api\Frontend\ContactController;
use App\Http\Controllers\Api\Frontend\categoryController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Donate\StripeDonateController;
use App\Http\Controllers\Api\Frontend\SurveyVoteController;
use App\Http\Controllers\Api\Frontend\SubcategoryController;


//page
Route::get('/page/home', [HomeController::class, 'index']);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/post/show/{post_id}', [PostController::class, 'show']);

Route::get('/category', [categoryController::class, 'index']);

Route::get('/subcategory', [SubcategoryController::class, 'index']);
Route::get('/focus', [FocusController::class, 'index']);

Route::get('/social/links', [SocialLinksController::class, 'index']);
Route::get('/settings', [SettingsController::class, 'index']);
Route::post('subscriber/store',[SubscriberController::class, 'store'])->name('subscriber.store');

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/show/{post_id}', [NewsController::class, 'show']);

Route::get('/leader', [LeaderController::class, 'index']);
Route::get('/leader/show/{post_id}', [LeaderController::class, 'show']);

Route::get('/event', [EventController::class, 'index']);
Route::get('/event/four', [EventController::class, 'fourItem']);
Route::get('/event/show/{post_id}', [EventController::class, 'show']);

Route::post('/contact', [ContactController::class, 'store']);

Route::get('/faq', [FaqController::class, 'index']);

// Survey route

Route::get('/survey/details',[SurveyController::class,'show']);

Route::post('/vote/{survey}', [SurveyVoteController::class, 'showResults'])->middleware('auth:api');

/*
# Auth Route
*/

Route::group(['middleware' => 'guest:api'], function ($router) {
    //register
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('/verify-email', [RegisterController::class, 'VerifyEmail']);
    Route::post('/resend-otp', [RegisterController::class, 'ResendOtp']);
    Route::post('/verify-otp', [RegisterController::class, 'VerifyEmail']);
    //login
    Route::post('login', [LoginController::class, 'login'])->name('login');
    //forgot password
    Route::post('/forget-password', [ResetPasswordController::class, 'forgotPassword']);
    Route::post('/otp-token', [ResetPasswordController::class, 'MakeOtpToken']);
    Route::post('/reset-password', [ResetPasswordController::class, 'ResetPassword']);
    //social login
    Route::post('/social-login', [SocialLoginController::class, 'SocialLogin']);
});

Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::get('/refresh-token', [LoginController::class, 'refreshToken']);
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/update-avatar', [UserController::class, 'updateAvatar']);
    Route::delete('/delete-profile', [UserController::class, 'destroy']);

    Route::post('/apply/store', [ApplyController::class, 'store']);
});

/*
# Firebase Notification Route
*/

Route::middleware(['auth:api'])->controller(FirebaseTokenController::class)->prefix('firebase')->group(function () {
    Route::get("test", "test");
    Route::post("token/add", "store");
    Route::post("token/get", "getToken");
    Route::post("token/delete", "deleteToken");
    
})->middleware('auth:api');


/*
# In App Notification Route
*/

Route::middleware(['auth:api'])->controller(NotificationController::class)->prefix('notify')->group(function () {
    Route::get('test', 'test');
    Route::get('/', 'index');
    Route::get('status/read/all', 'readAll');
    Route::get('status/read/{id}', 'readSingle');
})->middleware('auth:api');

/*
# Chat Route
*/

Route::middleware(['auth:api'])->controller(ChatController::class)->prefix('both/chat')->group(function () {
    Route::get('/list', 'list');
    Route::post('/send/{receiver_id}', 'send');
    Route::get('/conversation/{receiver_id}', 'conversation');
    Route::get('/room/{receiver_id}', 'room');
    Route::get('/search', 'search');
    Route::get('/seen/all/{receiver_id}', 'seenAll');
    Route::get('/seen/single/{chat_id}', 'seenSingle');
});

/*
# CMS
*/

Route::prefix('cms')->name('cms.')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
});



Route::post('/create-checkout-session', [StripeDonateController::class, 'createCheckoutSession']);