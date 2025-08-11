<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeadsFormController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\DynamicTableController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceCustomFormController;
use App\Http\Controllers\ProductSpecificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FormFeatureController;


use App\Models\Promotion;

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


Route::get('/', [AuthController::class, 'index'])->name('login_index');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post_login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('send-pending-email', [EmailController::class, 'sendPendingEmail'])->name('send-pending-email');

Route::group(['middleware' => ['auth']], function () {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
	Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

	// agents route
	Route::get('/agents', [AgentController::class, 'index'])->name('agents-index')->middleware(['check-permission']);
    Route::get('/agents/create', [AgentController::class, 'create'])->name('agents-create')->middleware(['check-permission']);
	Route::post('/agents', [AgentController::class, 'store'])->name('agents-store');
	Route::get('/agents/{id?}', [AgentController::class, 'show'])->name('agents-show')->middleware(['check-permission']);
	Route::get('/agents/{id?}/edit', [AgentController::class, 'edit'])->name('agents-edit')->middleware(['check-permission']);
	Route::put('/agents/{id?}', [AgentController::class, 'update'])->name('agents-update');
	Route::post('/agents/search', [AgentController::class, 'search'])->name('agents-search');
	Route::delete('/agents/{id?}', [AgentController::class, 'destroy'])->name('agents-destroy')->middleware(['check-permission']);
	// end agents

	// Lead routes
	//Route::get('/lead', [LeadController::class, 'index'])->name('lead-index');
	Route::get('/leads/{form_id?}', [LeadController::class, 'index'])->name('lead-index')->middleware(['check-permission']);
	Route::get('/lead/total-lead', [LeadController::class, 'total_lead'])->name('total-lead');
	Route::get('/lead/create', [LeadController::class, 'create'])->name('lead-create')->middleware(['check-permission']);
	Route::get('/lead/leads-upload', [LeadController::class, 'leads_upload'])->name('leads-upload')->middleware(['check-permission']);
	Route::get('/lead/leads-json-upload', [LeadController::class, 'leads_json_upload'])->name('leads-json-upload')->middleware(['check-permission']);
	Route::get('/lead/sample-file', [LeadController::class, 'downloadSampleFile'])->name('sample-file');

	Route::post('/lead/upload', [LeadController::class, 'upload_file'])->name('lead-upload-file');
	Route::post('/lead/upload/json', [LeadController::class, 'upload_json_file'])->name('lead-upload-json-file');

    Route::post('/lead', [LeadController::class, 'store'])->name('lead-store');
	Route::post('/lead/quick-lead-store', [LeadController::class, 'quickLeadStore'])->name('quick-lead-store');
	Route::get('/lead/{id?}', [LeadController::class, 'show'])->name('lead-show')->middleware(['check-permission']);
	Route::get('/lead/{id?}/edit', [LeadController::class, 'edit'])->name('lead-edit')->middleware(['check-permission']);
	Route::put('/lead/{id}', [LeadController::class, 'update'])->name('lead-update');
	Route::delete('/lead/{id?}', [LeadController::class, 'destroy'])->name('lead-destroy')->middleware(['check-permission']);
	Route::post('/lead/search', [LeadController::class, 'search'])->name('lead-search');
	//Route::get('/leads/add/{tableName}', [LeadController::class, 'add'])->name('leads.add');
	Route::get('/leads/add/{tableName?}/{leadId?}', [LeadController::class, 'add'])->name('leads-add')->middleware(['check-permission']);
	Route::post('/leads/store-tabledata', [LeadController::class, 'storeTableData'])->name('store-tabledata');
    Route::delete('/leads/delete-tabledata/{tableName?}/{id?}/{leadId?}', [LeadController::class, 'deleteTableData'])->name('delete-tabledata')->middleware(['check-permission']);
	Route::get('/lead/edit-tabledata/{tableName?}/{leadId?}/edit', [LeadController::class, 'editTableData'])->name('lead-edit-tabledata')->middleware(['check-permission']);
	Route::post('/lead/update-table-data', [LeadController::class, 'updateTableData'])->name('update-tabledata');
	Route::post('/lead/update-table-data-show', [LeadController::class, 'updateTableDatashow'])->name('update-tabledata-show');
	// search lead on url
	Route::get('/leads/phone/{phone?}', [LeadController::class, 'search_phone'])->name('search-by-phone');
	Route::put('/leads/{id}/update-lead-profile-image', [LeadController::class, 'updateLeadProfileImage'])->name('update-lead-profile-image');
	

	//Route::get('/leads/add', 'LeadController@add')->name('leads.add');
	
    //Lead Form route
	Route::get('/leads-forms', [LeadsFormController::class, 'index'])->name('leadsform-index')->middleware(['check-permission']);
	Route::get('/leads-forms/create', [LeadsFormController::class, 'create'])->name('leadsform-create')->middleware(['check-permission']);
	Route::post('/leads-forms', [LeadsFormController::class, 'store'])->name('leadsform-store');
	Route::get('/leads-forms/{id?}', [LeadsFormController::class, 'show'])->name('leadsform-show')->middleware(['check-permission']);
	Route::get('/leads-forms/{id?}/edit', [LeadsFormController::class, 'edit'])->name('leadsform-edit')->middleware(['check-permission']);
	Route::put('/leads-forms/{id}', [LeadsFormController::class, 'update'])->name('leadsform-update');
	Route::delete('/leads-forms/{id?}', [LeadsFormController::class, 'destroy'])->name('leadsform-destroy')->middleware(['check-permission']);
	Route::post('/leads-forms/search', [LeadsFormController::class, 'search'])->name('leadsform-search');
	

	//Lead dynamic table route
	Route::get('/dynamic-table', [DynamicTableController::class, 'index'])->name('dynamictable-index')->middleware(['check-permission']);
	Route::get('/dynamic-table/create', [DynamicTableController::class, 'create'])->name('dynamictable-create')->middleware(['check-permission']);
	Route::get('/dynamic-table/{id?}/edit', [DynamicTableController::class, 'edit'])->name('dynamictable-edit')->middleware(['check-permission']);
    Route::put('/dynamic-table/{id}', [DynamicTableController::class, 'update'])->name('dynamictable-update');
	Route::post('dynamic-table/create', [DynamicTableController::class, 'createTable'])->name('dynamictable-store');
	Route::get('/dynamic-table/{tableName?}', [DynamicTableController::class, 'show'])->name('dynamictable-show')->middleware(['check-permission']);
	Route::delete('/dynamic-table/{id?}', [DynamicTableController::class, 'destroy'])->name('dynamictable-destroy')->middleware(['check-permission']);
	Route::post('/dynamic-table/search', [DynamicTableController::class, 'search'])->name('dynamictable-search');

    //promotion route
	Route::get('/promotion', [PromotionController::class, 'index'])->name('promotion-index')->middleware(['check-permission']);
	Route::get('/promotion/create', [PromotionController::class, 'create'])->name('promotion-create')->middleware(['check-permission']);
	Route::post('/promotion', [PromotionController::class, 'store'])->name('promotion-store');
	Route::get('/promotion/{id?}', [PromotionController::class, 'show'])->name('promotion-show')->middleware(['check-permission']);
	Route::get('/promotion/{id?}/edit', [PromotionController::class, 'edit'])->name('promotion-edit')->middleware(['check-permission']);
	Route::put('/promotion/{id}', [PromotionController::class, 'update'])->name('promotion-update');
	Route::delete('/promotion/{id?}', [PromotionController::class, 'destroy'])->name('promotion-destroy');
	Route::post('/promotion/search', [PromotionController::class, 'search'])->name('promotion-search');

	//Campaign route
	Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign-index')->middleware(['check-permission']);
	Route::get('/campaign/create', [CampaignController::class, 'create'])->name('campaign-create')->middleware(['check-permission']);
	Route::get('/campaign/campaign-sample-file', [CampaignController::class, 'downloadCampaignSampleFile'])->name('campaign-sample-file');
	Route::post('/campaign/campaign-lead-file-upload', [CampaignController::class, 'campaign_lead_upload_file'])->name('campaign-lead-upload-file');
	Route::post('/campaign', [CampaignController::class, 'store'])->name('campaign-store');
	Route::get('/campaign/{id?}', [CampaignController::class, 'show'])->name('campaign-show')->middleware(['check-permission']);
	Route::get('/campaign/{id?}/edit', [CampaignController::class, 'edit'])->name('campaign-edit')->middleware(['check-permission']);
	Route::put('/campaign/{id}', [CampaignController::class, 'update'])->name('campaign-update');
	Route::delete('/campaign/{id?}', [CampaignController::class, 'destroy'])->name('campaign-destroy')->middleware(['check-permission']);
	Route::post('/campaign/search', [CampaignController::class, 'search'])->name('campaign-search');
	Route::post('/clear-session', [CampaignController::class, 'clearSession'])->name('clear.session');
	Route::get('/campaign/campaign-lead-upload/{id?}', [CampaignController::class, 'campaign_leads_upload'])->name('campaign-lead-upload')->middleware(['check-permission']);
	Route::get('/campaign/campaign-data/{id?}', [CampaignController::class, 'campaign_data'])->name('campaign-data')->middleware(['check-permission']);
	Route::get('/campaign/start/{id?}', [CampaignController::class, 'startCampaign'])->name('campaign-start');
    Route::get('/campaign/stop/{id?}', [CampaignController::class, 'stopCampaign'])->name('campaign-stop');

	Route::get('/meeting', [MeetingController::class, 'index'])->name('meeting-index')->middleware(['check-permission']);
    Route::get('/meeting/create', [MeetingController::class, 'create'])->name('meeting-create')->middleware(['check-permission']);
    Route::post('/meeting', [MeetingController::class, 'store'])->name('meeting-store');
    Route::get('/meeting/{id?}', [MeetingController::class, 'show'])->name('meeting-show')->middleware(['check-permission']);
    Route::get('/meeting/{id?}/edit', [MeetingController::class, 'edit'])->name('meeting-edit')->middleware(['check-permission']);
    Route::put('/meeting/{id}', [MeetingController::class, 'update'])->name('meeting-update');
    Route::delete('/meeting/{id?}', [MeetingController::class, 'destroy'])->name('meeting-destroy')->middleware(['check-permission']);
    Route::post('/meeting/search', [MeetingController::class, 'search'])->name('meeting-search');
	Route::put('/meeting/{id?}/update-attachments-file', [MeetingController::class, 'updateAttachmentsFile'])->name('update-attachments-file');
	Route::post('/meeting/meeting-update-feedback/{id?}', [MeetingController::class, 'updateFeedback'])->name('meeting-update-feedback');
	Route::get('/meeting-feedback/{id?}', [MeetingController::class, 'getMeetingFeedback'])->name('meeting-feedback');

    // invoice route
	Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice-index')->middleware(['check-permission']);
	//Route::get('/invoice/create/{id?}', [InvoiceController::class, 'create'])->name('invoice-create')->middleware(['check-permission']);
	Route::get('/invoice/create/{leadid?}', [InvoiceController::class, 'create'])->name('invoice-create')->middleware(['check-permission']);
	Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice-store');
	Route::get('/invoice/{id?}', [InvoiceController::class, 'show'])->name('invoice-show')->middleware(['check-permission']);
	Route::get('/invoice/{id?}/edit', [InvoiceController::class, 'edit'])->name('invoice-edit')->middleware(['check-permission']);
	Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('invoice-update');
	Route::delete('/invoice/{id?}', [InvoiceController::class, 'destroy'])->name('invoice-destroy');
	Route::post('/invoice/search', [InvoiceController::class, 'search'])->name('invoice-search');
	Route::get('/invoice/{invoiceId}/download', [InvoiceController::class, 'downloadInvoice'])->name('invoice-download');
	Route::post('/invoice/{invoice}/payment', [InvoiceController::class, 'storePayment'])->name('invoice-payment');
    Route::get('/invoice/get-work-orders/{customer_id}', [InvoiceController::class, 'getWorkOrders']);
	Route::post('/invoices/{invoice}/payment/{index}/deposit', [InvoiceController::class, 'updateDepositStatus'])->name('deposit-status-update');


    
	


	// invoice custom form route
	Route::get('/invoice-custom', [InvoiceCustomFormController::class, 'index'])->name('invoice-custom-index')->middleware(['check-permission']);
	Route::get('/invoice-custom/create', [InvoiceCustomFormController::class, 'create'])->name('invoice-custom-create')->middleware(['check-permission']);
	Route::post('/invoice-custom', [InvoiceCustomFormController::class, 'store'])->name('invoice-custom-store');
	Route::get('/invoice-custom/{id?}', [InvoiceCustomFormController::class, 'show'])->name('invoice-custom-show')->middleware(['check-permission']);
	Route::get('/invoice-custom/{id?}/edit', [InvoiceCustomFormController::class, 'edit'])->name('invoice-custom-edit')->middleware(['check-permission']);
	Route::put('/invoice-custom/{id}', [InvoiceCustomFormController::class, 'update'])->name('invoice-custom-update');
	Route::delete('/invoice-custom/{id?}', [InvoiceCustomFormController::class, 'destroy'])->name('invoice-custom-destroy');
	Route::post('/invoice-custom/search', [InvoiceCustomFormController::class, 'search'])->name('invoice-custom-search');
	Route::get('/invoice-custom/{invoiceId}/download', [InvoiceCustomFormController::class, 'downloadInvoice'])->name('invoice-custom-download');
	

	
	// users route
    Route::get('user-list',        [UserController::class, 'index'])->name('users.index')->middleware(['check-permission']);
    Route::get('user-show/{id?}',        [UserController::class, 'show'])->name('user.show')->middleware(['check-permission']);
    Route::get('create-user',      [UserController::class, 'create'])->name('create-user')->middleware(['check-permission']);
    Route::post('create-user',      [UserController::class, 'store'])->name('store-user');
    Route::get('edit-user/{id?}',      [UserController::class, 'edit_form'])->name('user.edit')->middleware(['check-permission']);
    Route::post('user-update',      [UserController::class, 'update'])->name('user.update');
    Route::get('user-details/{id?}',     [UserController::class, 'show'])->middleware(['check-permission']);
    Route::delete('user-delete/{id?}',   [UserController::class, 'destroy'])->name('user.destroy')->middleware(['check-permission']);
	Route::get('user-profile/{id}',        [UserController::class, 'user_profile'])->name('user-profile');
	Route::get('/account-settings/{id?}/edit', [UserController::class, 'profile_edit'])->name('profile-edit');
	Route::put('/account-settings/{id}', [UserController::class, 'profile_update'])->name('profile-update');
	Route::post('/user/search', [UserController::class, 'search'])->name('user-search');
	Route::put('/user/{id}/update-profile-image', [UserController::class, 'updateProfileImage'])->name('update-profile-image');
	Route::get('app-settings', [UserController::class, 'app_settings'])->name('app-settings')->middleware(['check-permission']);
	Route::post('app-settings', [UserController::class, 'store_app_settings'])->name('save-app-settings');

    Route::get('permission-list',        [UserController::class, 'permission_index'])->name('permission.index')->middleware(['check-permission']);
    Route::get('permission-show/{id}',        [UserController::class, 'permission_show'])->name('permission.show')->middleware(['check-permission']);
    Route::get('create-permission',      [UserController::class, 'permission_create'])->name('create-permission')->middleware(['check-permission']);
    Route::post('create-permission',      [UserController::class, 'permission_store'])->name('store-permission')->middleware(['check-permission']);
    Route::get('edit-permission/{id}',      [UserController::class, 'permission_edit'])->name('permission.edit')->middleware(['check-permission']);
    Route::post('permission-update',      [UserController::class, 'permission_update'])->name('permission.update')->middleware(['check-permission']);
    Route::get('permission-details/{id}',     [UserController::class, 'permission_show'])->middleware(['check-permission']);
    Route::delete('permission-delete/{id}',   [UserController::class, 'permission_destroy'])->name('permission.destroy')->middleware(['check-permission']);
	Route::post('/permission/search', [UserController::class, 'permission_search'])->name('permission-search')->middleware(['check-permission']);

    Route::get('role-list',        [UserController::class, 'role_index'])->name('role-list')->middleware(['check-permission']);
    Route::get('role-show/{id}',        [UserController::class, 'role_show'])->name('role.show')->middleware(['check-permission']);
    Route::get('role-create',      [UserController::class, 'role_create'])->name('role-create')->middleware(['check-permission']);
    Route::post('role-create',      [UserController::class, 'role_store'])->name('role-store')->middleware(['check-permission']);
    Route::get('role-edit/{id}',      [UserController::class, 'role_edit'])->name('role-edit')->middleware(['check-permission']);
    Route::post('role-update',      [UserController::class, 'role_update'])->name('role-update')->middleware(['check-permission']);
    Route::delete('role-delete/{id}',   [UserController::class, 'role_destroy'])->name('role-destroy')->middleware(['check-permission']);
	Route::post('/role/search', [UserController::class, 'role_search'])->name('role-search')->middleware(['check-permission']);

	// Email template routes start
	Route::get('email-template', [EmailController::class, 'emailTemplateList'])->name('email-template')->middleware(['check-permission']);
	Route::get('email-template/create', [EmailController::class, 'templateCreate'])->name('email-template-create')->middleware(['check-permission']);
	Route::post('email-template/store', [EmailController::class, 'templateStore'])->name('email-template-store');
	Route::get('email-template/edit/{id?}', [EmailController::class, 'templateEdit'])->name('email-template-edit')->middleware(['check-permission']);
	Route::get('email-template/show/{id?}', [EmailController::class, 'templateShow'])->name('email-template-show')->middleware(['check-permission']);
	Route::put('email-template/update/{id}', [EmailController::class, 'templateUpdate'])->name('email-template-update');
	Route::delete('email-template/delete/{id?}', [EmailController::class, 'templateDelete'])->name('email-template-delete')->middleware(['check-permission']);
	// Email template routes end

	// Send email routes start
	Route::get('send-email', [EmailController::class, 'sendEmail'])->name('send-email')->middleware(['check-permission']);
	Route::post('send-email-process', [EmailController::class, 'sendEmailPro'])->name('send-email-process');

	Route::get('send-email-list', [EmailController::class, 'sendEmailList'])->name('send-email-list')->middleware(['check-permission']);
	Route::get('send-bulk-email', [EmailController::class, 'sendBulkEmail'])->name('send-bulk-email')->middleware(['check-permission']);
	Route::post('send-bulk-email-process', [EmailController::class, 'sendBulkEmailPro'])->name('send-bulk-email-process');
	Route::get('send-email/show/{id?}', [EmailController::class, 'getEmailSendById'])->name('send-email-show')->middleware(['check-permission']);

	// Send email routes end

	// Sms template routes start
	Route::get('sms-template', [SmsController::class, 'smsTemplateList'])->name('sms-template')->middleware(['check-permission']);
	Route::get('sms-template/create', [SmsController::class, 'templateCreate'])->name('sms-template-create')->middleware(['check-permission']);
	Route::post('sms-template/store', [SmsController::class, 'templateStore'])->name('sms-template-store');

	Route::get('sms-template/edit/{id?}', [SmsController::class, 'templateEdit'])->name('sms-template-edit')->middleware(['check-permission']);

	Route::get('sms-template/show/{id?}', [SmsController::class, 'templateShow'])->name('sms-template-show')->middleware(['check-permission']);
	Route::put('sms-template/update/{id}', [SmsController::class, 'templateUpdate'])->name('sms-template-update');
	Route::delete('sms-template/delete/{id?}', [SmsController::class, 'templateDelete'])->name('sms-template-delete')->middleware(['check-permission']);
	// SMS template routes end

	// Send SMS routes start
	Route::get('send-sms', [smsController::class, 'sendSms'])->name('send-sms')->middleware(['check-permission']);
	Route::post('send-sms-process', [smsController::class, 'sendSmsPro'])->name('send-sms-pro');
	Route::get('send-sms-list', [smsController::class, 'sendSmsList'])->name('send-sms-list')->middleware(['check-permission']);
	Route::get('send-bulk-sms', [smsController::class, 'sendBulkSms'])->name('send-bulk-sms')->middleware(['check-permission']);
	Route::post('send-bulk-sms-process', [smsController::class, 'sendBulkSmsPro'])->name('send-bulk-sms-pro');
	Route::get('send-sms/show/{id?}', [SmsController::class, 'getSmsSendById'])->name('send-sms-show')->middleware(['check-permission']);

	// Send SMS routes end

	// Task routes start
	Route::get('task-list', [TaskController::class, 'getTaskList'])->name('task-list')->middleware(['check-permission']);
	Route::get('add-task', [TaskController::class, 'addTask'])->name('add-task')->middleware(['check-permission']);
	Route::post('add-task-pro', [TaskController::class, 'addTaskPro'])->name('add-task-pro');
	Route::put('task-status-change/{id}', [TaskController::class, 'changeStatus'])->name('task-status-change');
	Route::delete('delete-task/{id?}', [TaskController::class, 'delete'])->name('delete-task')->middleware(['check-permission']);

	// Task routes end


	// Product routes start
	Route::get('product-list', [ProductController::class, 'productList'])->name('product-list')->middleware(['check-permission']);
	Route::get('add-product', [ProductController::class, 'productCreate'])->name('add-product')->middleware(['check-permission']);
	Route::post('add-product-pro', [ProductController::class, 'productStore'])->name('add-product-pro');
	Route::delete('product-delete/{id?}', [ProductController::class, 'productDelete'])->name('product-delete')->middleware(['check-permission']);
	Route::get('product-show/{id?}', [ProductController::class, 'productShow'])->name('product-show')->middleware(['check-permission']);
	Route::get('product-edit/{id?}', [ProductController::class, 'productEdit'])->name('product-edit')->middleware(['check-permission']);
	Route::put('product-update-pro/{id}', [ProductController::class, 'productUpdate'])->name('product-update-pro');
	Route::post('add-product-feature', [ProductController::class, 'productFeatureStore'])->name('add-product-feature');
	Route::delete('/product-feature/{id?}', [ProductController::class, 'destroy'])->name('product-feature-destroy')->middleware(['check-permission']);
	Route::put('/product-feature-update/{id}', [ProductController::class, 'productFeatureUpdate'])->name('product-feature-update');
	Route::post('product-features-show', [ProductController::class, 'product_features_show'])->name('product.features.show');
	

	// Product routes end

    // Product Specification routes start
	Route::get('/product-specification', [ProductSpecificationController::class, 'index'])->name('product-specification-index')->middleware(['check-permission']);
    //Route::get('/product-specification/create', [ProductSpecificationController::class, 'init'])->name('product-specification-create')->middleware(['check-permission']);
	Route::get('/product-specification/create/{leadid?}', [ProductSpecificationController::class, 'init'])->name('product-specification-create')->middleware(['check-permission']);
   
	Route::get('/product-specification/init', [ProductSpecificationController::class, 'init'])->name('product-specification-init')->middleware(['check-permission']);
    Route::get('/product-specification/init-store', [ProductSpecificationController::class, 'init_store'])->name('product-specification-init-store');

    Route::post('/product-specification', [ProductSpecificationController::class, 'store'])->name('product-specification-store');
    Route::get('/product-specification/{id}', [ProductSpecificationController::class, 'show'])->name('product-specification-show')->middleware(['check-permission']);
    Route::get('/product-specification/{id}/edit', [ProductSpecificationController::class, 'edit'])->name('product-specification-edit')->middleware(['check-permission']);
    Route::put('/product-specification/{id}', [ProductSpecificationController::class, 'update'])->name('product-specification-update');
    Route::delete('/product-specification/{id}', [ProductSpecificationController::class, 'destroy'])->name('product-specification-destroy')->middleware(['check-permission']);
	Route::post('/product-specification/search', [ProductSpecificationController::class, 'search'])->name('product-specification-search');
	Route::put('/product-specification/update-specification-file/{id}', [ProductSpecificationController::class, 'updateSpecificationFile'])->name('update-specification-file');
	Route::get('/product-specification/get-spec-details/{id}', [ProductSpecificationController::class, 'getSpecDetails']);




	// Country routes start
	Route::get('country-list', [countryController::class, 'countryList'])->name('country-list');
	Route::get('add-country', [countryController::class, 'countryCreate'])->name('add-country');
	Route::post('add-country-pro', [countryController::class, 'countryStore'])->name('add-country-pro');
	Route::delete('country-delete/{id?}', [countryController::class, 'countryDelete'])->name('country-delete');

	// Country routes end

	// Currency routes start
	Route::get('currency-list', [CurrencyController::class, 'currencyList'])->name('currency-list');
	Route::get('add-currency', [CurrencyController::class, 'currencyCreate'])->name('add-currency');
	Route::post('add-currency-pro', [CurrencyController::class, 'currencyStore'])->name('add-currency-pro');
	Route::delete('currency-delete/{id?}', [CurrencyController::class, 'currencyDelete'])->name('currency-delete');
	// Currency routes end

	// Proposal routes start
	Route::get('proposal-list', [ProposalController::class, 'proposalList'])->name('proposal-list')->middleware(['check-permission']);
	Route::get('add-proposal', [ProposalController::class, 'addProposal'])->name('add-proposal')->middleware(['check-permission']);
	Route::post('add-proposal', [ProposalController::class, 'saveProposal'])->name('store-proposal');
	Route::delete('delete-proposal/{id?}', [ProposalController::class, 'delete_proposal'])->name('delete-proposal')->middleware(['check-permission']);
	Route::get('/proposal/{id?}', [ProposalController::class, 'show'])->name('proposal-show')->middleware(['check-permission']);
	Route::get('/proposal/{id?}/edit', [ProposalController::class, 'edit'])->name('proposal-edit')->middleware(['check-permission']);
	Route::put('/proposal/{id?}', [ProposalController::class, 'update'])->name('proposal-update');
	


	// Proposal routes end

	// Log
	Route::get('log-list', [LogController::class, 'getLogList'])->name('log-list')->middleware(['check-permission']);

	// Customer routes start
	Route::get('customers', [CustomerController::class, 'index'])->name('customers')->middleware(['check-permission']);
	Route::get('add-customer/{leadid?}', [CustomerController::class, 'add_customer'])->name('add-customer')->middleware(['check-permission']);
	Route::post('add-customer', [CustomerController::class, 'save_customer'])->name('post-add-customer');
	Route::post('customer-search', [CustomerController::class, 'search'])->name('customer-search');
	
	// blogger category routes
	Route::get('blog-category-list', [BloggerCategoryController::class, 'index'])->name('blogger-category-list')->middleware(['check-permission']);
	Route::get('blog-category/create', [BloggerCategoryController::class, 'create'])->name('blogger-category-create')->middleware(['check-permission']);
	Route::post('blogger-category', [BloggerCategoryController::class, 'store'])->name('blogger-category-store');
	Route::get('blog-category/{id?}', [BloggerCategoryController::class, 'show'])->name('blogger-category-show')->middleware(['check-permission']);
	Route::get('blog-category/{id?}/edit', [BloggerCategoryController::class, 'edit'])->name('blogger-category-edit')->middleware(['check-permission']);
	Route::put('blogger-category/{id?}', [BloggerCategoryController::class, 'update'])->name('blogger-category-update');
	Route::post('blogger-category/search', [BloggerCategoryController::class, 'search'])->name('blogger-category-search');
	Route::delete('blogger-category/{id?}', [BloggerCategoryController::class, 'destroy'])->name('blogger-category-destroy')->middleware(['check-permission']);
	Route::put('blogger-category/{id}/update-blogger-category-image', [BloggerCategoryController::class, 'updatebloggercategoryImage'])->name('update-blogger-category-image');

	Route::get('blog-list', [BlogController::class, 'index'])->name('blog-list')->middleware(['check-permission']);
	Route::get('blog/create', [BlogController::class, 'create'])->name('create-blog')->middleware(['check-permission']);
	Route::post('blog-create', [BlogController::class, 'store'])->name('blog-store');
	Route::get('blog/{id?}', [BlogController::class, 'show'])->name('blog-show')->middleware(['check-permission']);
	Route::get('blog/{id?}/edit', [BlogController::class, 'edit'])->name('blog-edit')->middleware(['check-permission']);
	Route::put('blog-update/{id?}', [BlogController::class, 'update'])->name('blog-update');
	Route::post('blog/search', [BlogController::class, 'search'])->name('blog-search');
	Route::delete('blog-delete/{id?}', [BlogController::class, 'destroy'])->name('blog-delete')->middleware(['check-permission']);
	Route::put('blog/{id}/update-blog-image', [BlogController::class, 'update_blog_image'])->name('update-blog-image');

    //notification routes
	Route::get('/notification', [NotificationController::class, 'index'])->name('notification-index')->middleware(['check-permission']);
	Route::get('/notification/create', [NotificationController::class, 'create'])->name('notification-create')->middleware(['check-permission']);
	Route::post('/notification', [NotificationController::class, 'store'])->name('notification-store');
	Route::get('/notification/{id?}', [NotificationController::class, 'show'])->name('notification-show')->middleware(['check-permission']); 
	Route::get('/notification/{id?}/edit', [NotificationController::class, 'edit'])->name('notification-edit')->middleware(['check-permission']);
	Route::put('/notification/{id}', [NotificationController::class, 'update'])->name('notification-update');
	Route::delete('/notification/{id?}', [NotificationController::class, 'destroy'])->name('notification-destroy');
	Route::post('/notification/search', [NotificationController::class, 'search'])->name('notification-search');
	Route::post('/notification/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notification-markAsRead');
	Route::get('/approval-panel', [NotificationController::class, 'approvalPanel'])->name('approval-panel')->middleware(['check-permission']);
    Route::post('/notification/{id?}/invoice-approve', [NotificationController::class, 'approveInvoice'])->name('invoice-approve');

	Route::get('feature-list', [FormFeatureController::class, 'formFeatureList'])->name('feature-list');
	Route::get('feature-create', [FormFeatureController::class, 'formFeatureCreate'])->name('feature-create');
	Route::post('feature-create-pro', [FormFeatureController::class, 'formFeatureStore'])->name('feature-create-pro');
	Route::delete('feature-delete/{id?}', [FormFeatureController::class, 'formFeatureDelete'])->name('feature-delete');
	Route::get('feature-show/{id?}', [FormFeatureController::class, 'formFeatureShow'])->name('feature-show');
	Route::get('feature-edit/{id?}', [FormFeatureController::class, 'formFeatureEdit'])->name('feature-edit');
	Route::put('feature-update-pro/{id}', [FormFeatureController::class, 'formFeatureUpdate'])->name('feature-update-pro');
	Route::get('get-help-content/{route}', [FormFeatureController::class, 'getDescription'])->name('get-help-content');


});