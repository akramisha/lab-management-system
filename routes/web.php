<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (using UserController)
Route::get('/hello', [UserController::class, 'showRegistrationform'])->name('register.form');
Route::post('/hello', [UserController::class, 'storeRegister'])->name('register.store');
Route::get('/helo', [UserController::class, 'showLoginform'])->name('login.form');
Route::post('/helo', [UserController::class, 'login'])->name('login.process');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Appointment Routes (Used by Patient to book)
Route::resource('appointment', AppointmentController::class)->only(['create', 'store']);


/*
|--------------------------------------------------------------------------
| User-Specific Routes (Protected by manual session check in controllers)
|--------------------------------------------------------------------------
*/

// Admin Routes Group
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('users', [AdminController::class, 'showUsers'])->name('users');
    Route::get('employees', [AdminController::class, 'showEmployees'])->name('employees');

    Route::get('appointments/new', [AdminController::class, 'showNewAppointments'])->name('appointments.new');
    Route::get('appointments/approved', [AdminController::class, 'showAppointmentsApproved'])->name('appointments.approved');
    Route::get('appointments/rejected', [AdminController::class, 'showRejectedAppointments'])->name('appointments.rejected');
    Route::get('appointments/cancelled', [AdminController::class, 'showCancelledAppointments'])->name('appointments.cancelled');
    Route::get('appointments/sample-received', [AdminController::class, 'showAppointmentsSampleReceived'])->name('appointments.samples');
    Route::get('appointments/reports', [AdminController::class, 'showAppointmentsReportUpload'])->name('appointments.reports');
    Route::get('/admin/reports', [AdminController::class, 'viewReports'])->name('admin.reports');

    Route::get('appointments/{appointment}/edit', [AdminController::class, 'editAppointment'])->name('appointments.edit');
    Route::put('appointments/{appointment}', [AdminController::class, 'updateAppointment'])->name('appointments.update');

    Route::get('employees/{employee}/edit', [AdminController::class, 'editEmployee'])->name('employees.edit');
    Route::put('employees/{employee}', [AdminController::class, 'updateEmployee'])->name('employees.update');
    Route::delete('employees/{employee}', [AdminController::class, 'destroyEmployee'])->name('employees.destroy');
});


/*
|--------------------------------------------------------------------------
| User-Specific Routes (Protected by manual session check in controllers)
|--------------------------------------------------------------------------
*/
// Employee Routes


Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('appointments/new', [EmployeeController::class, 'newAppointments'])->name('appointments.new');
    Route::get('appointments/sample-collected', [EmployeeController::class, 'sampleCollected'])->name('appointments.sample_collected');
    Route::put('appointments/{appointment}/collect', [EmployeeController::class, 'collectSample'])->name('appointments.collect');
    Route::get('employee/appointments/reports', [EmployeeController::class, 'reports'])->name('employee.appointments.reports');

    // Add this route to list appointments ready for report upload
    Route::get('appointments/reports', [EmployeeController::class, 'reportUpload'])->name('appointments.reports');

    Route::get('appointments/history', [EmployeeController::class, 'appointmentHistory'])->name('appointments.history');
    Route::put('appointments/{appointment}/update-status', [EmployeeController::class, 'updateStatus'])->name('appointments.updateStatus');

    // In web.php, within the 'employee' group:
    Route::get('appointments/{appointment}/upload-report', [EmployeeController::class, 'showUploadReportForm'])->name('appointments.upload_report');
    // CHANGE THIS LINE: Reference AdminController where the update logic exists
    Route::post('appointments/{appointment}/upload-report', [AdminController::class, 'uploadReport'])->name('appointments.upload_report.store');
    
});






/*
|--------------------------------------------------------------------------
| User-Specific Routes (Protected by manual session check in controllers)
|--------------------------------------------------------------------------
*/
// Patient Routes
Route::get('patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('reports', [AppointmentController::class, 'uploadedReports'])->name('reports');
});



// Profile Routes
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [UserController::class, 'profile'])->name('show'); // Using UserController@profile
    Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});


// Test Management (Resource routes)
Route::resource('tests', TestController::class);

// track appointment by patient
Route::get('/patient/appointments', [AppointmentController::class, 'history'])->name('appointment.history');
Route::patch('/patient/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
