<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SalesManController;
use App\Http\Controllers\API\PromotionController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\SettingsController;
use App\Http\Controllers\API\SmsController;
use App\Http\Controllers\API\EmailController;
use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\API\UserController ;
use App\Http\Controllers\API\RoleController ;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\MenuController ;
use App\Http\Controllers\API\LeadsController;
use App\Http\Controllers\API\LeadController;
use App\Http\Middleware\ExampleMiddleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// public routes

Route::get("/products", [ProductController::class, 'index']);
Route::get("/products/{id}", [ProductController::class, 'show']);
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
Route::post('/leads/request', [LeadController::class, 'uploadLeads']);





// protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
	Route::get('/products/search/{name}', [ProductController::class, 'search']);
	Route::post("/products", [ProductController::class, 'store']);
	Route::put("/products/{id}", [ProductController::class, 'update']);
	Route::delete("/products/{id}", [ProductController::class, 'destroy']);
	Route::post("/logout", [AuthController::class, 'logout']);

	// salesman management
	Route::get("/salesman-list", [SalesManController::class, 'index']);
	Route::post("/salesman-create", [SalesManController::class, 'store']);
	Route::put("/salesman-update/{id}", [SalesManController::class, 'update']);
	Route::get("/salesman/{id}", [SalesManController::class, 'show']);
	Route::delete("/salesman/{id}", [SalesManController::class, 'destroy']);

	// SETTINGS MODULE
	Route::get("/country-list", [SettingsController::class, 'country_index']);
	Route::post("/country-create", [SettingsController::class, 'country_store']);
	Route::put("/country-update/{id}", [SettingsController::class, 'country_update']);
	Route::get("/country/{id}", [SettingsController::class, 'country_show']);
	Route::delete("/country/{id}", [SettingsController::class, 'country_destroy']);

	Route::get("/city-list", [SettingsController::class, 'city_index']);
	Route::post("/city-create", [SettingsController::class, 'city_store']);
	Route::put("/city-update/{id}", [SettingsController::class, 'city_update']);
	Route::get("/city/{id}", [SettingsController::class, 'city_show']);
	Route::delete("/city", [SettingsController::class, 'city_destroy']);

	Route::get("/state-list", [SettingsController::class, 'state_index']);
	Route::post("/state-create", [SettingsController::class, 'state_store']);
	Route::post("/state-update", [SettingsController::class, 'state_update']);
	Route::get("/state/{id}", [SettingsController::class, 'state_show']);
	Route::post("/state-delete", [SettingsController::class, 'state_destroy']);

	Route::get("/branch-list", [SettingsController::class, 'branch_index']);
	Route::post("/branch-create", [SettingsController::class, 'branch_store']);
	Route::post("/branch-update", [SettingsController::class, 'branch_update']);
	Route::get("/branch/{id}", [SettingsController::class, 'branch_show']);
	Route::post("/branch-delete", [SettingsController::class, 'branch_destroy']);

	//Promotion
	Route::get("/promotion-list", [PromotionController::class, 'index']);
	Route::post("/promotion-create", [PromotionController::class, 'store']);
	Route::put("/promotion-update/{id}", [PromotionController::class, 'update']);
	Route::get("/promotion/{id}", [PromotionController::class, 'show']);
	Route::delete("/promotion/{id}", [PromotionController::class, 'destroy']);


	//Campaign
	Route::get("/campaign-list", [CampaignController::class, 'index']);
	Route::post("/campaign-create", [CampaignController::class, 'store']);
	Route::put("/campaign-update/{id}", [CampaignController::class, 'update']);
	Route::get("/campaign/{id}", [CampaignController::class, 'show']);
	Route::delete("/campaign/{id}", [CampaignController::class, 'destroy']);


	/*
		---------------- SMS MODULE ----------------
	*/
	Route::get("/sms-template-list", [SmsController::class, 'sms_template_list']);
	Route::post("/sms-template-create", [SmsController::class, 'sms_template_create']);
	Route::post("/sms-template-update", [SmsController::class, 'sms_template_update']);
	Route::get("/sms-template/{id}", [SmsController::class, 'sms_template_show']);
	Route::post("/sms-template-delete", [SmsController::class, 'sms_template_destroy']);

	Route::post("/send-sms", [SmsController::class, 'send_sms']);
	Route::get("/sms-queue-list", [SmsController::class, 'sms_queue_list']);
	Route::get("/sms-log-list", [SmsController::class, 'sms_log_list']);
	Route::get("/sms-queue-details/{id}", [SmsController::class, 'sms_queue_details']);
	Route::get("/sms-log-details/{id}", [SmsController::class, 'sms_log_details']);
	Route::delete("/single-sms-queue-delete/{id}", [SmsController::class, 'single_sms_queue_delete']);
	Route::delete("/all-sms-queue-delete", [SmsController::class, 'all_sms_queue_delete']);



	/*
		---------------- EMAIL MODULE ----------------
	*/
	Route::get("/email-template-list", [EmailController::class, 'email_template_list']);
	Route::post("/email-template-create", [EmailController::class, 'email_template_create']);
	Route::post("/email-template-update", [EmailController::class, 'email_template_update']);
	Route::get("/email-template/{id}", [EmailController::class, 'email_template_show']);
	Route::post("/email-template-delete", [EmailController::class, 'email_template_destroy']);

	Route::post("/send-email", [EmailController::class, 'send_email']);
	Route::get("/email-queue-list", [EmailController::class, 'email_queue_list']);
	Route::get("/email-log-list", [EmailController::class, 'email_log_list']);
	Route::get("/email-queue-details/{id}", [EmailController::class, 'email_queue_details']);
	Route::get("/email-log-details/{id}", [EmailController::class, 'email_log_details']);
	Route::delete("/single-email-queue-delete/{id}", [EmailController::class, 'single_email_queue_delete']);
	Route::delete("/all-email-queue-delete", [EmailController::class, 'all_email_queue_delete']);

	/*
		---------------- USER MANAGEMENT MODULE ----------------
	*/
    Route::get('user-list',        [UserController::class, 'index']);
    Route::get('user-show/{id}',        [UserController::class, 'show']);
    Route::post('user-store',      [UserController::class, 'store']);
    Route::put('user-update/{id}',      [UserController::class, 'update']);
    Route::get('user-details/{id}',     [UserController::class, 'show']);
    Route::delete('user-delete/{id}',   [UserController::class, 'destroy']);
    Route::put('user-change-status/{id}', [UserController::class, 'userStatusChange']);
    Route::put('change-password',    [UserController::class, 'changePassword']);
    
    Route::get('role-list', [RoleController::class, 'index']);
    Route::post('role-store', [RoleController::class, 'store']);
    Route::put('role-update/{id}', [RoleController::class, 'update']);
    Route::get('role-details/{id}', [RoleController::class, 'show']);
    Route::delete('role-delete/{id}', [RoleController::class, 'destroy']);
    
    Route::get('menu-list', [MenuController::class, 'index']);
    Route::post('menu-store', [MenuController::class, 'store']);
    Route::put('menu-update/{id}', [MenuController::class, 'update']);
    Route::get('menu-details/{id}', [MenuController::class, 'show']);
    Route::delete('menu-delete/{id}', [MenuController::class, 'destroy']); 

    Route::get('sub-menu-list', [PermissionController::class, 'index']);
    Route::post('sub-menu-store', [PermissionController::class, 'store']);
    Route::put('sub-menu-update/{id}', [PermissionController::class, 'update']);
    Route::get('sub-menu-details/{id}', [PermissionController::class, 'show']);
    Route::delete('sub-menu-delete/{id}', [PermissionController::class, 'destroy']);

	/*
		---------------- Leads Management MODULE ----------------
	*/
	Route::get('leads-form-list', [LeadsController::class, 'index']);
	Route::post('create-leads-form', [LeadsController::class, 'store']);
    Route::put('update-leads-form', [LeadsController::class, 'update']);
    Route::get('show-leads-form/{id}', [LeadsController::class, 'show']);
    Route::delete('delete-leads-form/{id}', [LeadsController::class, 'destroy']);


});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
