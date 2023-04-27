<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ParticipantController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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

Auth::routes(['verify' => true]);

Route::get('/register', function () {
    return view('NotFound');
});
Route::get('/password-reset', function () {
    return view('NotFound');
});
Route::get('/forget-password', function () {
    return view('NotFound');
});




// Route::post('/event-checkout', [HomeController::class, 'event_checkout'])->name('event-checkout');




Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}/{name}', [HomeController::class, 'eventForm'])->name('eventForm');
Route::post('/event-registration', [HomeController::class, 'eventFormRegistration'])->name('eventFormRegistration');


Route::post('/mail-check', [HomeController::class, 'mail_check'])->name('mail-check');
Route::get('/phone-check', [HomeController::class, 'phone_check'])->name('phone-check');
Route::post('/phone-verification', [HomeController::class, 'phone_verification'])->name('phone-verification');
Route::post('/fetch-user', [HomeController::class, 'fetch_user'])->name('fetch-user');
Route::post('/form-submission', [HomeController::class, 'formSubmission'])->name('formSubmission');
Route::post('/check-participant', [HomeController::class, 'check_participant'])->name('check-participant');



Route::post('/otp-request', [OtpController::class, 'otp_request'])->name('otp-request');
Route::get('/otp-request/{token}', [OtpController::class, 'otp_verification_form'])->name('otp-verification-form');
Route::post('/otp-request/send', [OtpController::class, 'send_otp'])->name('send-otp');
Route::post('/otp-request/resend', [OtpController::class, 'resend_otp'])->name('resend-otp');
Route::post('/otp-verification', [OtpController::class, 'otp_verification'])->name('otp-verification');


Route::get('/thankyou', [HomeController::class, 'thankyou'])->name('thankyou');

Route::get('/transaction', [HomeController::class, 'transaction'])->name('transaction');
Route::post('/user-login', [LoginController::class, 'LOGIN'])->name('LOGIN');

Route::resource('/payments', PaymentController::class);

// Route::post('/confirm-payment', [HomeController::class, 'confirmPayment'])->name('confirmPayment');

#~~~~~~~~~~~~ all admin panel routes ~~~~~~~~~~~~~~

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:super-admin|admin']], function () {
    
    Route::get('/dashboard', [AdminController::class,   'dashboard'])->name('admin_dashboard');
    
    Route::resource('/events', EventController::class);
    Route::get('/events/visibility/{id}', [EventController::class, 'visibility'])->name('event_visibility');
    
    
    Route::resource('/participants', ParticipantController::class);
    Route::get('/participants/register/{participant}', [ParticipantController::class, 'register_event'])->name('register-event');
    Route::get('/payment-details', [ParticipantController::class, 'payment_details']);
    // Route::get('/participants/{id}/{payment_id}', [ParticipantController::class, 'custom'])->name('participant_list');
    // Route::get('/participants/list/{id}', [ParticipantController::class, 'custom'])->name('participant_list');
    


    Route::get('/payment/verify/{id}', [PaymentController::class, 'payment_verify'])->name('payment-verify');




    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'profile_edit'])->name('profile_edit');
    Route::post('/profile/update', [ProfileController::class, 'profile_update'])->name('profile_update');

    Route::get('/otp-list', [AdminController::class, 'otp_list'])->name('otp_list');
});



Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:super-admin']], function () {

    Route::resource('/admin-list', CreateUserController::class);
});
