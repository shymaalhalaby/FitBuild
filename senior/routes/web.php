<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\coachController;
use App\Http\Controllers\memberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;

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


Route::group(['middleware' => ['web']], function () {
    Route::post('/gymregister', [AuthController::class, 'gymregister']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/payment', [PaymentController::class, 'processPayment']);
    Route::post('/completeGymRegister/{userId}', [AuthController::class, 'completeGymRegister']);
    Route::put('/gym/{gymId}', [GymController::class, 'update']);
    Route::get('/gyms/CoachesRequest/{gymId}', [GymController::class, 'getCoachesByGym']);
    Route::put('/AcceptCoachesRequest/{RequestId}', [GymController::class, 'AcceptCoachRequest']);
    Route::put('/RejectCoachesRequest/{RequestId}', [GymController::class, 'RejectCoachRequest']);
    Route::get('/gyms/CoachesAccepted/{gymId}', [GymController::class, 'getAcceptCoachesByGym']);
    Route::get('/showCoachProfile/{coachId}', [coachController::class, 'showCoachProfile']);

    Route::get('/gyms/NutritionistRequest/{gymId}', [GymController::class, 'getNutritionistsByGym']);
    Route::put('/AcceptNutritionistsRequest/{RequestId}', [GymController::class, 'AcceptNutritionistRequest']);
    Route::put('/RejectNutritionistsRequest/{RequestId}', [GymController::class, 'RejectNutritionistRequest']);
    Route::get('/gyms/NutritionistsAccepted/{gymId}', [GymController::class, 'getAcceptNutritionistsByGym']);
    Route::get('/showNutritionistProfile/{NutritionistId}', [coachController::class, 'showNutritionistProfile']);

    Route::get('/gyms/memberRequest/{gymId}', [GymController::class, 'getmembersByGym']);
    Route::put('/AcceptmembersRequest/{RequestId}', [GymController::class, 'AcceptmemberRequest']);
    Route::put('/RejectmembersRequest/{RequestId}', [GymController::class, 'RejectmemberRequest']);
    Route::get('/gyms/membersAccepted/{gymId}', [GymController::class, 'getAcceptmembersByGym']);
    Route::get('/showmemberprofile/{memberID}', [MemberController::class, 'show']);


    Route::get('/notifications/{gymId}', [NotificationController::class, 'index']);
    Route::post('/notification/{gymId}/{id}', [NotificationController::class, 'markAsRead']);



});





