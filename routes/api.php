<?php

use App\Http\Controllers\Api\StudentController;

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api'], function () {
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('students.index');
        Route::post('/', [StudentController::class, 'store'])->name('students.store');
        Route::get('/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::put('/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::post('/{id}/restore', [StudentController::class, 'restore'])->name('students.restore');
        Route::delete('/{id}/force-delete', [StudentController::class, 'forceDelete'])->name('students.forceDelete');
    });
});
