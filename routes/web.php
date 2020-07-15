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
	Route::post('uploads/custom_logo/{request_id}/{request_type}',array('uses'=>'SettingsController@uploadCustomLogo'));
	Route::post('fetch/custom_logo/{request_id}/{request_type}',array('uses'=>'SettingsController@getCustomLogo'));
	Route::post('delete/custom_logo/{request_id}/{request_type}',array('uses'=>'SettingsController@deleteCustomLogo'));
	Route::post('update/site_settings/{request_id}',array('uses'=>'SettingsController@update_custom_site_settings'));
	//EMAIL TEMPLATE 
	Route::get('emails',array('uses'=>'EmailController@index'));
	Route::get('email/edit/{template_id}',array('uses'=>'EmailController@email_template_edit'));
	Route::post('email/update',array('uses'=>'EmailController@email_template_update'));
	

	Route::post('uploads/custom_header/{request_id}',array('uses'=>'SettingsController@uploadCustomHeader'));
	Route::post('fetch/custom_header/{request_id}',array('uses'=>'SettingsController@getCustomHeader'));
	Route::post('delete/custom_header/{request_id}',array('uses'=>'SettingsController@deleteCustomHeader'));
	
	Route::post('export_users_customers/{id}',array('as'=>'ajax.pagination','uses'=>'UsersController@exportListingCustomers'));
	Route::post('export_users',array('as'=>'ajax.pagination','uses'=>'UsersController@exportUsers'));
	
	
	
	//Payments
	Route::get('payments',array('uses'=>'PaymentsController@payments'));
	Route::get('customer-payments',array('uses'=>'PaymentsController@customer_payments'));
	Route::get('withdrawls',array('uses'=>'PaymentsController@withdrawls'));
	Route::post('payment/edit/{request_id}', 'PaymentsController@payment_edit'); //Edit User
	
	// customers
	Route::get('customers',array('uses'=>'CustomersController@customers'));
	Route::post('customer/edit/{request_id}', 'CustomersController@customer_edit'); //Edit User
	
	//Dashboard
	Route::get('dashboard',array('uses'=>'DashboardController@index'));
	
	//certificates
	Route::get('certificates',array('uses'=>'CertificateController@certificates'));
	Route::get('customer-certificate',array('uses'=>'CertificateController@customer_certificate'));


	//referrals
	Route::get('referrals',array('uses'=>'ReferralController@referrals'));
	
	
	//Requests
	Route::get('edit-requests',array('uses'=>'RequestsController@edit_request'));
	Route::get('requests',array('uses'=>'RequestsController@requests'));
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