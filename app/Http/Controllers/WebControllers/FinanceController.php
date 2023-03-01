<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use PDF;

class FinanceController extends Controller
{
    public function finance(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.finance.index", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeTimesheets(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance Timesheets");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $p_maxDate = date('Y-m-d');
            if ($request->date) {
                $p_maxDate = date('Y-m-d', strtotime($request->date));
            }

            $weekStartDate = Carbon::parse($p_maxDate)->startOfWeek()->format('Y-m-d');
            $weekEndDate = Carbon::parse($p_maxDate)->endOfWeek()->format('Y-m-d');
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));

            $timesheetSchoolList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->select('tbl_asn.school_id', 'tbl_school.name_txt As schoolName_txt', DB::raw("COUNT(asnItem_id) AS timesheetDatesRequired_int"))
                ->where('timesheet_id', NULL)
                ->where('status_int', 3)
                ->whereDate('asnDate_dte', '<=', $p_maxDate)
                ->groupBy('school_id')
                ->orderByRaw('COUNT(asnItem_id) DESC')
                ->get();

            $documentList = DB::table('teacher_timesheet')
                ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('pdf', 'teacher_timesheet.pdf_id', '=', 'pdf.pdf_id')
                ->select('teacher_timesheet.*', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'pdf.pdf_name', 'pdf.pdf_path')
                ->where('teacher_timesheet.timesheet_status', 0)
                ->where('teacher_timesheet.submit_status', 1)
                ->where('teacher_timesheet.reject_status', 0)
                // ->where('teacher_timesheet.approve_by_school', '!=', 1)
                ->whereDate('teacher_timesheet.start_date', '=', $weekStartDate)
                ->whereDate('teacher_timesheet.end_date', '=', $weekEndDate)
                ->groupBy('teacher_timesheet.teacher_timesheet_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();

            return view("web.finance.finance_timesheet", ['title' => $title, 'headerTitle' => $headerTitle, 'timesheetSchoolList' => $timesheetSchoolList, 'p_maxDate' => $p_maxDate, 'documentList' => $documentList, 'weekStartDate' => $weekStartDate, 'weekEndDate' => $weekEndDate]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function fetchTeacherById(Request $request)
    {
        $input = $request->all();
        $max_date = $input['max_date'];
        $school_id = $input['school_id'];

        $teacherList = DB::table('tbl_asn')
            ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
            ->LeftJoin('tbl_student', 'tbl_asn.student_id', '=', 'tbl_student.student_id')
            ->select('asnItem_id', 'tbl_asn.teacher_id', 'tbl_asn.asn_id', 'tbl_asn.school_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), DB::raw("IF(tbl_asn.student_id IS NOT NULL, CONCAT(tbl_student.firstname_txt, ' ', tbl_student.surname_txt), '') AS studentName_txt"))
            ->where('timesheet_id', NULL)
            ->where('status_int', 3)
            ->whereDate('asnDate_dte', '<=', $max_date)
            ->where('school_id', $school_id)
            ->groupBy('tbl_asn.teacher_id', 'asnItem_id', 'asnDate_dte')
            ->orderBy('tbl_asn.teacher_id', 'ASC')
            ->orderBy('tbl_asnItem.asnDate_dte', 'DESC')
            ->get();

        $html = '';
        if (count($teacherList) > 0) {
            foreach ($teacherList as $key => $teacher) {
                $name = '';
                if ($teacher->knownAs_txt == null && $teacher->knownAs_txt == '') {
                    $name = $teacher->firstName_txt . ' ' . $teacher->surname_txt;
                } else {
                    $name = $teacher->knownAs_txt . ' ' . $teacher->surname_txt;
                }
                $html .= "<tr class='school-detail-table-data selectTeacherRow' id='selectTeacherRow$teacher->asnItem_id' teacher-id='$teacher->teacher_id' asn-id='$teacher->asn_id' asnitem-id='$teacher->asnItem_id' school-id='$teacher->school_id'>
                    <td>$name</td>
                    <td>$teacher->asnDate_dte</td>
                    <td>$teacher->datePart_txt</td>
                    <td>$teacher->studentName_txt</td>
                </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function timesheetAsnItemDelete(Request $request)
    {
        $asnItemIds = $request->asnItemIds;
        $idsArr = explode(",", $asnItemIds);

        foreach ($idsArr as $key => $id) {
            DB::table('tbl_asnItem')
                ->where('asnItem_id', $id)
                ->delete();
        }
        return true;
    }

    public function timesheetEditEvent(Request $request)
    {
        $result['exist'] = "No";
        $asnItem_id = $request->id;
        $eventItemDetail = DB::table('tbl_asnItem')
            ->where('tbl_asnItem.asnItem_id', $asnItem_id)
            ->first();

        if ($eventItemDetail) {
            $dayPartList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 20)
                ->get();

            $view = view("web.finance.event_edit_view", ['eventItemDetail' => $eventItemDetail, 'dayPartList' => $dayPartList])->render();
            $result['exist'] = "Yes";
            $result['eventId'] = $eventItemDetail->asnItem_id;
            $result['html'] = $view;
            return response()->json($result);
        } else {
            $result['exist'] = "No";
            return response()->json($result);
        }
        return response()->json($result);
    }

    public function timesheetEventUpdate(Request $request)
    {
        $editEventId = $request->editEventId;

        DB::table('tbl_asnItem')
            ->where('asnItem_id', $editEventId)
            ->update([
                'dayPart_int' => $request->dayPart_int,
                'asnDate_dte' => date("Y-m-d", strtotime($request->asnDate_dte)),
                'charge_dec' => $request->charge_dec,
                'dayPercent_dec' => $request->dayPercent_dec,
                'hours_dec' => $request->hours_dec,
                'cost_dec' => $request->cost_dec
            ]);

        $max_date = $request->max_date;
        $school_id = $request->school_id;

        $teacherList = DB::table('tbl_asn')
            ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
            ->LeftJoin('tbl_student', 'tbl_asn.student_id', '=', 'tbl_student.student_id')
            ->select('asnItem_id', 'tbl_asn.teacher_id', 'tbl_asn.asn_id', 'tbl_asn.school_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), DB::raw("IF(tbl_asn.student_id IS NOT NULL, CONCAT(tbl_student.firstname_txt, ' ', tbl_student.surname_txt), '') AS studentName_txt"))
            ->where('timesheet_id', NULL)
            ->where('status_int', 3)
            ->whereDate('asnDate_dte', '<=', $max_date)
            ->where('school_id', $school_id)
            ->groupBy('tbl_asn.teacher_id', 'asnItem_id', 'asnDate_dte')
            ->orderBy('tbl_asn.teacher_id', 'ASC')
            ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
            ->get();

        $html = '';
        if (count($teacherList) > 0) {
            foreach ($teacherList as $key => $teacher) {
                $name = '';
                if ($teacher->knownAs_txt == null && $teacher->knownAs_txt == '') {
                    $name = $teacher->firstName_txt . ' ' . $teacher->surname_txt;
                } else {
                    $name = $teacher->knownAs_txt . ' ' . $teacher->surname_txt;
                }
                $html .= "<tr class='school-detail-table-data selectTeacherRow' id='selectTeacherRow$teacher->asnItem_id' teacher-id='$teacher->teacher_id' asn-id='$teacher->asn_id' asnitem-id='$teacher->asnItem_id' school-id='$teacher->school_id'>
                            <td>$name</td>
                            <td>$teacher->asnDate_dte</td>
                            <td>$teacher->datePart_txt</td>
                            <td>$teacher->studentName_txt</td>
                        </tr>";
            }
        }

        $result['status'] = "success";
        $result['eventId'] = $editEventId;
        $result['html'] = $html;
        return response()->json($result);
    }

    public function fetchTeacherSheetById(Request $request)
    {
        $input = $request->all();
        $teacher_timesheet_id = $input['teacher_timesheet_id'];

        $timesheetExist = DB::table('teacher_timesheet')
            ->LeftJoin('pdf', 'teacher_timesheet.pdf_id', '=', 'pdf.pdf_id')
            ->select('teacher_timesheet.*', 'pdf.pdf_path')
            ->where('teacher_timesheet_id', $teacher_timesheet_id)
            ->first();
        $pdfPath = '';
        if ($timesheetExist && $timesheetExist->pdf_path) {
            if (file_exists(public_path($timesheetExist->pdf_path))) {
                $pdfPath = asset($timesheetExist->pdf_path);
            }
        }

        $teacherList = DB::table('teacher_timesheet')
            ->LeftJoin('teacher_timesheet_item', 'teacher_timesheet.teacher_timesheet_id', '=', 'teacher_timesheet_item.teacher_timesheet_id')
            ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
            ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
            ->select('teacher_timesheet.*', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"))
            ->where('teacher_timesheet.teacher_timesheet_id', $teacher_timesheet_id)
            ->groupBy('teacher_timesheet_item.asnDate_dte')
            ->orderBy('teacher_timesheet_item.asnDate_dte', 'DESC')
            ->get();

        $html = '';
        if (count($teacherList) > 0) {
            foreach ($teacherList as $key => $teacher) {
                $name = '';
                if ($teacher->knownAs_txt == null && $teacher->knownAs_txt == '') {
                    $name = $teacher->firstName_txt . ' ' . $teacher->surname_txt;
                } else {
                    $name = $teacher->knownAs_txt . ' ' . $teacher->surname_txt;
                }
                $html .= "<tr class='school-detail-table-data'>
                    <td>$name</td>
                    <td>$teacher->asnDate_dte</td>
                    <td>$teacher->datePart_txt</td>
                </tr>";
            }
        }

        return response()->json(['html' => $html, 'pdfPath' => $pdfPath]);
    }

    public function rejectTeacherSheet(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $teacher_timesheet_id = $input['teacher_timesheet_id'];

            DB::table('teacher_timesheet')
                ->where('teacher_timesheet_id', $teacher_timesheet_id)
                ->update([
                    'approve_by_school' => 0,
                    'reject_status' => 1,
                    'rejected_by' => $user_id,
                    'rejected_date' => date('Y-m-d')
                ]);

            return true;
        }
        return true;
    }

    public function sendTimesheetToApproval(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $teacher_timesheet_id = $input['teacher_timesheet_id'];

            DB::table('teacher_timesheet')
                ->where('teacher_timesheet_id', $teacher_timesheet_id)
                ->update([
                    'approve_by_school' => 1
                ]);

            return true;
        }
        return true;
    }

    // public function teacherTimesheetView(Request $request)
    // {
    //     $webUserLoginData = Session::get('webUserLoginData');
    //     if ($webUserLoginData) {
    //         $title = array('pageTitle' => "Teacher Timesheet View");
    //         $headerTitle = "Finance";
    //         $company_id = $webUserLoginData->company_id;
    //         $user_id = $webUserLoginData->user_id;
    //         $input = $request->all();
    //         $school_id = $input['school'];
    //         $teacher_id = $input['teacher'];
    //         $weekStartDate = $input['start'];
    //         $weekEndDate = $input['end'];

    //         $teacherList = DB::table('teacher_timesheet_new')
    //             ->LeftJoin('tbl_school', 'teacher_timesheet_new.school_id', '=', 'tbl_school.school_id')
    //             ->LeftJoin('tbl_teacher', 'teacher_timesheet_new.teacher_id', '=', 'tbl_teacher.teacher_id')
    //             ->select('teacher_timesheet_new.asnItem_id', 'teacher_timesheet_new.teacher_id', 'teacher_timesheet_new.asn_id', 'teacher_timesheet_new.school_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"))
    //             ->where('teacher_timesheet_new.teacher_id', $teacher_id)
    //             ->where('teacher_timesheet_new.school_id', $school_id)
    //             ->where('teacher_timesheet_new.timesheet_status', 0)
    //             ->where('teacher_timesheet_new.submit_status', 1)
    //             ->whereDate('teacher_timesheet_new.asnDate_dte', '>=', $weekStartDate)
    //             ->whereDate('teacher_timesheet_new.asnDate_dte', '<=', $weekEndDate)
    //             ->groupBy('teacher_timesheet_new.asnDate_dte')
    //             ->orderBy('teacher_timesheet_new.asnDate_dte', 'ASC')
    //             ->get();

    //         $teacherDet = DB::table('tbl_teacher')
    //             ->where('tbl_teacher.teacher_id', $teacher_id)
    //             ->first();

    //         $schoolDet = DB::table('tbl_school')
    //             ->where('tbl_school.school_id', $school_id)
    //             ->first();

    //         return view("web.finance.finance_teacher_sheet", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherList' => $teacherList, 'teacherDet' => $teacherDet, 'schoolDet' => $schoolDet, 'weekStartDate' => $weekStartDate, 'weekEndDate' => $weekEndDate]);
    //     } else {
    //         return redirect()->intended('/');
    //     }
    // }

    public function financeInvoices(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance Invoices");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.finance.finance_invoice", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financePayroll(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance Payroll");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.finance.finance_payroll", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeRemittance(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance Remittance");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $Invoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_user as paymentLoggedTbl', 'tbl_invoice.paymentLoggedBy_id', '=', 'paymentLoggedTbl.user_id')
                ->LeftJoin('tbl_user as senderTbl', 'tbl_invoice.sentBy_int', '=', 'senderTbl.user_id')
                ->select('tbl_invoice.invoice_id', 'tbl_invoice.school_id', 'tbl_invoice.invoiceDate_dte As invoice_dte', 'tbl_school.name_txt As school_txt', 'tbl_invoice.paidOn_dte As paid_dte', DB::raw("CONCAT(paymentLoggedTbl.firstName_txt, ' ', paymentLoggedTbl.surname_txt) As remittee_txt"), 'tbl_invoice.sentOn_dte As sent_dte', DB::raw("CONCAT(senderTbl.firstName_txt, ' ', senderTbl.surname_txt) As sender_txt"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"));
            if ($request->include == '') {
                $Invoices->where('tbl_invoice.paidOn_dte', NULL);
            }
            if ($request->method) {
                $Invoices->where('tbl_invoice.paymentMethod_int', $request->method);
            }
            $remitInvoices = $Invoices->groupBy('tbl_invoice.invoice_id')
                ->get();

            $paymentMethodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 42)
                ->get();

            return view("web.finance.finance_remittance", ['title' => $title, 'headerTitle' => $headerTitle, 'remitInvoices' => $remitInvoices, 'paymentMethodList' => $paymentMethodList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeInvoicePdf(Request $request, $invoice_id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $schoolInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.invoice_id', $invoice_id)
                ->groupBy('tbl_invoice.invoice_id')
                ->first();
            $invoiceItemList = DB::table('tbl_invoiceItem')
                ->select('tbl_invoiceItem.*')
                ->where('tbl_invoiceItem.invoice_id', $invoice_id)
                ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                ->get();

            $schoolDetail = DB::table('tbl_school')
                ->LeftJoin('tbl_localAuthority', 'tbl_localAuthority.la_id', '=', 'tbl_school.la_id')
                ->LeftJoin('tbl_schoolContactLog', function ($join) {
                    $join->on('tbl_schoolContactLog.school_id', '=', 'tbl_school.school_id');
                })
                ->LeftJoin('tbl_user as contactUser', 'contactUser.user_id', '=', 'tbl_schoolContactLog.contactBy_id')
                ->LeftJoin('tbl_description as AgeRange', function ($join) {
                    $join->on('AgeRange.description_int', '=', 'tbl_school.ageRange_int')
                        ->where(function ($query) {
                            $query->where('AgeRange.descriptionGroup_int', '=', 28);
                        });
                })
                ->LeftJoin('tbl_description as religion', function ($join) {
                    $join->on('religion.description_int', '=', 'tbl_school.religion_int')
                        ->where(function ($query) {
                            $query->where('religion.descriptionGroup_int', '=', 29);
                        });
                })
                ->LeftJoin('tbl_description as SchoolType', function ($join) {
                    $join->on('SchoolType.description_int', '=', 'tbl_school.type_int')
                        ->where(function ($query) {
                            $query->where('SchoolType.descriptionGroup_int', '=', 30);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp')
                ->where('tbl_school.school_id', $schoolInvoices->school_id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                ->first();

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            $pdf = PDF::loadView('web.school.school_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail]);
            $pdfName = 'invoice-' . $invoice_id . '.pdf';
            // return $pdf->download('test.pdf');
            return $pdf->stream($pdfName);
        } else {
            return redirect()->intended('/');
        }
    }
}
