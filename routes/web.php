<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ShivirArchiveController;
use App\Http\Controllers\Front\RegistrationController;
use App\Http\Controllers\Front\RegistrationStatusController;
use App\Http\Controllers\Front\KioskController;
use App\Http\Controllers\Staff\ScanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShivirController as AdminShivirController;
use App\Http\Controllers\Admin\CmsController as AdminCmsController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\AccommodationController as AdminAccommodationController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\RoleMiddleware;

// 1. Public Web Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shivir/{slug}', [HomeController::class, 'index'])->name('shivir.detail');
Route::get('/archive', [ShivirArchiveController::class, 'index'])->name('archive.index');

// Public Multi-Step Registration
Route::get('/shivir/{slug}/register', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/shivir/{slug}/register', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/registration/success/{regNo}', [RegistrationController::class, 'success'])->name('registration.success');
Route::get('/registration/slip/{regNo}/pdf', [RegistrationController::class, 'downloadPdf'])->name('registration.slip.pdf');

// Public Registration Status Lookup & Venue Kiosk
Route::get('/registration-status', [RegistrationStatusController::class, 'index'])->name('registration.status');
Route::post('/registration-status', [RegistrationStatusController::class, 'check'])->name('registration.status.check');
Route::get('/kiosk', [KioskController::class, 'index'])->name('kiosk.index');

// 2. Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Staff QR Scanner & Venue Logistics Routes
Route::middleware(['auth', RoleMiddleware::class . ':super_admin,admin,registration_manager,accommodation_manager,attendance_manager,volunteer'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/scan', [ScanController::class, 'index'])->name('scan');
    Route::post('/lookup', [ScanController::class, 'lookup'])->name('lookup');
    Route::post('/verify/{registration}', [ScanController::class, 'verify'])->name('verify');
    Route::post('/allocate-room/{registration}', [ScanController::class, 'allocateRoom'])->name('allocate-room');
    Route::post('/attendance/{registration}', [ScanController::class, 'recordAttendance'])->name('attendance');
});

// 4. Admin Management Dashboard Routes
Route::middleware(['auth', RoleMiddleware::class . ':super_admin,admin,registration_manager,accommodation_manager,attendance_manager,content_manager,viewer'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Shivir Multi-Year Manager
    Route::resource('shivirs', AdminShivirController::class);

    // Dynamic CMS Sections & Items Manager
    Route::get('/cms', [AdminCmsController::class, 'index'])->name('cms.index');
    Route::post('/cms/section', [AdminCmsController::class, 'storeSection'])->name('cms.section.store');
    Route::put('/cms/section/{section}', [AdminCmsController::class, 'updateSection'])->name('cms.section.update');
    Route::delete('/cms/section/{section}', [AdminCmsController::class, 'destroySection'])->name('cms.section.destroy');
    Route::post('/cms/item', [AdminCmsController::class, 'storeItem'])->name('cms.item.store');
    Route::put('/cms/item/{item}', [AdminCmsController::class, 'updateItem'])->name('cms.item.update');
    Route::delete('/cms/item/{item}', [AdminCmsController::class, 'destroyItem'])->name('cms.item.destroy');

    // Registrations Manager
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{registration}', [AdminRegistrationController::class, 'show'])->name('registrations.show');
    Route::put('/registrations/{registration}/status', [AdminRegistrationController::class, 'updateStatus'])->name('registrations.update-status');

    // Accommodation Manager
    Route::get('/accommodation', [AdminAccommodationController::class, 'index'])->name('accommodation.index');
    Route::post('/accommodation/block', [AdminAccommodationController::class, 'storeBlock'])->name('accommodation.block.store');
    Route::post('/accommodation/room', [AdminAccommodationController::class, 'storeRoom'])->name('accommodation.room.store');
    Route::post('/accommodation/allocate', [AdminAccommodationController::class, 'allocate'])->name('accommodation.allocate');
    Route::delete('/accommodation/allocation/{allocation}', [AdminAccommodationController::class, 'deallocate'])->name('accommodation.deallocate');

    // Attendance Sessions Manager
    Route::get('/attendance', [AdminAttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/session', [AdminAttendanceController::class, 'storeSession'])->name('attendance.session.store');

    // Certificates Engine
    Route::get('/certificates', [AdminCertificateController::class, 'index'])->name('certificates.index');
    Route::post('/certificates/generate-bulk/{shivir}', [AdminCertificateController::class, 'generateBulk'])->name('certificates.generate-bulk');
    Route::get('/certificates/{certificate}/pdf', [AdminCertificateController::class, 'downloadPdf'])->name('certificates.pdf');

    // Excel & CSV Reports Export
    Route::get('/reports/export-registrations/{shivir}', [AdminReportController::class, 'exportRegistrations'])->name('reports.export-registrations');
});
