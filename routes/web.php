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
Route::post('/createNewAssignment', [AssignmentController::class, 'createNewAssignment']);
Route::get('/assignment-details/{id}', [AssignmentController::class, 'assignmentDetails']);
Route::post('/insertAssignmentEvent/{id}', [AssignmentController::class, 'insertAssignmentEvent']);
Route::post('/updateAssignmentEvent/{id}', [AssignmentController::class, 'updateAssignmentEvent']);
Route::post('/checkAssignmentEvent/{id}', [AssignmentController::class, 'checkAssignmentEvent']);
Route::post('/checkAssignmentEvent2/{id}', [AssignmentController::class, 'checkAssignmentEvent2']);
Route::post('/ajaxAssignmentEventUpdate', [AssignmentController::class, 'ajaxAssignmentEventUpdate']);
Route::post('/addBlockBooking', [AssignmentController::class, 'addBlockBooking']);
Route::post('/unBlockBooking', [AssignmentController::class, 'unBlockBooking']);
Route::post('/prevNextEvent/{id}', [AssignmentController::class, 'prevNextEvent']);
Route::post('/assignmentDetailUpdate', [AssignmentController::class, 'assignmentDetailUpdate']);
Route::post('/checkVettingExist', [AssignmentController::class, 'checkVettingExist']);
Route::post('/createCandidateVetting', [AssignmentController::class, 'createCandidateVetting']);
Route::post('/updateCandidateVetting', [AssignmentController::class, 'updateCandidateVetting']);
Route::post('/assignmentStatusEdit', [AssignmentController::class, 'assignmentStatusEdit']);
Route::get('/assignment-contact/{id}', [AssignmentController::class, 'assignmentContact']);
Route::post('/assignmentContactLogInsert', [AssignmentController::class, 'assignmentContactLogInsert']);
Route::post('/asnContactHistoryEdit', [AssignmentController::class, 'asnContactHistoryEdit']);
Route::post('/asnContactLogEdit', [AssignmentController::class, 'asnContactLogEdit']);
Route::post('/asnSchoolContactLogUpdate', [AssignmentController::class, 'asnSchoolContactLogUpdate']);
Route::post('/asnTeacherContactLogUpdate', [AssignmentController::class, 'asnTeacherContactLogUpdate']);
Route::get('/assignment-candidate/{id}', [AssignmentController::class, 'assignmentCandidate']);
Route::post('/addAsnPreferredTeacher', [AssignmentController::class, 'addAsnPreferredTeacher']);
Route::post('/updateAssignmentTeacher', [AssignmentController::class, 'updateAssignmentTeacher']);
Route::get('/assignment-school/{id}', [AssignmentController::class, 'assignmentSchool']);
Route::get('/assignment-finance/{id}', [AssignmentController::class, 'assignmentFinance']);
// Assignment

// Teacher
Route::get('/teachers', [TeacherController::class, 'teachers']);
Route::post('/newTeacherInsert', [TeacherController::class, 'newTeacherInsert']);
Route::get('/teacher-search', [TeacherController::class, 'teacherSearch']);
Route::get('/teacher-pending-reference', [TeacherController::class, 'teacherPendingReference']);
Route::get('/teacher-calendar', [TeacherController::class, 'teacherCalendar']);
Route::POST('/teacherCalendarList', [TeacherController::class, 'teacherCalendarList']);
Route::get('/calendarListByTeacher/{id}', [TeacherController::class, 'calendarListByTeacher']);
Route::POST('/teacherEventExist', [TeacherController::class, 'teacherEventExist']);
Route::POST('/teacherCalEventAdd', [TeacherController::class, 'teacherCalEventAdd']);
Route::POST('/teacherEventEdit', [TeacherController::class, 'teacherEventEdit']);
Route::POST('/teacherEventUpdate', [TeacherController::class, 'teacherEventUpdate']);
Route::POST('/teacherEventDelete', [TeacherController::class, 'teacherEventDelete']);
Route::get('/teacher-calendar-list/{id}', [TeacherController::class, 'teacherCalendarById']);
Route::get('/teacher-detail/{id}', [TeacherController::class, 'teacherDetail']);
Route::post('/teacherDetailUpdate', [TeacherController::class, 'teacherDetailUpdate']);
Route::post('/teacherAddressUpdate', [TeacherController::class, 'teacherAddressUpdate']);
Route::post('/teacherEmergencyContactUpdate', [TeacherController::class, 'teacherEmergencyContactUpdate']);
Route::post('/teacherContactItemInsert', [TeacherController::class, 'teacherContactItemInsert']);
Route::post('/teacherContactItemEdit', [TeacherController::class, 'teacherContactItemEdit']);
Route::post('/teacherContactItemUpdate', [TeacherController::class, 'teacherContactItemUpdate']);
Route::post('/teacherProfessionUpdate', [TeacherController::class, 'teacherProfessionUpdate']);
Route::post('/teacherInterviewUpdate', [TeacherController::class, 'teacherInterviewUpdate']);
Route::post('/teachingSubjectInsert', [TeacherController::class, 'teachingSubjectInsert']);
Route::post('/teachingSubjectEdit', [TeacherController::class, 'teachingSubjectEdit']);
Route::post('/teachingSubjectUpdate', [TeacherController::class, 'teachingSubjectUpdate']);
Route::post('/teacherQualificationInsert', [TeacherController::class, 'teacherQualificationInsert']);
Route::post('/teacherQualificationEdit', [TeacherController::class, 'teacherQualificationEdit']);
Route::post('/teacherQualificationUpdate', [TeacherController::class, 'teacherQualificationUpdate']);
Route::post('/teacherQualificationDelete', [TeacherController::class, 'teacherQualificationDelete']);
Route::post('/teacherPreferenceUpdate', [TeacherController::class, 'teacherPreferenceUpdate']);
Route::post('/teacherHealthUpdate', [TeacherController::class, 'teacherHealthUpdate']);
Route::get('/profession-qualification/{id}', [TeacherController::class, 'teacherProfession']);
Route::get('/preference-health/{id}', [TeacherController::class, 'teacherHealth']);
Route::get('/teacher-references/{id}', [TeacherController::class, 'teacherReference']);
Route::post('/newTeacherReferenceInsert', [TeacherController::class, 'newTeacherReferenceInsert']);
Route::post('/teacherReferenceEdit', [TeacherController::class, 'teacherReferenceEdit']);
Route::post('/newTeacherReferenceUpdate', [TeacherController::class, 'newTeacherReferenceUpdate']);
Route::post('/getTeacherReceiveReference', [TeacherController::class, 'getTeacherReceiveReference']);
Route::post('/receiveReferenceUpdate', [TeacherController::class, 'receiveReferenceUpdate']);
Route::get('/teacher-documents/{id}', [TeacherController::class, 'teacherDocuments']);
Route::post('/teacherDocumentListUpdate', [TeacherController::class, 'teacherDocumentListUpdate']);
Route::post('/teacherVettingUpdate', [TeacherController::class, 'teacherVettingUpdate']);
Route::post('/newTeacherDbsInsert', [TeacherController::class, 'newTeacherDbsInsert']);
Route::post('/teacherDbsRecordEdit', [TeacherController::class, 'teacherDbsRecordEdit']);
Route::post('/teacherDbsUpdate', [TeacherController::class, 'teacherDbsUpdate']);
Route::post('/teacherDbsRecordView', [TeacherController::class, 'teacherDbsRecordView']);
Route::post('/teacherDbsRecordDelete', [TeacherController::class, 'teacherDbsRecordDelete']);
Route::post('/teacherDocumentInsert', [TeacherController::class, 'teacherDocumentInsert']);
Route::post('/getTeacherDocDetail', [TeacherController::class, 'getTeacherDocDetail']);
Route::post('/teacherDocumentUpdate', [TeacherController::class, 'teacherDocumentUpdate']);
Route::post('/teacherDocumentDelete', [TeacherController::class, 'teacherDocumentDelete']);
Route::get('/teacher-contact-log/{id}', [TeacherController::class, 'teacherContactLog']);
Route::post('/teacherContactLogInsert', [TeacherController::class, 'teacherContactLogInsert']);
Route::post('/teacherContactLogEdit', [TeacherController::class, 'teacherContactLogEdit']);
Route::post('/teacherContactLogUpdate', [TeacherController::class, 'teacherContactLogUpdate']);
Route::post('/teacherContactLogDelete', [TeacherController::class, 'teacherContactLogDelete']);
Route::get('/teacher-payroll/{id}', [TeacherController::class, 'teacherPayroll']);
Route::post('/teacherPayrollUpdate', [TeacherController::class, 'teacherPayrollUpdate']);
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
Route::post('/schoolContactHistoryEdit', [SchoolController::class, 'schoolContactHistoryEdit']);
Route::post('/schoolContactLogUpdate', [SchoolController::class, 'schoolContactLogUpdate']);
Route::post('/schoolContactHistoryDelete', [SchoolController::class, 'schoolContactHistoryDelete']);
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
Route::post('/schoolInvoiceRemit', [SchoolController::class, 'schoolInvoiceRemit']);
Route::get('/school-invoice-pdf/{id}/{invoice_id}', [SchoolController::class, 'schoolInvoicePdf']);
Route::post('/schoolInvoiceDelete', [SchoolController::class, 'schoolInvoiceDelete']);
Route::get('/school-teacher/{id}', [SchoolController::class, 'schoolTeacher']);
Route::post('/searchTeacherList', [SchoolController::class, 'searchTeacherList']);
Route::post('/schoolTeacherInsert', [SchoolController::class, 'schoolTeacherInsert']);
Route::post('/schoolTeacherEdit', [SchoolController::class, 'schoolTeacherEdit']);
Route::post('/editSearchTeacherList', [SchoolController::class, 'editSearchTeacherList']);
Route::post('/schoolTeacherUpdate', [SchoolController::class, 'schoolTeacherUpdate']);
Route::post('/schoolTeacherDelete', [SchoolController::class, 'schoolTeacherDelete']);
Route::get('/school-document/{id}', [SchoolController::class, 'schoolDocument']);
Route::post('/schoolDocumentInsert', [SchoolController::class, 'schoolDocumentInsert']);
Route::post('/getSchoolDocDetail', [SchoolController::class, 'getSchoolDocDetail']);
Route::post('/schoolDocumentUpdate', [SchoolController::class, 'schoolDocumentUpdate']);
Route::post('/schoolDocumentDelete', [SchoolController::class, 'schoolDocumentDelete']);
Route::post('/schoolBillingAddressUpdate', [SchoolController::class, 'schoolBillingAddressUpdate']);
Route::get('/school-calendar/{id}', [SchoolController::class, 'schoolCalendar']);
// School

// Finance
Route::get('/finance', [FinanceController::class, 'finance']);
Route::get('/finance-timesheets', [FinanceController::class, 'financeTimesheets']);
Route::post('/fetchTeacherById', [FinanceController::class, 'fetchTeacherById']);
Route::post('/timesheetAsnItemDelete', [FinanceController::class, 'timesheetAsnItemDelete']);
Route::post('/timesheetEditEvent', [FinanceController::class, 'timesheetEditEvent']);
Route::post('/timesheetEventUpdate', [FinanceController::class, 'timesheetEventUpdate']);
Route::get('/finance-invoices', [FinanceController::class, 'financeInvoices']);
Route::get('/finance-payroll', [FinanceController::class, 'financePayroll']);
Route::get('/finance-remittance', [FinanceController::class, 'financeRemittance']);
Route::get('/finance-invoice-pdf/{invoice_id}', [FinanceController::class, 'financeInvoicePdf']);
// Finance

// Management
Route::get('/management', [ManagementController::class, 'management']);
Route::get('/management-user', [ManagementController::class, 'managementUser']);
Route::get('/management-mailshot', [ManagementController::class, 'managementMailshot']);
// Management


// Teacher Portal
Route::group(['namespace' => 'WebControllers', 'prefix' => 'teacher'], function () {
    Route::get('/set-password/{id}', [TeacherController::class, 'teacherSetPassword']);
});