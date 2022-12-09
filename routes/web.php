<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebControllers\LoginController;
use App\Http\Controllers\WebControllers\HomeController;
use App\Http\Controllers\WebControllers\AssignmentController;
use App\Http\Controllers\WebControllers\TeacherController;
use App\Http\Controllers\WebControllers\SchoolController;
use App\Http\Controllers\WebControllers\FinanceController;
use App\Http\Controllers\WebControllers\ManagementController;
use Illuminate\Support\Facades\Artisan;

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
Route::get('/cache-clear', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');

    return Artisan::output();
});

// Route::get('/', function () {
//     return view('welcome');
// });
// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [LoginController::class, 'login']);
Route::post('/processLogin', [LoginController::class, 'processLogin']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/profile', [LoginController::class, 'profile']);

Route::get('/dashboard', [HomeController::class, 'dashboard']);

// Assignment
Route::get('/assignments', [AssignmentController::class, 'assignments']);
Route::get('/assignment-details', [AssignmentController::class, 'assignmentDetails']);
Route::get('/assignment-contact', [AssignmentController::class, 'assignmentContact']);
Route::get('/assignment-candidate', [AssignmentController::class, 'assignmentCandidate']);
Route::get('/assignment-school', [AssignmentController::class, 'assignmentSchool']);
Route::get('/assignment-finance', [AssignmentController::class, 'assignmentFinance']);
// Assignment

// Teacher
Route::get('/teachers', [TeacherController::class, 'teachers']);
Route::post('/newTeacherInsert', [TeacherController::class, 'newTeacherInsert']);
Route::get('/teacher-search', [TeacherController::class, 'teacherSearch']);
Route::get('/teacher-pending-reference', [TeacherController::class, 'teacherPendingReference']);
Route::get('/teacher-calendar', [TeacherController::class, 'teacherCalendar']);
Route::get('/teacher-detail/{id}', [TeacherController::class, 'teacherDetail']);
Route::get('/profession-qualification/{id}', [TeacherController::class, 'teacherProfession']);
Route::get('/preference-health/{id}', [TeacherController::class, 'teacherHealth']);
Route::get('/teacher-references/{id}', [TeacherController::class, 'teacherReference']);
Route::get('/teacher-documents/{id}', [TeacherController::class, 'teacherDocuments']);
Route::get('/teacher-contact-log/{id}', [TeacherController::class, 'teacherContactLog']);
Route::get('/teacher-payroll/{id}', [TeacherController::class, 'teacherPayroll']);
// Teacher

// School
Route::get('/schools', [SchoolController::class, 'schools']);
Route::post('/newSchoolInsert', [SchoolController::class, 'newSchoolInsert']);
Route::get('/school-search', [SchoolController::class, 'schoolSearch']);
Route::get('/school-detail/{id}', [SchoolController::class, 'schoolDetail']);
Route::post('/schoolAddressUpdate', [SchoolController::class, 'schoolAddressUpdate']);
Route::post('/schoolContactInsert', [SchoolController::class, 'schoolContactInsert']);
Route::post('/getSchoolContactDetail', [SchoolController::class, 'getSchoolContactDetail']);
Route::post('/schoolContactUpdate', [SchoolController::class, 'schoolContactUpdate']);
Route::post('/schoolContactDelete', [SchoolController::class, 'schoolContactDelete']);
Route::post('/schoolContactItemInsert', [SchoolController::class, 'schoolContactItemInsert']);
Route::post('/fetchContactItemList', [SchoolController::class, 'fetchContactItemList']);
Route::post('/getContactItemDetail', [SchoolController::class, 'getContactItemDetail']);
Route::post('/schoolContactItemUpdate', [SchoolController::class, 'schoolContactItemUpdate']);
Route::post('/schoolContactItemDelete', [SchoolController::class, 'schoolContactItemDelete']);
Route::get('/school-contact/{id}', [SchoolController::class, 'schoolContact']);
Route::post('/schoolContactLogInsert', [SchoolController::class, 'schoolContactLogInsert']);
Route::get('/school-assignment/{id}', [SchoolController::class, 'schoolAssignment']);
Route::get('/school-finance/{id}', [SchoolController::class, 'schoolFinance']);
Route::post('/schoolFinanceInvoiceInsert', [SchoolController::class, 'schoolFinanceInvoiceInsert']);
Route::get('/school-finance-invoice-edit/{id}/{invoice_id}', [SchoolController::class, 'schoolFinanceInvoiceEdit']);
Route::post('/schoolFinanceInvItemInsert', [SchoolController::class, 'schoolFinanceInvItemInsert']);
Route::post('/getInvoiceItemDetail', [SchoolController::class, 'getInvoiceItemDetail']);
Route::post('/schoolFinanceInvItemUpdate', [SchoolController::class, 'schoolFinanceInvItemUpdate']);
Route::post('/schoolFinanceInvItemDelete', [SchoolController::class, 'schoolFinanceInvItemDelete']);
Route::post('/schoolFinanceInvoiceUpdate', [SchoolController::class, 'schoolFinanceInvoiceUpdate']);
Route::post('/schoolCreditInvoiceInsert', [SchoolController::class, 'schoolCreditInvoiceInsert']);
Route::post('/invoiceDetailForSplit', [SchoolController::class, 'invoiceDetailForSplit']);
Route::post('/schoolSplitInvoiceCreate', [SchoolController::class, 'schoolSplitInvoiceCreate']);
Route::get('/school-invoice-pdf/{id}/{invoice_id}', [SchoolController::class, 'schoolInvoicePdf']);
Route::get('/school-teacher/{id}', [SchoolController::class, 'schoolTeacher']);
Route::get('/school-document/{id}', [SchoolController::class, 'schoolDocument']);
Route::post('/schoolDocumentInsert', [SchoolController::class, 'schoolDocumentInsert']);
Route::post('/getSchoolDocDetail', [SchoolController::class, 'getSchoolDocDetail']);
Route::post('/schoolDocumentUpdate', [SchoolController::class, 'schoolDocumentUpdate']);
Route::post('/schoolDocumentDelete', [SchoolController::class, 'schoolDocumentDelete']);
Route::post('/schoolBillingAddressUpdate', [SchoolController::class, 'schoolBillingAddressUpdate']);
// School

// Finance
Route::get('/finance', [FinanceController::class, 'finance']);
Route::get('/finance-timesheets', [FinanceController::class, 'financeTimesheets']);
Route::get('/finance-invoices', [FinanceController::class, 'financeInvoices']);
Route::get('/finance-payroll', [FinanceController::class, 'financePayroll']);
Route::get('/finance-remittance', [FinanceController::class, 'financeRemittance']);
// Finance

// Management
Route::get('/management', [ManagementController::class, 'management']);
Route::get('/management-user', [ManagementController::class, 'managementUser']);
Route::get('/management-mailshot', [ManagementController::class, 'managementMailshot']);
// Management
