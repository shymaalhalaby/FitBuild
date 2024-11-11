<?php
use App\Models\User;
use App\Models\member;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\memberResource;
use App\Http\Controllers\gymController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\coachController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\lunchController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\DinnerController;
use App\Http\Controllers\memberController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\dietplanController;
use App\Http\Controllers\BreakfastController;
use App\Http\Controllers\DailyDietController;
use App\Http\Controllers\ExcerciseController;
use App\Http\Controllers\CoachMemberController;
use App\Http\Controllers\MonthlyPlanController;
use App\Http\Controllers\coach_memberController;
use App\Http\Controllers\nutritionistController;
use App\Http\Controllers\DailyExerciseController;
use App\Http\Controllers\MultipleUploadController;
use App\Http\Controllers\BreakFastMemberController;
use App\Http\Controllers\MemberExcerciseController;
use App\Http\Controllers\PlanedExcerciseController;
use App\Http\Controllers\PlannedExcerciseController;
use App\Http\Controllers\NutritionistMemberController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api'
], function () {
    Route::group([
        'prefix' => 'auth'
    ], function ($router) {

        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::patch('/profile/{userId}', [coachController::class, 'profile']);
        Route::post('/storeUserImage/{userId}', [ImageController::class, 'storeUserImage']);
        Route::put('/updateProfile/{userId}', [coachController::class, 'updateProfile']);
        Route::get('/gym-profile/{gymId}', [gymController::class, 'getGymProfile']);
        Route::get('/CoachesOfGym/{gymId}', [GymController::class, 'getAcceptedCoaches']);
    });

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::patch('/profile', [MemberController::class, 'profile']);


        Route::get('/showmemberprofile/{memberID}', [MemberController::class, 'show']);

        Route::post('/images/{memberID}', [ImageController::class, 'store']);

        Route::get('/getFreelanceCoaches', [CoachController::class, 'getFreelanceCoaches']);
        Route::put('/editmemberprofile', [MemberController::class, 'updateMemberProfile']);
        Route::get('/gym-addresses', [gymController::class, 'getAllAddresses']);
        Route::get('/gyms-names-logos', [gymController::class, 'getGymsNamesAndAddress']);


        Route::get('/NutritionistsOfGym/{gymId}', [GymController::class, 'getAcceptedNutritionist']);

        Route::post('/CN-send-request/{gymId}', [gymController::class, 'CNsendRequest']);
        Route::delete('/CN-cancel-request/{gymId}', [gymController::class, 'CNcancelRequest']);

        Route::get('/getFreelanceNutritionists', [NutritionistController::class, 'getFreelanceNutritionists']);
        Route::get('/showCNProfile/{userId}', [CoachController::class, 'showProfile']);

        Route::post('/sendRequestToCN/{userId}', [CoachMemberController::class, 'sendRequest']);

        Route::get('/CNshowRequests', [CoachMemberController::class, 'showRequests']);
        Route::get('/CNshowsubscribers', [CoachMemberController::class, 'showSubscribers']);
        Route::post('/CNacceptRequest/{id}', [CoachMemberController::class, 'AcceptRequest']);//pass id of request
        Route::post('/CNRejectRequest/{id}', [CoachMemberController::class, 'RejectRequest']);//pass id of request
        Route::delete('CancleRequestOfCN/{userId}', [CoachMemberController::class, 'cancelRequest']);



        Route::post('/member/send-request/{memberID}/{gymId}', [gymController::class, 'MemberSendRequestToGym']);
        Route::delete('/member/cancle-request/{memberID}/{gymId}', [gymController::class, 'cancleMemberRequest']);

        Route::post('/creatediets', [DietController::class, 'store']);
        Route::post('/createweek/{memberId}/{dietId}', [DietController::class, 'createweek']);

        Route::get('/weeks', [DietController::class, 'getWeeksByMember']);
        Route::get('/diets/{weekId}', [DietController::class, 'getDietByWeek']);




        Route::apiResource('members', MemberController::class);

        Route::post('/excercises', [ExcerciseController::class, 'store']);
        Route::post('/AddExcercise', [ExcerciseController::class, 'store']);
        Route::get('/excercise', [ExcerciseController::class, 'index']);
        Route::get('/excercisess/{Excercise}', [ExcerciseController::class, 'show']);
        Route::post('/PlannedExercise/{Excercise}/{DailyExercise}', [PlaneController::class, 'store']);
        Route::get('/PlanedExcerciseWithExercise/{id}', [PlaneController::class, 'index']);
        Route::put('/PlanedExcercise/{id}', [PlaneController::class, 'update']);
        Route::get('/DailyExercise/{member}', [DailyExerciseController::class, 'getByMember']);
        Route::post('/DailyExercise/{member}', [DailyExerciseController::class, 'store']);
        Route::post('/DailyExercise/{member}/{day}/done', [DailyExerciseController::class, 'finish']);
        Route::get('/getPlans/{dailyExerciseId}', [PlaneController::class, 'getPlans']);







    });

});












