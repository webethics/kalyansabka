<?php

Route::get('/', 'User\UsersController@landing_page');


/* Route::redirect('/login', '/login'); */

Auth::routes(['login' => true]);
//Route::redirect('/home', '/admin');
Auth::routes(['register' => true]);


Route::group(['prefix' => '','as' => 'user.' ,'namespace' => 'User','middleware' => ['auth']], function () {
	
	
	
    //OTP 
    Route::get('send-otp', 'OtpController@ShowOtpForm');
    Route::post('send_otp', 'OtpController@SendOtp');

    //ROLE 
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

 	
	// USRS ROUTES
	Route::get('users',array('as'=>'ajax.pagination','uses'=>'UsersController@ajaxPagination'));
	Route::post('users',array('as'=>'ajax.pagination','uses'=>'UsersController@ajaxPagination'));
	
	
	Route::post('user/enable-disable',array('uses'=>'UsersController@enableDisableUser'));
	Route::post('user/delete_user/{id}', 'UsersController@delete_user')->name('users.delete');
	
	
	Route::post('user/edit/{request_id}', 'UsersController@edit'); //Edit User
	Route::post('update-profile/{user_id}', 'UsersController@profileUpdate');//UPDATE USER
	Route::post('update-basic-profile/{user_id}', 'UsersController@updateBasicProfile');//UPDATE Basic USER
	Route::post('update-bank-details/{user_id}', 'UsersController@updateBankDetails');//UPDATE USER
	Route::post('update-nominee-details/{user_id}', 'UsersController@updateNomineeDetails');//UPDATE USER
	Route::post('calculate-upgrade-amount/{user_id}','UsersController@calculateUpgradeAmount'); /*cal upgrade amount*/
	Route::post('upgrade_plan_request/{user_id}','UsersController@upgradePlanRequest'); /*upgrade plan request */
	
	Route::post('user/roleDropdown', 'UsersController@roleDropdown');
	
	Route::get('account', 'UsersController@account');
	
	Route::get('logout', 'UsersController@logout');
	
	Route::post('reset-password/{user_id}', 'UsersController@passwordUpdate');
	//Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
	
	
	
	// Global Setting 
	Route::get('settings',array('uses'=>'SettingsController@index'));
	
	Route::get('site-settings',array('uses'=>'SettingsController@site_settings'));
	Route::post('update/email/{request_id}',array('uses'=>'SettingsController@update_email_settings'));
	Route::post('update/site/{request_id}',array('uses'=>'SettingsController@update_site_settings'));
	/*logo upload*/
	Route::post('uploads/logo/{request_id}',array('uses'=>'SettingsController@uploadLogo'));
	Route::post('fetch/logo/{request_id}',array('uses'=>'SettingsController@getLogo'));
	Route::post('delete/logo/{request_id}',array('uses'=>'SettingsController@deleteLogo'));
	// Custom  Setting 
	Route::post('uploads/documents/{request_id}/{request_type}',array('uses'=>'SettingsController@uploadCustomLogo'));
	Route::post('fetch/custom_logo/{request_id}/{request_type}',array('uses'=>'SettingsController@getCustomLogo'));
	Route::post('delete/custom_logo/{request_id}/{request_type}',array('uses'=>'SettingsController@deleteCustomLogo'));
	Route::post('update/update_documents/{request_id}',array('uses'=>'SettingsController@update_user_documents'));
	//EMAIL TEMPLATE 
	Route::get('emails',array('uses'=>'EmailController@index'));
	Route::get('email/edit/{template_id}',array('uses'=>'EmailController@email_template_edit'));
	Route::post('email/update',array('uses'=>'EmailController@email_template_update'));
	

	Route::post('uploads/custom_header/{request_id}',array('uses'=>'SettingsController@uploadCustomHeader'));
	Route::post('fetch/custom_header/{request_id}',array('uses'=>'SettingsController@getCustomHeader'));
	Route::post('delete/custom_header/{request_id}',array('uses'=>'SettingsController@deleteCustomHeader'));
	
	Route::post('export_users_customers/{id}',array('as'=>'ajax.pagination','uses'=>'UsersController@exportListingCustomers'));
	Route::post('export_users',array('as'=>'ajax.pagination','uses'=>'UsersController@exportUsers'));
	
	Route::post('confirmModal', 'CommonController@confirmModal');
	
	//Payments
	Route::get('payments',array('uses'=>'PaymentsController@payments'));
	Route::get('customer-payments',array('uses'=>'PaymentsController@customer_payments'));
	Route::get('withdrawls',array('uses'=>'PaymentsController@withdrawls'));
	Route::post('payment/edit/{request_id}', 'PaymentsController@payment_edit'); //Edit User
	
	
	
	
	// customers
	Route::get('customers',array('uses'=>'CustomersController@customers'));
	Route::post('customers',array('uses'=>'CustomersController@customers'));
	Route::post('update-customer/{request_id}', 'CustomersController@update_customer'); //Edit User
	Route::post('customer/edit/{request_id}', 'CustomersController@customer_edit'); //Edit User
	Route::get('customer/create/',array('uses'=>'CustomersController@customer_create')); //Edit User
	Route::post('create-new-customer', 'CustomersController@customer_create_new'); //Edit User
	Route::post('customer/delete_customer/{request_id}',array('uses'=>'CustomersController@customer_delete')); //Edit User
	Route::post('customer/mark_as_district_head/{request_id}',array('uses'=>'CustomersController@mark_as_district_head')); //Edit User
	Route::post('customer/mark_as_state_head/{request_id}',array('uses'=>'CustomersController@mark_as_state_head')); //Edit User
	Route::post('export_customers',array('uses'=>'CustomersController@export_customers')); //Edit User
	Route::get('download-certificate/{request_id}',array('uses'=>'CustomersController@downloadCertificate')); //Edit User
	Route::get('manage-customer/{id}', 'CustomersController@manageCustomer');
	Route::post('customer/view/{request_id}', 'CustomersController@customer_view'); //Edit User
	//Dashboard
	Route::get('dashboard',array('uses'=>'DashboardController@index'));
	
	//certificates
	Route::get('certificates',array('uses'=>'CertificateController@certificates'));
	Route::get('customer-certificate',array('uses'=>'CertificateController@customer_certificate'));
	Route::post('certificate/edit/{request_id}', 'CertificateController@certificate_request_edit'); //Edit Certificate request
	Route::post('update-certificate-request/{request_id}', 'CertificateController@update_certificate'); //Update certificate
	Route::post('export_certificate_customers',array('uses'=>'CertificateController@export_certificate_customers')); /*Export certificate Customer */

	

	//referrals
	Route::get('referrals',array('uses'=>'ReferralController@index'));
	
	
	//Requests
	Route::get('edit-requests',array('uses'=>'RequestsController@edit_request'));
	Route::get('requests',array('uses'=>'RequestsController@requests'));
	Route::post('request/view/{request_id}', 'RequestsController@request_view'); //view request
	Route::post('export_request_customers',array('uses'=>'RequestsController@export_request')); /*Export certificate Customer */
	/*Update Edit Request*/
	Route::post('request-update-profile/{request_id}','RequestsController@request_update');
	Route::get('download-user-document/{user_id}',array('uses'=>'RequestsController@download_document'));
	
	//roles
	Route::get('roles',array('uses'=>'RolesController@roles'));
	Route::post('roles/edit/{request_id}', 'RolesController@roles_edit'); //Edit request
	Route::get('role/create/',array('uses'=>'RolesController@role_create')); //Edit User
	Route::post('role/delete_role/{request_id}',array('uses'=>'RolesController@role_delete')); //Edit User
	Route::post('/create-role-permissions/',array('uses'=>'RolesController@role_permission_create')); //Edit User
	Route::post('/update-role-permissions/',array('uses'=>'RolesController@role_permission_update')); //Edit User
	
});

Route::post('user/cityDropdown', 'User\UsersController@cityDropdown');
Route::post('user/calculateAge', 'User\UsersController@calculateAge');
Route::post('user/verifiedAadhar', 'User\UsersController@verifiedAadhar');
	
	
Route::get('verify/account/{token}', 'User\UsersController@verifyAccount'); //VERIFY ACCOUNT


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::post('password/reset_new_user_password', 'Auth\ResetPasswordController@reset_new_user_password');

Route::group(['prefix' => '','as' => 'user.' ,'namespace' => 'User'], function () {
});

//Route::post('stripe/webhook', '\Laravel\Cashier\WebhookController@handleWebhook');
Route::post('stripe/webhook', '\App\Http\Controllers\WebhookController@handleWebhook');