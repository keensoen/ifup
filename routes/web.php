<?php


Auth::routes();

Route::get('/', 'LandingController@index')->name('index');

Route::get('ussd', function(){
    $baseurl = 'https://smartsmssolutions.com/api/ussd.php?';
    $ussdArray = array (
    'ussd'=> '',
    'simserver_token' => 'SIMSERVER_TOKEN_HERE',
    'token' =>'TOKEN_HERE'
    );

    $params = http_build_query($ussdArray);
    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_URL,$baseurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

    $response = curl_exec($ch);

    curl_close($ch);

    return $response; // response code

});

Route::get('dashboard', 'HomeController@index')->name('home');

//Salutation routes
Route::get('salutations', 'SalutationController@index')->name('salutes');
Route::post('salutations', 'SalutationController@store')->name('salute.store');
Route::get('salutations/{id}/edit', 'SalutationController@edit')->name('salute.edit');
Route::post('salutations/{id}/edit', 'SalutationController@update')->name('salute.update');
Route::post('salutations/{id}', 'SalutationController@destroy')->name('salute.destroy');

//Service Type routes
Route::get('service_types', 'ServiceInterestController@index')->name('servicetype');
Route::post('service_types', 'ServiceInterestController@store')->name('servicetype.store');
Route::get('service_types/{id}/edit', 'ServiceInterestController@edit')->name('servicetype.edit');
Route::post('service_types/{id}/edit', 'ServiceInterestController@update')->name('servicetype.update');
Route::post('service_types/{id}', 'ServiceInterestController@destroy')->name('servicetype.destroy');

//Organization routes
Route::get('organizations', 'OrganizationController@index')->name('organization');
Route::post('organizations', 'OrganizationController@store')->name('organization.store');
Route::get('organizations/{id}/edit', 'OrganizationController@edit')->name('organization.edit');
Route::post('organizations/{id}/edit', 'OrganizationController@update')->name('organization.update');
Route::post('organizations/{id}', 'OrganizationController@destroy')->name('organization.destroy');

//SMS Gateway routes
Route::get('gateways', 'SmsGatewayController@index')->name('gateway');
Route::post('gateways', 'SmsGatewayController@store')->name('gateway.store');
Route::get('gateways/{id}/edit', 'SmsGatewayController@edit')->name('gateway.edit');
Route::post('gateways/{id}/edit', 'SmsGatewayController@update')->name('gateway.update');
Route::post('gateways/{id}', 'SmsGatewayController@destroy')->name('gateway.destroy');

//User routes
Route::get('users', 'UserController@index')->name('user');
Route::post('users', 'UserController@store')->name('user.store');
Route::get('users/{id}/edit', 'UserController@edit')->name('user.edit');
Route::post('users/{id}/edit', 'UserController@update')->name('user.update');
Route::post('users/{id}', 'UserController@destroy')->name('user.destroy');

//Member route
Route::resource('comrades', 'MemberController');
Route::get('comrades/{q?}', 'MemberController@index')->name('member_search');
Route::post('restore-member/{slug}', 'MemberController@restoreMember')->name('m.restore');
Route::get('visit-feedback', 'MemberController@postVisitFeedback')->name('visit_feedback');
Route::post('import', 'MemberController@import')->name('import');
Route::get('heat-map', 'MemberController@heatMap')->name('heat.map');
Route::get('memberJson', 'MemberController@heatMapJson')->name('heatJson');

//Service Type routes
Route::get('memberGroup', 'MemberGroupController@index')->name('memberGroup');
Route::post('memberGroup', 'MemberGroupController@store')->name('memberGroup.store');
Route::get('memberGroup/{id}/edit', 'MemberGroupController@edit')->name('memberGroup.edit');
Route::post('memberGroup/{id}/edit', 'MemberGroupController@update')->name('memberGroup.update');
Route::post('memberGroup/{id}', 'MemberGroupController@destroy')->name('memberGroup.destroy');

//Prayer Request
Route::get('prayer_requests', 'PrayerRequestController@index')->name('prayer_request');
Route::get('prayer_requests/{id}', 'PrayerRequestController@clearPrayer')->name('pcleared');

//Comment
Route::get('comments', 'MemberCommentController@index')->name('comment');
Route::get('attendances', 'AttendanceController@index')->name('attendance');

//SMS Templates routes
Route::resource('templates', 'SmsTemplateController');

Route::get('send_sms', 'SmsLogController@index')->name('send_sms');
Route::post('send_sms', 'SmsLogController@sendSMS')->name('sendSMS');
Route::prefix('sms-report')->group(function(){
    Route::get('sent', 'SmsLogController@sentSMS')->name('sent_sms');
    Route::get('failed', 'SmsLogController@failedSMS')->name('failed_sms');
    Route::get('external', 'SmsLogController@externalSMS')->name('external_sms');
    Route::get('resend', 'SmsLogController@resendSMS')->name('resend_sms');
});

//Report routes
Route::prefix('members')->group(function() {
    Route::get('birthdays', 'ReportsController@birthReport')->name('breports');
    Route::get('new-residents', 'ReportsController@newResident')->name('new_resident');
    Route::get('non-baptized', 'ReportsController@notBaptized')->name('nbaptized');
    Route::get('serviceType', 'ReportsController@serviceType')->name('service_type');
    Route::get('contacts', 'ReportsController@memberContact')->name('contact');
    Route::get('like-workforce', 'ReportsController@workforce')->name('likeWorkforce');
    Route::get('like-membership', 'ReportsController@membership')->name('likeMembership');
    Route::get('like-visited', 'ReportsController@likeVisit')->name('likeVisited');
    Route::get('archived', 'MemberController@retrievArchived')->name('archived');
});
Route::prefix('analysis')->group(function() {
    Route::get('prayers', 'ReportsController@prayerAnalysis')->name('panalysis');
    Route::get('feedback', 'ReportsController@feedbackAnalysis')->name('fanalysis');
});

Route::prefix('attendance')->group(function() {
    Route::get('present', 'ReportsController@presentMember')->name('present');
    Route::get('absent', 'ReportsController@absentMember')->name('absent');
});

Route::prefix('miscellaneous')->group(function() {
    Route::get('present', 'ReportsController@presentMember')->name('present');
    Route::get('prayer-room', 'MiscellaneousController@prayerRoom')->name('prayer_room');
});