<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\CompanyDataController;
use App\Http\Controllers\Auth\ModifyPasswordController;

Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

/**
 * Written and Developed By:
 *
 * @name    Sushant Poudel 
 * @website https://sushantp.com.np 
 * @email   sushantpaudel@gmail.com 
 * 
 * @return  JobInterviewTaskBySofution
 */

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::delete('/users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('/users', UsersController::class);

    // CRUD for Companies
    Route::delete('/companies/destroy', [CompanyController::class, 'massDestroy'])->name('companies.massDestroy');
    Route::resource('/companies', CompanyController::class);

    // CRUD for Company (Data)
    Route::delete('/company-data/destroy', [CompanyDataController::class, 'massDestroy'])->name('company.data.massDestroy');
    Route::resource('/company-data', CompanyDataController::class);

    // CRUD for Employees
    Route::delete('/employees/destroy', [EmployeeController::class, 'massDestroy'])->name('employees.massDestroy');
    Route::resource('/employees', EmployeeController::class);
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {

    // Modify password and profile
    if (file_exists(app_path('Http/Controllers/Auth/ModifyPasswordController.php'))) {
        Route::get('/password', [ModifyPasswordController::class, 'edit'])->name('password.edit');
        Route::post('/password', [ModifyPasswordController::class, 'update'])->name('password.update');
        Route::post('/profile', [ModifyPasswordController::class, 'updateProfile'])->name('password.updateProfile');
        Route::post('/profile/destroy', [ModifyPasswordController::class, 'destroy'])->name('password.destroyProfile');
    }
});
