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
    Route::get('reports/data', 'HomeController@getData')->name('reports.data');

    // Route::get('admin/home/getData', 'HomeController@getData')->name('admin.home.getData');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');


    Route::get('courses','CourseController@index')->name('course.index');;

    
Route::resource('students', 'StudentController');
Route::post('students/{id}/restore', 'StudentController@restore')->name('students.restore');
Route::delete('students/{id}/force-delete', 'StudentController@forceDelete')->name('students.forceDelete');
Route::post('admin/students/store', [StudentController::class, 'store'])->name('admin.students.store');
Route::delete('fee-payments/{feePayment}', [FeePaymentController::class, 'destroy'])->name('fee-payments.destroy');
Route::resource('admin/payments', FeePaymentController::class);

//course and stream

    Route::resource('courses', CourseController::class);
    Route::resource('streams', StreamController::class);
    // Route::get('streams/{course_id}', [StreamController::class, 'getStreamsByCourse']);
  //  Route::post('seminars/get-streams', [SeminarController::class,'getStreamsForCourses'])->name('getStreamsForCourses');
    Route::resource('seminars', SeminarController::class);
    Route::post('seminars/get-streams', 'SeminarController@getStreamsForCourses')->name('getStreamsForCourses');
    Route::post('/save-attendance', 'SeminarController@saveAttendance')->name('save.attendance');
    Route::get('/get-students/attendance/{id}', 'SeminarController@getStreamAndCourseForSeminar')->name('get.student.attendance');
    // Cnacellations 

    Route::get('cancellations', 'CancellationController@index')->name('cancellations.index');
    Route::get('cancellations/data', 'CancellationController@getData')->name('cancellations.data');
    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Hole Booking
    Route::delete('hall-bookings/destroy', 'HoleBookingController@massDestroy')->name('hole-bookings.massDestroy');
    Route::post('hall-bookings/search', 'HoleBookingController@search')->name('hall-bookings.search');
    Route::resource('hall-bookings', 'HoleBookingController');

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


