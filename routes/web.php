<?php

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
Route::redirect('/', '/login', 301);

Route::get('/dashboard', 'HomeController@index')->name('home')->middleware(['checkActive','password.expired']);
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', "Auth\LoginController@authenticate");
Route::post('/logout', "Auth\LoginController@logout")->middleware(['auth'])->name('logout');
Route::get("/change-password", "Auth\ChangePasswordController@showChangePasswordForm")->middleware(['auth'])->name('password.change');
Route::post("/change-password", "Auth\ChangePasswordController@changePassword")->middleware(['auth']);

// Contract Template Route
Route::get("/contract_template/{template_path}/preview", "ContractTemplatePreviewController@preview")
->name('admin.contract_templates.preview');
Route::get("/ios/install", "AppDownloadController@showIOSDownloadView")->name("app_download.ios");
Route::get("/ios/install/dev", "AppDownloadController@showIOSDevDownloadView")->name("app_download.ios_dev");
Route::get('/contract/templates', 'ContractTemplatePreviewController@showTemplate')
->name('contracts.template')
->middleware(['role:contract_controller']);
// End Contract Template Route

Route::middleware(['auth', 'checkActive', 'password.expired'])->group(function (){

	Route::name('purchase_requests.')->group(function (){
		Route::get('/purchase_requests', 'PurchaseRequest\PurchaseRequestController@index')->name('index');
		Route::get('/purchase_requests/create', 'PurchaseRequest\PurchaseRequestController@create')->name('create');
		Route::get('/purchase_requests/{id}', 'PurchaseRequest\PurchaseRequestController@show')->name('show');
		Route::get('/purchase_requests/{id}/edit', 'PurchaseRequest\PurchaseRequestController@edit')->name('edit');
		Route::post('/purchase_requests', 'PurchaseRequest\PurchaseRequestController@store')->name('store');
		Route::put('/purchase_requests/{id}', 'PurchaseRequest\PurchaseRequestController@update')->name('update');
		Route::post('/purchase_requests/{id}/approve', 'PurchaseRequest\PurchaseRequestController@approve')->name('approve');
		Route::post('/purchase_requests/{id}/reject', 'PurchaseRequest\PurchaseRequestController@reject')->name('reject');
		Route::post('/purchase_requests/{id}/sendBack', 'PurchaseRequest\PurchaseRequestController@sendBack')->name('sendBack');
		Route::get('/purchase_requests/{id}/print', 'PurchaseRequest\PurchaseRequestController@print')->name('print');
		Route::post('purchase_requests/{id}/sendApproval', 'PurchaseRequest\PurchaseRequestController@applyApprovalWorkflow')->name('send_approval');
		Route::post('purchase_requests/{purchase_request_id}/media', 'PurchaseRequest\MediaController@store')->name('media.store');
		Route::delete('purchase_requests/{purchase_request_id}/media/{media}', 'PurchaseRequest\MediaController@destroy')->name('media.store');
	});

	Route::name('purchase_request_details.')->group(function (){
		Route::get('/purchase_request_details', 'PurchaseRequestDetails\PurchaseRequestDetailController@index')->name('index');
	});	
});

Route::namespace("Admin")->prefix('admin')->name("admin.")->middleware(['auth', 'checkActive', 'password.expired'])->group( function () {
	Route::get('/users', "UserController@index")->name('user.all')
	->middleware('permission:view-user');
	Route::get('/users/create', "UserController@create")->name('user.create')
	->middleware('permission:create-user');
	Route::get('/users/get_agents', "UserController@getAgents")->name('user.role.agent');
	Route::get('/users/{id}', 'UserController@show')->name('user.show');
	Route::get('/users/{id}/tokens', "UserTokenController@show")->name('user.token.show')
	->middleware('permission:view-user');
	Route::get('/users/{id}/edit', "UserController@edit")->name('user.edit')
	->middleware('permission:update-user');
	Route::get('/users/{id}/password/reset', "UserController@showPasswordForm")->name('user.password.show')
	->middleware('permission:update-user');
	Route::post('/users/{id}/password/reset', "UserController@resetPassword")->name('user.password.reset')
	->middleware('permission:update-user');
	Route::post('/users', "UserController@store")->name('user.store')
	->middleware('permission:create-user');
	Route::post('/users/{user}/account_setting', "UserController@updateAccountSetting")
	->name('user.account_setting.update')
	->middleware('permission:update-user');
	Route::put('/users/{id}/personal_information', "UserController@updatePersonalInformation")
	->name('user.personal_information.update')
	->middleware('permission:update-user');
	Route::put('/users/{id}/signature_image', "UserController@updateSignatureImage")
	->name('user.signature_image.update')
	->middleware('permission:update-user');
	Route::put('/users/{id}/approvable','UserController@updateApprovable')
	->name('user.approvable.update')
	->middleware('permission:update-user');		 

	Route::put('/users/{id}/role_and_permssion', "UserController@updateRoleAndPermission")
	->name('user.role_and_permission.update')
	->middleware('permission:update-user');

	Route::delete('/tokens/{id}', "UserTokenController@destroy")->name('user.token.delete')
	->middleware('permission:update-user');

	Route::middleware('role:administrator')->group( function () {
		Route::get('/roles', "RoleController@index")->name('role.all');
		Route::get('/roles/new', "RoleController@create")->name('role.new');
		Route::get('/roles/{id}/edit', "RoleController@edit")->name('role.edit');
		Route::get('/roles/{id}/remove', "RoleController@remove")->name('role.remove');	
		Route::post('/roles', "RoleController@store")->name('role.create');
		Route::put('/roles/{id}', "RoleController@update")->name('role.update');
		Route::delete('/roles/{id}', "RoleController@delete")->name('role.delete');
	});

	Route::get('/contract_requests', "ContractRequestController@index")
	->name('contract_request.all');	
	Route::get('/contract_requests/{id}', "ContractRequestController@show")
	->name('contract_request.show');
	Route::put('/contract_requests/{id}', "ContractRequestController@update")
	->name('contract_request.update');   
	Route::get('/contract_requests/{id}/view_payment_sample', 'ContractRequestController@showMortgage')
	->name('contract_request.view_payment_sample');

	// Unit Contract Request
	Route::get("/unit_contract_requests", "UnitContractRequestController@index")
	->name('unit_contract_requests.index');	
	Route::get("/unit_contract_requests/{id}", "UnitContractRequestController@show")
	->name('unit_contract_requests.show');
	Route::get("/unit_contract_requests/{id}/createContract", "UnitContractRequestController@showCreateContractForm")
	->name('unit_contract_requests.create_contract')
	->middleware('permission:create-contract');
	Route::get('/unit_contract_requests/{id}/print', "UnitContractRequestController@printRequest")
	->name('unit_contract_requests.print');

	// Unit Deposit Request
	Route::get("/unit_deposit_requests", "UnitDepositRequestController@index")
	->name('unit_deposit_requests.index')
	->middleware('permission:view-unit-deposit-request');
	Route::get("/unit_deposit_requests/{id}", "UnitDepositRequestController@show")
	->name('unit_deposit_requests.show')
	->middleware('permission:view-unit-deposit-request');
	Route::get("/unit_deposit_requests/{id}/updateReceivingAmount", "UnitDepositRequestController@showUpdateReceivingAmountForm")
	->name('unit_deposit_requests.update.receving_amount')
	->middleware('permission:view-unit-deposit-request');
	Route::post("/unit_deposit_requests/{id}/updateReceivingAmount", "UnitDepositRequestController@UpdateReceivingAmount")
	->middleware('permission:update-unit-deposit-request');
	Route::post('/unit_deposit_requests/{id}/cancel', 'UnitDepositRequestController@cancel')
	->name('unit_deposit_requests.cancel')
	->middleware('permission:cancel-unit-deposit-request');
	Route::post('/unit_deposit_requests/{id}/void', 'UnitDepositRequestController@void')
	->name('unit_deposit_requests.void')
	->middleware('permission:void-unit-deposit-request');
	Route::get("/unit_deposit_requests/{id}/getPayment", "UnitDepositRequestController@getPayment")->name('unit_deposit_requests.payment');

	// Unit Hold Request
	Route::get('/unit_hold_requests', 'UnitHoldRequestController@index')
	->name('unit_hold_requests.index')
	->middleware('permission:view-unit-hold-request');
	Route::get("/unit_hold_requests/{id}", "UnitHoldRequestController@show")
	->name('unit_hold_requests.show')
	->middleware('permission:view-unit-hold-request');

	// Contract Route
	Route::get('/contracts', "ContractController@index")
	->name('contracts.index')
	->middleware('permission:view-contract');

	Route::get('/contracts/export', 'ContractController@export')
	->name('contracts.export')
	->middleware('permission:view-contract');

	Route::get('/contracts/create', "CreateContractController@showCreateForm")
	->name('contracts.create')
	->middleware('permission:create-contract');

	Route::get('/contracts/{id}/edit', "EditContractController@showEditForm")
	->name('contracts.edit')
	->middleware('permission:update-contract');

	Route::get('/contracts/{id}/print', 'ContractPdfController@getContractPdfFile')
	->name('contracts.print')
	->middleware('permission:view-contract');

	Route::get('/contracts/{id}/upload', 'UploadContractController@showContractUploadForm')
	->name('contracts.upload')
	->middleware('permission:update-contract');
	Route::post('/contracts/{id}/upload', 'UploadContractController@uploadContractPDF')
	->middleware('permission:update-contract');;

	Route::post('/contracts/create', "CreateContractController@store")
	->middleware('permission:create-contract');

	Route::post('/contracts/{id}/cancel', "CancelContractController@processCancellationRequest")
	->middleware('permission:cancel-contract');
	Route::post('/contracts/{id}/void', "VoidContractController@processVoidRequest")
	->middleware('permission:void-contract');

	Route::put('/contracts/{id}', "EditContractController@update")
	->name('contracts.update')
	->middleware('permission:update-contract');
	// End Contract Route

	// Contract Attachment Route
	Route::delete('/contract_attachments/{id}', "ContractAttachmentController@delete")
	->name('contract_attachments.destroy');
	// Contract Attachment Route

	// Loan Route
	Route::post('/loan/amortization-schedule', "LoanController@getAmortizationSchedule")
	->name('loan.amortization-schedule');
	Route::get('/loan/payment_date', "LoanController@paymentDate");
	// End Loan

	// Banner
	Route::resource('banners', 'BannerController');
	// End Banner

	// Bank
	Route::resource('banks', 'BankController');
	// End Bank

	// Banner
	Route::resource('categories', 'CategoryController');   
	// End Banner

	// Banner
	Route::resource('posts', 'PostController');    
	// End Banner

	Route::resource('projects', 'ProjectController', ['parameters' => ['project' => 'id']]);
	Route::get('projects/{id}/delete', "ProjectController@showDeleteForm")->name('projects.delete');
	Route::get('projects/{id}/restore', "ProjectController@showRestoreForm")->name('projects.restore');
	Route::get('projects/{id}/unit_handovers', 'ProjectController@getUnitHandovers')->name('projects.unit_handovers.index');
	Route::get('projects/{id}/master_plan', "ProjectController@showMasterPlan")
	->name('projects.master_plan');


	Route::get('projects/{id}/unit_types', "ProjectController@getUnitTypes")->name('projects.units.index');
	Route::post('projects/{id}/restore', "ProjectController@restore");

	Route::get('projects/{project_id}/units', "ProjectUnitController@index")
	->name('projects.units.index');

	Route::get('projects/{project_id}/zones', 'ProjectZoneController@index')
	->name('projects.zones.store')
	->middleware('permission:view-zone');

	Route::get('projects/{project_id}/zones/create', 'ProjectZoneController@create')
	->name('projects.zones.create')
	->middleware('permission:create-zone');

	Route::post('projects/{project_id}/zones', 'ProjectZoneController@store')
	->name('projects.zones.store')
	->middleware('permission:create-zone');

	Route::get('projects/{project_id}/zones/{id}/edit', 'ProjectZoneController@edit')
	->name('projects.zones.edit')
	->middleware('permission:update-zone');

	Route::put('projects/{project_id}/zones/{id}', 'ProjectZoneController@update')
	->name('projects.zones.update')
	->middleware('permission:update-zone');		 

	Route::delete('projects/{id}/media', 'ProjectController@deleteMedia')->middleware('permission:update-project');

	// Zone controller
	Route::resource('zones','ZoneController');
	Route::get('zones/{zone_id}/units', 'ZoneUnitController@index')
	->name('zones.units.index')
	->middleware('permission:view-zone');
	Route::get('zones/{zone_id}/site_engineers', 'ZoneSiteEngineerController@index')
	->name('zones.site_engineers.index');

	// Company
	Route::resource('companies', 'CompanyController');
	Route::get('companies/{id}/delete', 'CompanyController@delete')->name('companies.delete');

	Route::resource('payment_options', 'PaymentOptionController');
	Route::get('payment_options/{id}/delete', "PaymentOptionController@showDeleteForm")->name('payment_options.delete');
	Route::get('payment_options/{id}/restore', "PaymentOptionController@showRestoreForm")->name('payment_options.restore');
	Route::post('payment_options/{id}/restore', "PaymentOptionController@restore");
	Route::get('payment_options/{id}', "PaymentOptionController@show");

	// Discount Promtion Route
	Route::resource('discount_promotions', 'DiscountPromotionController');
	Route::post('discount_promotions/{id}/discount_promotion_items', 'DiscountPromotionController@addItem');
	Route::delete('discount_promotions/{id}/discount_promotion_items/{item_id}', 'DiscountPromotionController@removeItem');

	Route::resource('unit_types', 'UnitTypeController');
	Route::get('unit_types/{id}/delete', "UnitTypeController@showDeleteForm")->name('unit_types.delete');
	Route::get('unit_types/{id}/restore', "UnitTypeController@showRestoreForm")->name('unit_types.restore');
	Route::post('unit_types/{id}/restore', "UnitTypeController@restore");	
	Route::get('unit_types/{id}/saleable', "UnitTypeController@showSetSaleableStatusForm")->name('unit_types.set_saleable_status');
	Route::post('unit_types/{id}/saleable', "UnitTypeController@SetSaleableStatus");	
	Route::get('unit_types/{id}/payment_option', "UnitTypeController@getPaymentOption");
	Route::get('unit_types/{id}/clone_payment_option',"UnitTypeController@getClonePaymentOptionForm")->name("unit_types.clone");
	Route::post('unit_types/{id}/clone_payment_option',"UnitTypeController@clone");
	Route::post('unit_types/{id}/addMedia', 'UnitTypeController@addMedia')->name('unit_types.add_media');
	Route::delete('unit_types/{id}/deleteMedia', 'UnitTypeController@deleteMedia')->name('unit_types.delete_media');

	// Unit Route
	Route::get('/units', "UnitController@index")
	->name("units.index")->middleware('permission:view-unit');
	Route::get('/units/new', "UnitController@create")
	->name("units.create")->middleware('permission:create-unit');
	Route::get('/units/import', "UnitController@showImportForm")
	->name("units.import")->middleware('permission:import-unit');
	Route::post('/units/import', "UnitController@import")->middleware('permission:import-unit');
	Route::get('/units/bulkStatusModify', 'UnitStatusModifyController@showForm')
	->name('units.bulk_status_modify')->middleware('permission:modify-status-unit');
	Route::post('/units/bulkStatusModify', 'UnitStatusModifyController@modifyStatus')
	->middleware('permission:modify-status-unit');
	Route::get('/units/import_template', "UnitController@getImportTemplate")
	->name("units.import_template")->middleware('permission:import-unit');
	Route::get('/units/export', "UnitController@showExportForm")
	->name("units.export")->middleware('permission:export-unit');
	Route::get('/units/saleReport', "UnitController@exportSaleReport")
	->name("units.report.sale")->middleware('permission:export-unit');

	Route::post('/units/export', "UnitController@export")->middleware('permission:export-unit');
	Route::get('/units/{id}/edit', "UnitController@edit")    
	->name("units.edit")->middleware('permission:update-unit');		
	Route::get('/units/{id}', "UnitController@show")
	->name("units.show")->middleware('permission:view-unit');
	Route::get('/units/{code}/code', "UnitController@getUnitByCode")
	->name("units.show_by_code")->middleware('permission:view-unit');
	Route::get('/units/{id}/actions', "UnitController@getActions")
	->name("units.get.actions")->middleware('permission:view-unit');
	Route::get('/units/{id}/activities', "UnitController@getActivities")
	->name("units.get.activities")->middleware('permission:view-unit');
	Route::get('/units/{id}/change_status', "UnitController@showChangeStatusForm")
	->name("units.status.change");

	Route::post('/units/{id}/change_status', "UnitController@changeStatus");
	Route::post('/units/{id}/addToZone', 'AddUnitToZoneController');

	Route::post('/units', "UnitController@store")
	->name('units.store')->middleware('permission:create-unit');
	Route::put('/units/{id}', "UnitController@update")
	->name('units.update')
	->middleware('permission:update-unit'); 
	Route::post('/units/{id}/updateSaleable', "UnitController@updateSaleableStatus")
	->name("units.saleable")->middleware('permission:update-unit');
	Route::post('/units/{id}/updateActive', "UnitController@updateActiveStatus")
	->name("units.saleable")->middleware('permission:update-unit');

	Route::get('units/{id}/constructionProcedures', 'UnitConstructionProcedureController@index')
	->name('units.construction_procedures.index');

	Route::get('units/{unit_id}/transactions', 'UnitTransactionController@index')
	->name('units.transactions.index');
	// End Unit Route

	// Unit Handover Route
	Route::get('units/{id}/unit_handovers/create', 'UnitHandoverController@create')->name('unit.unit_handovers.create');
	Route::get('/unit_handovers', 'UnitHandoverController@index')->name('unit_handovers.index');
	Route::post('/unit_handovers/store', 'UnitHandoverController@store')->name('unit_handovers.store');
	Route::get('/unit_handovers/{id}/show', 'UnitHandoverController@show')->name('unit_handovers.show');
	Route::get('/unit_handovers/{id}/edit', 'UnitHandoverController@edit')->name('unit_handovers.edit');
	Route::put('/unit_handovers/{id}/update', 'UnitHandoverController@update')->name('unit_handovers.update');
	Route::post('unit_handovers/{id}/send_approval', 'UnitHandoverController@applyApprovalWorkflow')->name('unit_handovers.send_approval');
	Route::post('/unit_handovers/{id}/approve', 'UnitHandoverController@approve')->name('unit_handovers.approve');
	Route::post('/unit_handovers/{id}/reject', 'UnitHandoverController@reject')->name('unit_handovers.reject');
	Route::post('/unit_handovers/{id}/sendBack', 'UnitHandoverController@sendBack')->name('unit_handovers.sendBack');

	Route::get('/unit_handovers/import', 'UnitHandoverController@showImportForm')
	->name('unit_handovers.import')->middleware('permission:import-unit-handover');
	Route::post('/unit_handovers/import', 'UnitHandoverController@import')
	->name('unit_handovers.import')->middleware('permission:import-unit-handover');
	Route::get('/unit_handovers/import_template', "UnitHandoverController@getImportTemplate")
	->name("unit_handovers.import_template")->middleware('permission:import-unit-handover');
	// End Unit Hanover Route

	// User member
	Route::get('/user/{id}/members', "UserController@getMembers")
	->name("user.get.members");
	// End User member

	// Unit Action Route
	Route::get('/unit_actions', "UnitActionController@index")
	->name('unit_actions.index');
	// End Unit Action Route

	// Sale Representative
	Route::resource('sale_representatives', 'SaleRepresentativeController');
	Route::get('sale_representatives/{id}/delete', "SaleRepresentativeController@showDeleteForm")->name('sale_representatives.delete');
	// End Sale Representative

	// Mobile App Version
	Route::resource('app_versions', 'AppVersionController');
	// End Mobile App Version

	// Miscellanous Route          	
	Route::get('/notifications', "NotificationController@showNotification")
	->name('notification.show');
	Route::get('/notifications/readAll', "NotificationController@markAllAsRead")
	->name('notification.mark.read.all');
	Route::post('/notifications/{id}/markAsRead', "NotificationController@markAsRead")
	->name('notification.mark.read');
	// End Miscellanous route

	//Site Engineer
	Route::resource('/site_engineers', "SiteEngineerController");
	Route::get('/site_engineers/create', "SiteEngineerController@create")->name('site_engineers.create')
	->middleware('permission:create-site-engineer');
	Route::get('/site_engineers/{id}/edit', "SiteEngineerController@edit")->name('site_engineers.edit')
	->middleware('permission:update-site-engineer');
	Route::get('/site_engineers/{id}', 'SiteEngineerController@show')->name('site_engineers.show');
	Route::put('/site_engineers/{id}/personal_information', "SiteEngineerController@updatePersonalInformation")
	->name('site_engineers.personal_information.update')
	->middleware('permission:update-site-engineer');
	Route::put('/site_engineers/{user}/account_setting', "SiteEngineerController@updateAccountSetting")
	->name('site_engineers.account_setting.update')
	->middleware('permission:update-site-engineer');
	Route::put('/site_engineers/{user}/managedZones', "SiteEngineerController@updateManagedZone")
	->name('site_engineers.managed_zones.update')
	->middleware('permission:update-site-engineer');
	Route::get('/site_engineers/{id}/password/reset', "SiteEngineerController@showPasswordForm")->name('site_engineers.password.show')
	->middleware('permission:reset-password-site-engineer');
	Route::post('/site_engineers/{id}/password/reset', "SiteEngineerController@resetPassword")->name('site_engineers.password.reset')
	->middleware('permission:reset-password-site-engineer');
	//End Engineer

	// Construction Procedure
	Route::resource('/construction_procedures', 'ConstructionProcedureController')->middleware('role:administrator');
});

// Route for admin prefix which need to access shared controller
Route::prefix('admin')->name("admin.")->middleware(['auth', 'checkActive', 'password.expired'])->group( function () {
	Route::get('/projects/{project_id}/getUnitsForMasterPlan', 'UnitMasterPlanController')
	->middleware('permission:view-unit');
});

// Route for Sale Team Leader and Agent
Route::namespace('SaleAgent')
->prefix('sale_agent')
->name('sale.')
->middleware(['auth', 'checkActive'])
->group( function() {

	Route::get('/projects', 'ProjectController@index')->name('projects.index');
	Route::get('/projects/{project_id}/unit_types', 'ProjectUnitTypeController@index')
	->name('projects.unit_types.index');
	Route::get('/projects/{id}/master_plan', 'ProjectController@showMasterPlan')
	->name('projects.master_plan.view');


	// Unit Type Route
	Route::get('/unit_types/{id}', 'UnitTypeController@show')->name('unit_types.show');
});

// Route for Sale Team Leader and Agent which need to access shared controller
Route::prefix('sale_agent')
->name('sale.')
->middleware(['auth', 'checkActive'])
->group( function() {

	Route::get('/projects/{project_id}/getUnitsForMasterPlan', 'UnitMasterPlanController');
});

// Route for Site Engineer Role
Route::namespace('SiteEngineer')
->prefix('site_engineer')
->name('site_engineer.')
->middleware(['auth', 'checkActive', 'role:site_engineer'])
->group( function() {

	// Home Route for Site Engineer Profile
	Route::get('home', 'HomeController@index')->name('home');

	Route::get('/zones/{id}/units', 'ZoneUnitController@index')->name('zones.units.index');
	Route::get('zones/{zone_id}/site_engineers', 'ZoneSiteEngineerController@index')
	->name('zones.site_engineers.index');

	Route::get('/zones/{zone_id}/unit_construction/{unit_id}', 'ZoneUnitConstructionController@show')
	->name('zones.unit_constructions.show');
});

Route::namespace('SiteManager')
->prefix('site_manager')
->name('site_manager.')
->middleware(['auth', 'checkActive', 'role:site_manager'])
->group( function() {

	// Home Route for Site manager Profile
	Route::get('projects', 'ProjectController@index')->name('projects.index');
	Route::get('/projects/{id}','ProjectController@show')->name('projects.show');


	// Project single master plan
	Route::get('/projects/{id}/master_plan', 'ProjectController@showMasterPlan')
	->name('projects.master_plan');
	Route::get('projects/{id}/unit_handovers', 'ProjectController@getUnitHandovers')->name('projects.unit_handovers.index');
	Route::get('projects/{id}/unit_types', "ProjectController@getUnitTypes")->name('projects.units.index');

	// Site Manager route to unit
	Route::get('projects/{project_id}/units', "ProjectUnitController@index")->name('projects.units.index');
	Route::get('projects/{project_id}/units/{unit_id}', 'ProjectUnitController@show')->name('projects.units.show');

	//Site manager add zone
	Route::post('/units/{id}/addToZone', 'AddUnitToZoneController');

	//Unit type for site manager
	Route::get('projects/{project_id}/unit_types/{unit_type_id}', 'ProjectUnitTypeController@show')->name('projects.unit_types.show');

	// Site manager create zone
	Route::get('projects/{project_id}/zones/create', 'ProjectZoneController@create')
	->name('projects.zones.create')
	->middleware('permission:create-zone');
	Route::post('projects/{project_id}/zones', 'ProjectZoneController@store')
	->name('projects.zones.store')
	->middleware('permission:create-zone');
	Route::get('projects/{project_id}/zones/{id}/edit', 'ProjectZoneController@edit')
	->name('projects.zones.edit')
	->middleware('permission:update-zone');
	Route::put('projects/{project_id}/zones/{id}', 'ProjectZoneController@update')
	->name('projects.zones.update')
	->middleware('permission:update-zone');

	Route::get('/unit_handovers', 'UnitHandoverController@index')->name('unit_handovers.index');
	Route::post('/unit_handovers/store', 'UnitHandoverController@store')->name('unit_handovers.store');
	Route::get('/unit_handovers/{id}/show', 'UnitHandoverController@show')->name('unit_handovers.show');
	Route::get('/unit_handovers/{id}/edit', 'UnitHandoverController@edit')->name('unit_handovers.edit');
	Route::put('/unit_handovers/{id}/update', 'UnitHandoverController@update')->name('unit_handovers.update');
	Route::post('unit_handovers/{id}/send_approval', 'UnitHandoverController@applyApprovalWorkflow')->name('unit_handovers.send_approval');
	Route::post('/unit_handovers/{id}/approve', 'UnitHandoverController@approve')->name('unit_handovers.approve');
	Route::post('/unit_handovers/{id}/reject', 'UnitHandoverController@reject')->name('unit_handovers.reject');
	Route::post('/unit_handovers/{id}/sendBack', 'UnitHandoverController@sendBack')->name('unit_handovers.sendBack');
	// Zone Unit Route
	Route::get('zones/{zone_id}/units', 'ZoneUnitController@index')
	->name('zones.units.index')
	->middleware('permission:view-zone');

	Route::post('zones/{zone_id}/units/associateUnitByCode', 'ZoneUnitController@associateUnitByCode');
	Route::delete('zones/{zone_id}/units/{unit_id}/removeZone', 'ZoneUnitController@removeUnitFromZone');
	// Zone Site Engineer Route
	Route::get('zones/{zone_id}/site_engineers', 'ZoneSiteEngineerController@index')
	->name('zones.site_engineers.index')
	->middleware('permission:view-site-engineer');

	//route for Site  engineer
	Route::get('site_engineers','SiteEngineerController@index')->name('site_engineers.index');
	Route::get('/site_engineers/create', "SiteEngineerController@create")->name('site_engineers.create')
	->middleware('permission:create-site-engineer');
	Route::post('/site_engineers/store',"SiteEngineerController@store")->name('site_engineers.store')
	->middleware('permission:create-site-engineer');
	Route::get('/site_engineers/{id}/edit', "SiteEngineerController@edit")->name('site_engineers.edit')
	->middleware('permission:update-site-engineer');
	Route::get('/site_engineers/{id}', 'SiteEngineerController@show')->name('site_engineers.show');
	Route::put('/site_engineers/{id}/personal_information', "SiteEngineerController@updatePersonalInformation")
	->name('site_engineers.personal_information.update')
	->middleware('permission:update-site-engineer');
	Route::put('/site_engineers/{user}/account_setting', "SiteEngineerController@updateAccountSetting")
	->name('site_engineers.account_setting.update')
	->middleware('permission:update-site-engineer');
	Route::put('/site_engineers/{user}/managedZones', "SiteEngineerController@updateManagedZone")
	->name('site_engineers.managed_zones.update')
	->middleware('permission:update-site-engineer');
	Route::get('/site_engineers/{id}/password/reset', "SiteEngineerController@showPasswordForm")->name('site_engineers.password.show')
	->middleware('permission:reset-password-site-engineer');
	Route::post('/site_engineers/{id}/password/reset', "SiteEngineerController@resetPassword")->name('site_engineers.password.reset')
	->middleware('permission:reset-password-site-engineer');

	Route::get('/unit_types/{id}/show', function () {abort(404);})->name('unit_types.show');
});

// route for sub_constructor
Route::namespace('SubConstructor')
  ->group( function() {
  	//route for sub_constructor
	Route::get('/sub_constructors', "SubConstructorController@index")->name('sub_constructors.index')
		->middleware('permission:view-sub-constructor');
	Route::get('/sub_constructors/create', "SubConstructorController@create")->name('sub_constructors.create')
		->middleware('permission:create-sub-constructor');
	Route::post('/sub_constructors/store', "SubConstructorController@store")->name('sub_constructors.store')
		->middleware('permission:create-sub-constructor');
	Route::get('/sub_constructors/{id}/edit', "SubConstructorController@edit")->name('sub_constructors.edit')
		->middleware('permission:update-sub-constructor');
	Route::put('/sub_constructors/{id}/personal_information', "SubConstructorController@updatePersonalInformation")
	 	->name('sub_constructors.personal_information.update')
	 	->middleware('permission:update-sub-constructor');
	
	//route for sub_constructor_contact
	Route::post('/sub_constructors/{id}/contacts', "SubConstructorContactController@store")
	 	->name('sub_constructors.contacts.store')
	 	->middleware('permission:update-sub-constructor');
	Route::get('/sub_constructors/{id}/contacts/{contact_id}/edit', "SubConstructorContactController@edit")
	 	->name('sub_constructors.contacts.edit')
	 	->middleware('permission:update-sub-constructor');
	Route::put('/sub_constructors/{id}/contacts/{contact_id}', "SubConstructorContactController@update")
		->name('sub_constructors.contacts.update')
		->middleware('permission:update-sub-constructor');
	Route::get('/sub_constructors/{id}/contacts/{contact_id}/delete', "SubConstructorContactController@delete")
		->name('sub_constructors.contacts.delete')
		->middleware('permission:update-sub-constructor');
	
	//route for sub_constructor_identity_document
	Route::post('/sub_constructors/{id}/identity_documents', "SubConstructorIdentityDocumentController@store")
      	->name('sub_constructors.identity_documents.store')
      	->middleware('permission:update-sub-constructor');
	Route::get('/sub_constructors/{id}/identity_documents/{identity_document_id}/edit', "SubConstructorIdentityDocumentController@edit")
		->name('sub_constructors.identity_documents.edit')
		->middleware('permission:update-sub-constructor')
		->middleware('permission:update-sub-constructor');
	Route::put('/sub_constructors/{id}/identity_documents/{identity_document_id}', "SubConstructorIdentityDocumentController@update")
		->name('sub_constructors.identity_documents.update')
		->middleware('permission:update-sub-constructor');
	Route::get('/sub_constructors/{id}/identity_documents/{identity_document_id}/delete', "SubConstructorIdentityDocumentController@delete")
		->name('sub_constructors.identity_documents.delete')
		->middleware('permission:update-sub-constructor');

	//route for sub_constructor_skill
	Route::put('/sub_constructors/{id}/skills', "SubConstructorSkillController@update")
      	->name('sub_constructors.skills.update')
      	->middleware('permission:update-sub-constructor');

     //route for assign unit to sub_constructor
     Route::get('/sub_constructors/{sub_constructor_id}/units', 'SubConstructorController@showAddUnitForm')
     ->name('sub_constructors.units.index')
     ->middleware('permission:update-sub-constructor');

     Route::post('/sub_constructors/{sub_constructor_id}/units', 'SubConstructorController@addUnit')
     	->middleware('permission:update-sub-constructor');

     Route::delete('/sub_constructors/{sub_constructor_id}/units/{unit_id}', 'SubConstructorController@removeUnit')
     	->middleware('permission:update-sub-constructor');
     
     
     
});

// Route for Site Manager which need to access shared controller
Route::prefix('site_manager')
->name('site_manager.')
->middleware(['auth', 'checkActive'])
->group( function() {

	Route::get('/projects/{project_id}/getUnitsForMasterPlan', 'UnitMasterPlanController');
});

//route for project coordina
Route::namespace('ProjectCoordinator')
 ->prefix('project_coordinator')
 ->name('project_coordinator.')
 ->middleware(['auth', 'checkActive', 'role:project_coordinator'])
 ->group( function() {
	Route::get('/projects', 'ProjectController@index')->name('projects.index');
	Route::get('/projects/{id}','ProjectController@show')->name('projects.show');

	// Project coordinator route to unit
	Route::get('projects/{project_id}/units', "ProjectUnitController@index")->name('projects.units.index');
	Route::get('projects/{project_id}/units/{unit_id}', 'ProjectUnitController@show')->name('projects.units.show');
	
	// Project single master plan
	Route::get('/projects/{id}/master_plan', 'ProjectController@showMasterPlan')
		->name('projects.master_plan');
	Route::get('/projects/{project_id}/getUnitsForMasterPlan', 'UnitMasterPlanController');
	Route::get('/projects/{id}/unit_types', "ProjectController@getUnitTypes")->name('projects.unit_types.index');
		
	//Unit type for project coordinator
	Route::get('projects/{project_id}/unit_types/{unit_type_id}', 'ProjectUnitTypeController@show')->name('projects.unit_types.show');
	Route::get('/unit_types/{id}/show','UnitTypeController@show')->name('unit_types.show');
	// Zone Unit Route
	Route::get('zones/{zone_id}/units', 'ZoneUnitController@index')
		->name('zones.units.index')
		->middleware('permission:view-zone');
	// Zone Site Engineer Route
	Route::get('zones/{zone_id}/site_engineers', 'ZoneSiteEngineerController@index')
		->name('zones.site_engineers.index')
		->middleware('permission:view-site-engineer');
});


//route for handover officer
Route::namespace('HandoverOfficer')
 ->prefix('handover_officer')
 ->name('handover_officer.')
 ->middleware(['auth', 'checkActive', 'role:handover_officer'])
 ->group( function() {
	Route::get('/projects', 'ProjectController@index')->name('projects.index');
	Route::get('/projects/{id}','ProjectController@show')->name('projects.show');

 // Project coordinator route to unit
	 Route::get('projects/{project_id}/units', "ProjectUnitController@index")->name('projects.units.index');
	 Route::get('projects/{project_id}/units/{unit_id}', 'ProjectUnitController@show')->name('projects.units.show');
	
	// // Project single master plan
	Route::get('/projects/{id}/master_plan', 'ProjectController@showMasterPlan')
		->name('projects.master_plan');
	Route::get('/projects/{project_id}/getUnitsForMasterPlan', 'UnitMasterPlanController');
	Route::get('/projects/{id}/unit_types', "ProjectController@getUnitTypes")->name('projects.unit_types.index');
		
	// //Unit type for project coordinator
	Route::get('projects/{project_id}/unit_types/{unit_type_id}', 'ProjectUnitTypeController@show')->name('projects.unit_types.show');
	Route::get('/unit_types/{id}/show','UnitTypeController@show')->name('unit_types.show');
	// // Zone Unit Route
	Route::get('zones/{zone_id}/units', 'ZoneUnitController@index')
		->name('zones.units.index')
		->middleware('permission:view-zone');
	// // Zone Site Engineer Route
	Route::get('zones/{zone_id}/site_engineers', 'ZoneSiteEngineerController@index')
		->name('zones.site_engineers.index')
		->middleware('permission:view-site-engineer');
		// Unit Handover Route
	Route::get('units/{id}/unit_handovers/create', 'UnitHandoverController@create')->name('unit.unit_handovers.create');
	Route::get('/unit_handovers', 'UnitHandoverController@index')->name('unit_handovers.index');
	Route::post('/unit_handovers/store', 'UnitHandoverController@store')->name('unit_handovers.store');
	Route::get('/unit_handovers/{id}/show', 'UnitHandoverController@show')->name('unit_handovers.show');
	Route::get('/unit_handovers/{id}/edit', 'UnitHandoverController@edit')->name('unit_handovers.edit');
	Route::put('/unit_handovers/{id}/update', 'UnitHandoverController@update')->name('unit_handovers.update');
	Route::post('unit_handovers/{id}/send_approval', 'UnitHandoverController@applyApprovalWorkflow')->name('unit_handovers.send_approval');
	Route::post('/unit_handovers/{id}/approve', 'UnitHandoverController@approve')->name('unit_handovers.approve');
	Route::post('/unit_handovers/{id}/reject', 'UnitHandoverController@reject')->name('unit_handovers.reject');
	Route::post('/unit_handovers/{id}/sendBack', 'UnitHandoverController@sendBack')->name('unit_handovers.sendBack');
	
});
