<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Hole Booking
    Route::delete('hole-bookings/destroy', 'HoleBookingController@massDestroy')->name('hole-bookings.massDestroy');
    Route::post('hole-bookings/search', 'HoleBookingController@search')->name('hole-bookings.search');
    Route::resource('hole-bookings', 'HoleBookingController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // New Booking
    Route::delete('new-bookings/destroy', 'NewBookingController@massDestroy')->name('new-bookings.massDestroy');
    Route::resource('new-bookings', 'NewBookingController');

    // Booing Date Time
    Route::delete('booing-date-times/destroy', 'BooingDateTimeController@massDestroy')->name('booing-date-times.massDestroy');
    Route::resource('booing-date-times', 'BooingDateTimeController');

    // Booking Payment
    Route::delete('booking-payments/destroy', 'BookingPaymentController@massDestroy')->name('booking-payments.massDestroy');
    Route::resource('booking-payments', 'BookingPaymentController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
