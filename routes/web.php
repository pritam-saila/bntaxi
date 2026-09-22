<?php

use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\BookController;
use App\Http\Controllers\admin\CarController;
use App\Http\Controllers\admin\ContentController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\DistanceController;
use App\Http\Controllers\admin\DriverController;
use App\Http\Controllers\admin\DriverVerificationController;
use App\Http\Controllers\driver\DriverDocumentController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\GalleryController;
use App\Http\Controllers\admin\HolidayController;
use App\Http\Controllers\admin\RoutehandleController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\admin\FixedPriceController;
use App\Http\Controllers\driver\DriverAceptedBookingController;
use App\Http\Controllers\driver\DriverBookingController;
use App\Http\Controllers\driver\DriverDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\user\DashboardController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::view('/login', 'auth.login');
Auth::routes();

   
/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {
  
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/user-account', [DashboardController::class, 'useraccount']);
    Route::post('/user-update', [DashboardController::class, 'userupdate'])->name('user.update');
    Route::view('/user-change-password', 'goods.change-password');
    Route::post('/user-change-password', [DashboardController::class, 'updatepassword']);
    Route::get('/order', [DashboardController::class, 'order']);
    Route::get('/faq', [DashboardController::class, 'faq']);
    Route::get('/blog', [DashboardController::class, 'blog']);
    Route::post('/placeorder', [DashboardController::class, 'placeorder']);
    Route::get('/booking', [DashboardController::class, 'order']);
});
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::resource('/admtestimonial', TestimonialController::class);
    Route::resource('/admblog', BlogController::class)->parameter('admblog', 'blog');
    Route::resource('/admbanner', BannerController::class);
    Route::resource('/admholiday', HolidayController::class);
    Route::resource('/admgallery', GalleryController::class);
    Route::resource('/admcar', CarController::class);
    Route::post('/admin/cars/reorder', [CarController::class, 'reorder'])->name('admin.cars.reorder');
    Route::get('/admfixedprice/export', [FixedPriceController::class, 'export'])->name('admfixedprice.export');
    Route::post('/admfixedprice/import', [FixedPriceController::class, 'import'])->name('admfixedprice.import');
    Route::resource('/admfixedprice', FixedPriceController::class);
    Route::resource('/admcar.admdistance', DistanceController::class);
    Route::resource('/admdriver', DriverController::class);
    Route::resource('/admcontent', ContentController::class);
    Route::resource('/admbook', BookController::class);
    Route::post('/admin/book/{id}/recalculate', [BookController::class, 'recalculate'])->name('admin.book.recalculate');
    Route::post('/admin/book/{id}/confirm', [BookController::class, 'confirm'])->name('admin.book.confirm');
    Route::post('/admin/book/{id}/reject', [BookController::class, 'reject'])->name('admin.book.reject');
    Route::post('/admin/book/{id}/cancel', [BookController::class, 'cancelBooking'])->name('admin.book.cancel');
    Route::post('/admin/book/{id}/record-cash', [BookController::class, 'recordCashReceived'])->name('admin.book.record-cash');
    Route::post('/admin/book/{id}/payment', [BookController::class, 'updatePayment'])->name('admin.book.payment');
    Route::resource('/admcustomer', CustomerController::class);
    Route::resource('/admin/service', ServiceController::class)->names('admin.service');
    Route::resource('/admin/routehandles', RoutehandleController::class)->names('admin.routehandles');
    Route::resource('/admin/routehandles.faq', FaqController::class)->names('admin.routehandles.faq');

    Route::post('/update-booking', [BookController::class,'updbooking']);

    // Driver & vehicle documentation - review screens
    Route::prefix('admin/driver-verification')->name('admin.dv.')->group(function () {
        Route::get('/', [DriverVerificationController::class, 'index'])->name('index');
        Route::get('/documents/{document}/file', [DriverVerificationController::class, 'file'])->middleware('throttle:120,1')->name('file');
        Route::delete('/documents/{document}', [DriverVerificationController::class, 'destroy'])->name('destroy');
        Route::post('/documents/{document}/review', [DriverVerificationController::class, 'review'])->name('review');
        Route::get('/{driver}', [DriverVerificationController::class, 'show'])->whereNumber('driver')->name('show');
        Route::post('/{driver}/details', [DriverVerificationController::class, 'details'])->whereNumber('driver')->name('details');
        Route::post('/{driver}/vehicle', [DriverVerificationController::class, 'vehicle'])->whereNumber('driver')->name('vehicle');
        Route::post('/{driver}/bank', [DriverVerificationController::class, 'bank'])->whereNumber('driver')->name('bank');
        Route::post('/{driver}/start-review', [DriverVerificationController::class, 'startReview'])->whereNumber('driver')->name('start-review');
        Route::post('/{driver}/application', [DriverVerificationController::class, 'decideApplication'])->whereNumber('driver')->name('application');
        Route::post('/{driver}/upload/{type}', [DriverVerificationController::class, 'upload'])->whereNumber('driver')->middleware('throttle:30,1')->name('upload');
    });
    // update-booking
    // Route::resource('/admweek', WeekController::class);
    // Route::resource('admweek.time', TimeController::class);
    // Route::resource('admcategory.subcategory', SubcategoryController::class);
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:manager'])->group(function () {

    // Driver & vehicle documentation (a driver only ever sees their own).
    // Deliberately outside the "active-driver" gate: applicants who registered
    // but aren't activated yet must be able to upload and fix documents.
    Route::prefix('driver-documents')->name('driver.docs.')->group(function () {
        Route::get('/', [DriverDocumentController::class, 'index'])->name('index');
        Route::post('/details', [DriverDocumentController::class, 'details'])->name('details');
        Route::post('/vehicle', [DriverDocumentController::class, 'vehicle'])->name('vehicle');
        Route::post('/bank', [DriverDocumentController::class, 'bank'])->name('bank');
        Route::post('/upload/{type}', [DriverDocumentController::class, 'upload'])->middleware('throttle:30,1')->name('upload');
        Route::get('/file/{document}', [DriverDocumentController::class, 'file'])->middleware('throttle:120,1')->name('file');
        Route::delete('/{document}', [DriverDocumentController::class, 'destroy'])->name('destroy');
    });

    // Everything else needs an active account.
    Route::middleware('active-driver')->group(function () {
        Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
        Route::resource('/driver-booking', DriverBookingController::class);
        Route::resource('/driver-accepted-booking', DriverAceptedBookingController::class);
        Route::get('/driver-account', [DriverDashboardController::class, 'useraccount'])->name('driveraccount');
        Route::post('/driver-update', [DriverDashboardController::class, 'userupdate']);
        Route::view('/driver-change-password', 'driver.changepass')->name('driverchangepass');
        Route::post('/driver-change-password', [DriverDashboardController::class, 'updatepassword'])->name('driverchangepassword.update');
    });
    // Route::resource('artcategory.artsubcategory', ArtSubcategoryController::class);
});

Route::get('/', [WebController::class, 'index']);
Route::get('/logcap', [WebController::class, 'logcap']);
Route::get('/about', [WebController::class, 'about']);
Route::get('/user-account', [WebController::class, 'useraccount']);
Route::get('/my-booking', [WebController::class, 'mybooking']);
Route::post('/booking/{id}/cancel', [WebController::class, 'cancelBooking'])->name('user.booking.cancel');

/*----------------------------------------------------------------------
 | Public booking links (emailed to the customer - work without login)
 *--------------------------------------------------------------------*/
Route::get('/booking/confirmation/{token}', [WebController::class, 'bookingConfirmation'])->name('booking.confirmation');
Route::get('/booking/{token}/receipt', [WebController::class, 'bookingReceipt'])->name('booking.receipt');
Route::get('/booking/{token}/cancel', [WebController::class, 'cancelBookingShow'])->name('booking.cancel.show');
Route::post('/booking/{token}/cancel', [WebController::class, 'cancelBookingByToken'])->name('booking.cancel.perform');
Route::get('/my-payment', [WebController::class, 'mypayment']);
Route::get('/book-now', [WebController::class, 'booknow']);
Route::get('/my-profile', [WebController::class, 'myprofile']);
Route::get('/news', [WebController::class, 'news']);
Route::get('/news/{id}', [WebController::class, 'newsdetails']);
Route::get('/gallery', [WebController::class, 'gallery']);
Route::get('/booking', [WebController::class, 'booking']);
Route::get('/faq', [WebController::class, 'faq']);
Route::get('/gallery', [WebController::class, 'gallery']);
Route::get('/contact', [WebController::class, 'contact']);
Route::post('/contact', [WebController::class, 'postcontact'])->name('frontend.contact');

Route::get('/order-review', [WebController::class, 'orderreview']);
Route::post('/order-review', [WebController::class, 'postorderreview']);
Route::post('/book-now', [WebController::class, 'postbook']);
Route::get('/user-login', [WebController::class, 'userlogin']);
Route::get('/driver-login', [WebController::class, 'driverlogin']);
Route::get('/user-register', [WebController::class, 'userregister']);
Route::get('/driver-register', [WebController::class, 'driverregister']);
Route::view('/track', 'web.send');
Route::get('/trackdet', [WebController::class, 'trackdet']);
Route::post('/postregister', [WebController::class, 'postuserregister']);
Route::post('/post-driver-register', [WebController::class, 'postdriverregister']);
Route::get('/contents/{menu}', [WebController::class, 'contents']);
Route::get('/pricing', [PricingController::class, 'pricing']);
Route::post('/get-quote', [WebController::class, 'pricing'])->name('get-quote');
Route::get('/review', [WebController::class, 'review'])->name('review');
Route::view('/thankyou', 'goods.thankyou');

Route::get('/service-details/{slug}', [WebController::class, 'serviceDetails'])->name('service.details');
Route::get('/route-details/{slug}', [WebController::class, 'routeDetails'])->name('route.details');
Route::get('/generate-pdf/{id}', [PDFController::class, 'generatePDF'])->name('generate.pdf');

Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::get('success', 'success');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

Route::get('/send-mail/{id}', [StripePaymentController::class, 'show']);
Route::get('/content/{id}', [WebController::class, 'contents']);

Route::view('same-day-courier-service','goods.same-day-courier-service');
Route::view('pallet-delivery-service','goods.pallet-delivery-service');
Route::view('international-shipping','goods.international-shipping');
Route::view('quotation','goods.quotation');
Route::view('storage-services','goods.storage-services');