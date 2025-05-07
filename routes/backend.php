<?php

use App\Http\Controllers\Web\Backend\Access\PermissionController;
use App\Http\Controllers\Web\Backend\Access\RoleController;
use App\Http\Controllers\Web\Backend\Access\UserController;
use App\Http\Controllers\Web\Backend\ApplyController;
use App\Http\Controllers\Web\Backend\AreaController;
use App\Http\Controllers\Web\Backend\FocusController;
use App\Http\Controllers\Web\Backend\BookingController;
use App\Http\Controllers\Web\Backend\BranchController;
use App\Http\Controllers\Web\Backend\CategoryController;
use App\Http\Controllers\Web\Backend\ChatController;
use App\Http\Controllers\Web\Backend\CMS\Web\Home\HomeAboutCmcController;
use App\Http\Controllers\Web\Backend\CMS\Web\Home\HomeBannerController;
use App\Http\Controllers\Web\Backend\CMS\Web\Home\HomeDonateController;
use App\Http\Controllers\Web\Backend\CMS\Web\WhoWeAre\WhoWeAreCommittedController;
use App\Http\Controllers\Web\Backend\CMS\Web\WhoWeAre\WhoWeAreBannerController;
use App\Http\Controllers\Web\Backend\CMS\Web\WhoWeAre\WhoWeAreDifferenceController;
use App\Http\Controllers\Web\Backend\CMS\Web\WhoWeAre\WhoWeAreDiscoverValuesController;
use App\Http\Controllers\Web\Backend\CMS\Web\WhoWeAre\WhoWeAreMissionVissionController;
use App\Http\Controllers\Web\Backend\ContactController;
use App\Http\Controllers\Web\Backend\Settings\FirebaseController;
use App\Http\Controllers\Web\Backend\Settings\ProfileController;
use App\Http\Controllers\Web\Backend\Settings\MailSettingController;
use App\Http\Controllers\Web\Backend\Settings\SettingController;
use App\Http\Controllers\Web\Backend\Settings\SocialController;
use App\Http\Controllers\Web\Backend\Settings\StripeController;
use App\Http\Controllers\Web\Backend\Settings\GoogleMapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\DonationController;
use App\Http\Controllers\Web\Backend\EventController;
use App\Http\Controllers\Web\Backend\EventRegisterController;
use App\Http\Controllers\Web\Backend\FaqController;
use App\Http\Controllers\Web\Backend\LeaderController;
use App\Http\Controllers\Web\Backend\NewsController;
use App\Http\Controllers\Web\Backend\PageController;
use App\Http\Controllers\Web\Backend\PoliceController;
use App\Http\Controllers\Web\Backend\PostController;
use App\Http\Controllers\Web\Backend\ProductController;
use App\Http\Controllers\Web\Backend\SurveyController;
use App\Http\Controllers\Web\Backend\Settings\CaptchaController;
use App\Http\Controllers\Web\Backend\Settings\OtherController;
use App\Http\Controllers\Web\Backend\SocialLinkController;
use App\Http\Controllers\Web\Backend\SubcategoryController;
use App\Http\Controllers\Web\Backend\SubscriberController;
use App\Http\Controllers\Web\Backend\TransactionController;

Route::get("dashboard", [DashboardController::class, 'index'])->name('dashboard');


/*
* CRUD
*/

Route::controller(PoliceController::class)->prefix('police')->name('police.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(CategoryController::class)->prefix('category')->name('category.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(SubcategoryController::class)->prefix('subcategory')->name('subcategory.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(PostController::class)->prefix('post')->name('post.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(PageController::class)->prefix('page')->name('page.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(SocialLinkController::class)->prefix('social')->name('social.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(FaqController::class)->prefix('faq')->name('faq.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(NewsController::class)->prefix('news')->name('news.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(LeaderController::class)->prefix('leader')->name('leader.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(EventController::class)->prefix('event')->name('event.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(EventRegisterController::class)->prefix('event/register')->name('event.register.')->group(function () {
    Route::get('/{event_id}', 'index')->name('index');
    Route::get('/create/{event_id}', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(SurveyController::class)->prefix('survey')->name('survey.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');

    Route::get('opinion/delete/{id}', 'removeOpinion')->name('opinion.destroy');
});

Route::controller(AreaController::class)->prefix('area')->name('area.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(BranchController::class)->prefix('branch')->name('branch.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(BookingController::class)->prefix('booking')->name('booking.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
});

Route::controller(TransactionController::class)->prefix('transaction')->name('transaction.')->group(function () {
    Route::get('/{user_id?}', 'index')->name('index');
    Route::get('/show/{id}', 'show')->name('show');
});

Route::controller(DonationController::class)->prefix('donation')->name('donation.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/show/{id}', 'show')->name('show');
});

Route::get('subscriber', [SubscriberController::class, 'index'])->name('subscriber.index');

Route::controller(ContactController::class)->prefix('contact')->name('contact.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/status/{id}', 'status')->name('status');
});


Route::controller(FocusController::class)->prefix('focus')->name('focus.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/status/{id}', 'status')->name('status');
});

Route::controller(ApplyController::class)->prefix('apply')->name('apply.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/status/{id}', 'status')->name('status');
});


/*
* CMS
*/

Route::prefix('cms')->name('cms.')->group(function () {

    //Home
    Route::prefix('home/banner')->name('home.banner.')->controller(HomeBannerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/content', 'content')->name('content');
    });

    Route::prefix('home/about_cmc')->name('home.about_cmc.')->controller(HomeAboutCmcController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/content', 'content')->name('content');
    });

    Route::prefix('home/donate')->name('home.donate.')->controller(HomeDonateController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/content', 'content')->name('content');
    });


    //Who We Are
    Route::prefix('whoweare/banner')->name('whoweare.banner.')->controller(WhoWeAreBannerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/content', 'content')->name('content');
    });

    Route::prefix('whoweare/committed')->name('whoweare.committed.')->controller(WhoWeAreCommittedController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::patch('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/{id}/status', 'status')->name('status');

        Route::put('/content', 'content')->name('content');
    });

    Route::prefix('whoweare/difference')->name('whoweare.difference.')->controller(WhoWeAreDifferenceController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::patch('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/{id}/status', 'status')->name('status');

        Route::put('/content', 'content')->name('content');
    });

    Route::prefix('whoweare/mission_vission')->name('whoweare.mission_vission.')->controller(WhoWeAreMissionVissionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::patch('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/{id}/status', 'status')->name('status');

        Route::put('/content', 'content')->name('content');
    });

    Route::prefix('whoweare/discover_values')->name('whoweare.discover_values.')->controller(WhoWeAreDiscoverValuesController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::patch('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/{id}/status', 'status')->name('status');

        Route::put('/content', 'content')->name('content');
    });


    /* Route::prefix('home/banner')->name('home.banner.')->controller(HomeBannerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::patch('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/{id}/status', 'status')->name('status');

        Route::put('/content', 'content')->name('content');
    }); */
    
});

/*
* Chating Route
*/

Route::controller(ChatController::class)->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/list', 'list')->name('list');
    Route::post('/send/{receiver_id}', 'send')->name('send');
    Route::get('/conversation/{receiver_id}', 'conversation')->name('conversation');
    Route::get('/room/{receiver_id}', 'room');
    Route::get('/search', 'search')->name('search');
    Route::get('/seen/all/{receiver_id}', 'seenAll');
    Route::get('/seen/single/{chat_id}', 'seenSingle');
});


/*
* Users Access Route
*/

Route::resource('users', UserController::class);
Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
    Route::get('/new', 'new')->name('new.index');
    Route::get('/ajax/new/count', 'newCount')->name('ajax.new.count');
});
Route::resource('permissions', PermissionController::class);
Route::resource('roles', RoleController::class);

/*
*settings
*/

//! Route for Profile Settings
Route::controller(ProfileController::class)->group(function () {
    Route::get('setting/profile', 'index')->name('setting.profile.index');
    Route::put('setting/profile/update', 'UpdateProfile')->name('setting.profile.update');
    Route::put('setting/profile/update/Password', 'UpdatePassword')->name('setting.profile.update.Password');
    Route::post('setting/profile/update/Picture', 'UpdateProfilePicture')->name('update.profile.picture');
});

//! Route for Mail Settings
Route::controller(MailSettingController::class)->group(function () {
    Route::get('setting/mail', 'index')->name('setting.mail.index');
    Route::patch('setting/mail', 'update')->name('setting.mail.update');
});

//! Route for Stripe Settings
Route::controller(StripeController::class)->prefix('setting/stripe')->name('setting.stripe.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::patch('/update', 'update')->name('update');
});

//! Route for Firebase Settings
Route::controller(FirebaseController::class)->prefix('setting/firebase')->name('setting.firebase.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::patch('/update', 'update')->name('update');
});

//! Route for Firebase Settings
Route::controller(SocialController::class)->prefix('setting/social')->name('setting.social.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::patch('/update', 'update')->name('update');
});

//! Route for Stripe Settings
Route::controller(SettingController::class)->group(function () {
    Route::get('setting/general', 'index')->name('setting.general.index');
    Route::patch('setting/general', 'update')->name('setting.general.update');
});

//! Route for Google Map Settings
Route::controller(GoogleMapController::class)->group(function () {
    Route::get('setting/google/map', 'index')->name('setting.google.map.index');
    Route::patch('setting/google/map', 'update')->name('setting.google.map.update');
});

//! Route for Google Map Settings
Route::controller(CaptchaController::class)->group(function () {
    Route::get('setting/captcha', 'index')->name('setting.captcha.index');
    Route::patch('setting/captcha', 'update')->name('setting.captcha.update');
});

//Ajax settings
Route::prefix('setting/other')->name('setting.other')->group(function () {
    Route::get('/', [OtherController::class, 'index'])->name('.index');
    Route::get('/mail', [OtherController::class, 'mail'])->name('.mail');
    Route::get('/sms', [OtherController::class, 'sms'])->name('.sms');
    Route::get('/recaptcha', [OtherController::class, 'recaptcha'])->name('.recaptcha');
    Route::get('/pagination', [OtherController::class, 'pagination'])->name('.pagination');
    Route::get('/reverb', [OtherController::class, 'reverb'])->name('.reverb');
});