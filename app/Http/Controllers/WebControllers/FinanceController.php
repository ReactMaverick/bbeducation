<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PayrollExport;
use App\Exports\InvoiceExport;

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
            $todayDate = date('Y-m-d');
            $p_maxDate = Carbon::parse($todayDate)->endOfWeek()->format('Y-m-d');
            if ($request->date) {
                $p_maxDate = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));
            }

            $weekStartDate = Carbon::parse($p_maxDate)->startOfWeek()->format('Y-m-d');
            $weekEndDate = Carbon::parse($p_maxDate)->endOfWeek()->format('Y-m-d');
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
            $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
            $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
            $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));

            $timesheetSchoolList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->select('tbl_asn.school_id', 'tbl_school.name_txt As schoolName_txt', DB::raw("COUNT(asnItem_id) AS timesheetDatesRequired_int"))
                ->where('timesheet_id', NULL)
                ->where('status_int', 3)
                ->whereDate('asnDate_dte', '<=', $weekEndDate)
                ->groupBy('school_id')
                ->orderByRaw('COUNT(asnItem_id) DESC')
                ->get();

            $documentList = DB::table('teacher_timesheet')
                ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('pdf', 'teacher_timesheet.pdf_id', '=', 'pdf.pdf_id')
                ->select('teacher_timesheet.*', 'tbl_school.name_txt', 'tbl_school.login_mail', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'pdf.pdf_name', 'pdf.pdf_path')
                ->where('teacher_timesheet.timesheet_status', 0)
                ->where('teacher_timesheet.submit_status', 1)
                ->where('teacher_timesheet.reject_status', 0)
                // ->where('teacher_timesheet.approve_by_school', '!=', 1)
                ->whereDate('teacher_timesheet.start_date', '=', $weekStartDate)
                ->whereDate('teacher_timesheet.end_date', '=', $weekEndDate)
                ->groupBy('teacher_timesheet.teacher_timesheet_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();

            $calenderList = DB::table('tbl_asn')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('tbl_asnItem as tbl_asnItem1', function ($join) use ($weekStartDate) {
                    $join->on('tbl_asnItem1.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate) {
                            $query->where('tbl_asnItem1.timesheet_id', NULL)
                                ->where('tbl_asnItem1.asnDate_dte', '=', $weekStartDate);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem2', function ($join) use ($weekStartDate2) {
                    $join->on('tbl_asnItem2.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate2) {
                            $query->where('tbl_asnItem2.timesheet_id', NULL)
                                ->where('tbl_asnItem2.asnDate_dte', '=', $weekStartDate2);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem3', function ($join) use ($weekStartDate3) {
                    $join->on('tbl_asnItem3.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate3) {
                            $query->where('tbl_asnItem3.timesheet_id', NULL)
                                ->where('tbl_asnItem3.asnDate_dte', '=', $weekStartDate3);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem4', function ($join) use ($weekStartDate4) {
                    $join->on('tbl_asnItem4.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate4) {
                            $query->where('tbl_asnItem4.timesheet_id', NULL)
                                ->where('tbl_asnItem4.asnDate_dte', '=', $weekStartDate4);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem5', function ($join) use ($weekStartDate5) {
                    $join->on('tbl_asnItem5.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate5) {
                            $query->where('tbl_asnItem5.timesheet_id', NULL)
                                ->where('tbl_asnItem5.asnDate_dte', '=', $weekStartDate5);
                        });
                })
                ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.admin_approve AS admin_approve1', 'tbl_asnItem1.send_to_school AS send_to_school1', 'tbl_asnItem1.rejected_text AS rejected_text1', 'tbl_asnItem1.rejected_by_type AS rejected_by_type1', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem1.start_tm AS start_tm1', 'tbl_asnItem1.end_tm AS end_tm1', 'tbl_asnItem1.lunch_time AS lunch_time1', 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.admin_approve AS admin_approve2', 'tbl_asnItem2.send_to_school AS send_to_school2', 'tbl_asnItem2.rejected_text AS rejected_text2', 'tbl_asnItem2.rejected_by_type AS rejected_by_type2', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem2.start_tm AS start_tm2', 'tbl_asnItem2.end_tm AS end_tm2', 'tbl_asnItem2.lunch_time AS lunch_time2', 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.admin_approve AS admin_approve3', 'tbl_asnItem3.send_to_school AS send_to_school3', 'tbl_asnItem3.rejected_text AS rejected_text3', 'tbl_asnItem3.rejected_by_type AS rejected_by_type3', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem3.start_tm AS start_tm3', 'tbl_asnItem3.end_tm AS end_tm3', 'tbl_asnItem3.lunch_time AS lunch_time3', 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.admin_approve AS admin_approve4', 'tbl_asnItem4.send_to_school AS send_to_school4', 'tbl_asnItem4.rejected_text AS rejected_text4', 'tbl_asnItem4.rejected_by_type AS rejected_by_type4', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem4.start_tm AS start_tm4', 'tbl_asnItem4.end_tm AS end_tm4', 'tbl_asnItem4.lunch_time AS lunch_time4', 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.admin_approve AS admin_approve5', 'tbl_asnItem5.send_to_school AS send_to_school5', 'tbl_asnItem5.rejected_text AS rejected_text5', 'tbl_asnItem5.rejected_by_type AS rejected_by_type5', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"), 'tbl_asnItem5.start_tm AS start_tm5', 'tbl_asnItem5.end_tm AS end_tm5', 'tbl_asnItem5.lunch_time AS lunch_time5')
                ->whereIn('tbl_asn.asn_id', function ($query) use ($weekStartDate, $plusFiveDate, $company_id) {
                    $query->select('tbl_asn.asn_id')
                        ->from('tbl_asn')
                        ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->where('timesheet_id', NULL)
                        ->where('status_int', 3)
                        ->whereDate('asnDate_dte', '>=', $weekStartDate)
                        ->whereDate('asnDate_dte', '<=', $plusFiveDate)
                        ->where('company_id', $company_id)
                        // ->where('admin_approve', '!=', 1)
                        // ->where('send_to_school', 0)
                        ->groupBy('tbl_asn.asn_id')
                        ->get();
                })
                ->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();
            // dd($calenderList);
            // exit;

            return view("web.finance.finance_timesheet", ['title' => $title, 'headerTitle' => $headerTitle, 'calenderList' => $calenderList, 'p_maxDate' => $p_maxDate, 'documentList' => $documentList, 'weekStartDate' => $weekStartDate, 'weekEndDate' => $weekEndDate, 'timesheetSchoolList' => $timesheetSchoolList, 'plusFiveDate' => $plusFiveDate]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeTimesheetApprove(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        $result['add'] = 'No';
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $asnIds = $input['asnIds'];
            $weekStartDate = $input['weekStartDate'];
            $weekEndDate = $input['weekEndDate'];
            $asnIdsArr = explode(",", $asnIds);

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
            // admin approve
            $itemList = DB::table('tbl_asn')
                ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('timesheet_id', NULL)
                ->where('status_int', 3)
                ->whereDate('asnDate_dte', '>=', $weekStartDate)
                ->whereDate('asnDate_dte', '<=', $weekEndDate)
                ->whereIn('tbl_asn.asn_id', $asnIdsArr)
                ->where('company_id', $company_id)
                ->where('admin_approve', '!=', 1)
                // ->where('send_to_school', 0)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->pluck('tbl_asnItem.asnItem_id')
                ->toArray();

            DB::table('tbl_asnItem')
                ->whereIn('asnItem_id', $itemList)
                ->update([
                    'admin_approve' => 1
                ]);

            // log assignment
            $messageArr = array();
            foreach ($asnIdsArr as $key => $asnId) {
                $schoolDet = DB::table('tbl_asn')
                    ->select('tbl_asn.school_id', 'tbl_school.name_txt')
                    ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                    ->where('tbl_asn.asn_id', $asnId)
                    ->first();

                $idsArr = DB::table('tbl_asn')
                    ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                    ->where('timesheet_id', NULL)
                    ->where('status_int', 3)
                    ->whereDate('asnDate_dte', '>=', $weekStartDate)
                    ->whereDate('asnDate_dte', '<=', $weekEndDate)
                    ->where('tbl_asn.asn_id', $asnId)
                    ->where('company_id', $company_id)
                    ->where('admin_approve', 1)
                    // ->where('send_to_school', 0)
                    ->groupBy('tbl_asnItem.asnItem_id')
                    ->pluck('tbl_asnItem.asnItem_id')
                    ->toArray();

                if (count($idsArr) > 0 && $schoolDet) {
                    $itemList = DB::table('tbl_asnItem')
                        ->LeftJoin('tbl_asn', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                        ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                        ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                        ->select('tbl_asnItem.asnItem_id', 'tbl_asnItem.asn_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm')
                        ->whereIn('tbl_asnItem.asnItem_id', $idsArr)
                        ->groupBy('tbl_asnItem.asnItem_id')
                        ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                        ->get();

                    $timesheet_id = DB::table('tbl_timesheet')
                        ->insertGetId([
                            'school_id' => $schoolDet->school_id,
                            'timestamp_ts' => date('Y-m-d H:i:s'),
                            'log_by_type' => 'Admin',
                            'log_by' => $user_id
                        ]);

                    $pdf = PDF::loadView("web.finance.timesheet_pdf", ['itemList' => $itemList, 'companyDetail' => $companyDetail]);
                    $pdfName = 'Timesheet_' . $timesheet_id . '.pdf';
                    // return $pdf->stream($pdfName);
                    // Save the PDF to the server
                    $pdf->save(public_path('pdfs/timesheet/' . $pdfName));

                    DB::table('tbl_timesheet')
                        ->where('timesheet_id', $timesheet_id)
                        ->update([
                            'pdfLocation' => 'pdfs/timesheet/' . $pdfName,
                            'pdfName' => $pdfName
                        ]);

                    // DB::table('teacher_timesheet')
                    //     ->where('teacher_timesheet_id', $teacher_timesheet_id)
                    //     ->update([
                    //         'timesheet_status' => 1,
                    //         'timesheet_id' => $timesheet_id
                    //     ]);

                    foreach ($idsArr as $key => $id) {
                        DB::table('tbl_asnItem')
                            ->where('asnItem_id', $id)
                            ->update([
                                'timesheet_id' => $timesheet_id
                            ]);

                        DB::table('teacher_timesheet_item')
                            ->where('asnItem_id', $id)
                            ->update([
                                'admin_approve' => 1,
                                'approve_by' => $user_id,
                                'approve_by_type' => 'Admin',
                                'approve_by_dte' => date('Y-m-d H:i:s'),
                            ]);
                    }
                    $result['add'] = 'Yes';
                    $msg = $schoolDet->name_txt . '( Timesheet ID : ' . $timesheet_id . ' )';
                    array_push($messageArr, $msg);
                }
            }
            $result['message'] = implode(",", $messageArr);
            return $result;
        }
        return $result;
    }

    public function financeTimesheetReject(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $asnIds = $input['asnIds'];
            $weekStartDate = $input['weekStartDate'];
            $weekEndDate = $input['weekEndDate'];
            $asnIdsArr = explode(",", $asnIds);

            $itemList = DB::table('tbl_asn')
                ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('timesheet_id', NULL)
                ->where('status_int', 3)
                ->whereDate('asnDate_dte', '>=', $weekStartDate)
                ->whereDate('asnDate_dte', '<=', $weekEndDate)
                ->whereIn('tbl_asn.asn_id', $asnIdsArr)
                ->where('company_id', $company_id)
                ->where('admin_approve', '!=', 1)
                ->where('send_to_school', 0)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->pluck('tbl_asnItem.asnItem_id')
                ->toArray();

            // DB::table('tbl_asnItem')
            //     ->whereIn('asnItem_id', $itemList)
            //     ->update([
            //         'send_to_school' => 0,
            //         'admin_approve' => 2,
            //         'rejected_by_type' => 'Admin',
            //         'rejected_by' => $user_id,
            //         'rejected_text' => $request->remark
            //     ]);
            DB::table('tbl_asnItem')
                ->whereIn('asnItem_id', $itemList)
                ->delete();

            return true;
        }
        return true;
    }

    public function financeTimesheetDelete(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $asnIds = $input['asnIds'];
            $weekStartDate = $input['weekStartDate'];
            $weekEndDate = $input['weekEndDate'];
            $asnIdsArr = explode(",", $asnIds);

            $itemList = DB::table('tbl_asn')
                ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('timesheet_id', NULL)
                ->where('status_int', 3)
                ->whereDate('asnDate_dte', '>=', $weekStartDate)
                ->whereDate('asnDate_dte', '<=', $weekEndDate)
                ->whereIn('tbl_asn.asn_id', $asnIdsArr)
                ->where('company_id', $company_id)
                ->where('admin_approve', '!=', 1)
                ->where('send_to_school', 0)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->pluck('tbl_asnItem.asnItem_id')
                ->toArray();

            DB::table('tbl_asnItem')
                ->whereIn('asnItem_id', $itemList)
                ->delete();

            return true;
        }
        return true;
    }

    public function sendTimesheetToApproval(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        $rData['success'] = 'No';
        $rData['message'] = '';
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $asnId = $input['approveAsnId'];
            $asnIdsArr = explode(",", $asnId);
            $weekStartDate = $input['weekStartDate'];
            $weekEndDate = $input['weekEndDate'];
            $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
            $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
            $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
            $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));

            // admin approve
            $itemList1 = DB::table('tbl_asn')
                ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('timesheet_id', NULL)
                ->where('status_int', 3)
                ->whereDate('asnDate_dte', '>=', $weekStartDate)
                ->whereDate('asnDate_dte', '<=', $weekEndDate)
                ->whereIn('tbl_asn.asn_id', $asnIdsArr)
                ->where('company_id', $company_id)
                ->where('admin_approve', '!=', 1)
                // ->where('send_to_school', 0)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->pluck('tbl_asnItem.asnItem_id')
                ->toArray();

            DB::table('tbl_asnItem')
                ->whereIn('asnItem_id', $itemList1)
                ->update([
                    'admin_approve' => 1
                ]);

            $idsList = DB::table('tbl_asn')
                ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->select('tbl_asn.school_id', 'tbl_asnItem.asnItem_id')
                ->where('timesheet_id', NULL)
                ->where('status_int', 3)
                ->whereDate('asnDate_dte', '>=', $weekStartDate)
                ->whereDate('asnDate_dte', '<=', $weekEndDate)
                ->whereIn('tbl_asn.asn_id', $asnIdsArr)
                ->where('company_id', $company_id)
                ->where('admin_approve', 1)
                // ->where('send_to_school', 0)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->get();

            $result_array = [];
            foreach ($idsList as $ids) {
                if (!isset($result_array[$ids->school_id])) {
                    $result_array[$ids->school_id] = array();
                }
                array_push($result_array[$ids->school_id], $ids->asnItem_id);
            }

            // echo "<pre>";
            // print_r($result_array);
            // exit;
            $notMailSchoolName = '';
            foreach ($result_array as $key => $value) {
                DB::table('tbl_asnItem')
                    ->whereIn('asnItem_id', $value)
                    ->update([
                        'send_to_school' => 1
                    ]);

                $schoolDet = DB::table('tbl_school')
                    ->select('tbl_school.school_id', 'tbl_school.name_txt')
                    ->where('tbl_school.school_id', $key)
                    ->first();

                if (count($value) > 0 && $schoolDet) {
                    $itemList = DB::table('tbl_asn')
                        ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                        ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                        ->LeftJoin('tbl_asnItem as tbl_asnItem1', function ($join) use ($weekStartDate, $value) {
                            $join->on('tbl_asnItem1.asn_id', '=', 'tbl_asn.asn_id')
                                ->where(function ($query) use ($weekStartDate, $value) {
                                    $query->where('tbl_asnItem1.timesheet_id', NULL)
                                        ->where('tbl_asnItem1.asnDate_dte', '=', $weekStartDate);
                                });
                        })
                        ->LeftJoin('tbl_asnItem as tbl_asnItem2', function ($join) use ($weekStartDate2, $value) {
                            $join->on('tbl_asnItem2.asn_id', '=', 'tbl_asn.asn_id')
                                ->where(function ($query) use ($weekStartDate2, $value) {
                                    $query->where('tbl_asnItem2.timesheet_id', NULL)
                                        ->where('tbl_asnItem2.asnDate_dte', '=', $weekStartDate2);
                                });
                        })
                        ->LeftJoin('tbl_asnItem as tbl_asnItem3', function ($join) use ($weekStartDate3, $value) {
                            $join->on('tbl_asnItem3.asn_id', '=', 'tbl_asn.asn_id')
                                ->where(function ($query) use ($weekStartDate3, $value) {
                                    $query->where('tbl_asnItem3.timesheet_id', NULL)
                                        ->where('tbl_asnItem3.asnDate_dte', '=', $weekStartDate3);
                                });
                        })
                        ->LeftJoin('tbl_asnItem as tbl_asnItem4', function ($join) use ($weekStartDate4, $value) {
                            $join->on('tbl_asnItem4.asn_id', '=', 'tbl_asn.asn_id')
                                ->where(function ($query) use ($weekStartDate4, $value) {
                                    $query->where('tbl_asnItem4.timesheet_id', NULL)
                                        ->where('tbl_asnItem4.asnDate_dte', '=', $weekStartDate4);
                                });
                        })
                        ->LeftJoin('tbl_asnItem as tbl_asnItem5', function ($join) use ($weekStartDate5, $value) {
                            $join->on('tbl_asnItem5.asn_id', '=', 'tbl_asn.asn_id')
                                ->where(function ($query) use ($weekStartDate5, $value) {
                                    $query->where('tbl_asnItem5.timesheet_id', NULL)
                                        ->where('tbl_asnItem5.asnDate_dte', '=', $weekStartDate5);
                                });
                        })
                        ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), DB::raw("0 AS reject_status"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem1.start_tm AS start_tm1', 'tbl_asnItem1.end_tm AS end_tm1', 'tbl_asnItem1.lunch_time AS lunch_time1', 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem2.start_tm AS start_tm2', 'tbl_asnItem2.end_tm AS end_tm2', 'tbl_asnItem2.lunch_time AS lunch_time2', 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem3.start_tm AS start_tm3', 'tbl_asnItem3.end_tm AS end_tm3', 'tbl_asnItem3.lunch_time AS lunch_time3', 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem4.start_tm AS start_tm4', 'tbl_asnItem4.end_tm AS end_tm4', 'tbl_asnItem4.lunch_time AS lunch_time4', 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"), 'tbl_asnItem5.start_tm AS start_tm5', 'tbl_asnItem5.end_tm AS end_tm5', 'tbl_asnItem5.lunch_time AS lunch_time5')
                        ->whereIn('tbl_asn.asn_id', function ($query) use ($value) {
                            $query->select('tbl_asn.asn_id')
                                ->from('tbl_asn')
                                ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                                ->whereIn('tbl_asnItem.asnItem_id', $value)
                                ->groupBy('tbl_asn.asn_id')
                                ->get();
                        })
                        ->groupBy('tbl_asn.asn_id')
                        ->get();

                    // echo "<pre>";
                    // print_r($itemList);
                    // exit;

                    $contactDet = DB::table('tbl_schoolContact')
                        ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                        ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                        ->where('tbl_schoolContact.isCurrent_status', '-1')
                        ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                        // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                        ->where('tbl_contactItemSch.type_int', 1)
                        ->where('tbl_schoolContact.school_id', $schoolDet->school_id)
                        ->get();

                    $companyDetail = DB::table('company')
                        ->select('company.*')
                        ->where('company.company_id', $company_id)
                        ->first();

                    $mailArr = array();
                    foreach ($contactDet as $mKey => $mValue) {
                        array_push($mailArr, $mValue->contactItem_txt);
                    }
                    if (count($mailArr) > 0) {
                        foreach ($contactDet as $mKey2 => $mValue2) {
                            if ($mValue2->contactItem_txt) {
                                $mailData['asnIds'] = $asnId;
                                $mailData['companyDetail'] = $companyDetail;
                                $mailData['weekStartDate'] = $weekStartDate;
                                $mailData['weekEndDate'] = $weekEndDate;
                                $mailData['contactDet'] = $mValue2;
                                $mailData['itemList'] = $itemList;
                                $mailData['mail'] = $mValue2->contactItem_txt;
                                $myVar = new AlertController();
                                $myVar->sendToSchoolApproval($mailData);
                            }
                        }
                    } else {
                        if ($notMailSchoolName != '') {
                            $notMailSchoolName .= ', ';
                        }
                        $notMailSchoolName .= $schoolDet->name_txt;
                    }
                }
            }

            if ($notMailSchoolName) {
                $rData['success'] = 'Yes';
                $rData['message'] = "Please update the contact email for the following school(s) - " . $notMailSchoolName;
            }

            return $rData;
        }
        return $rData;
    }

    public function sendLogTimesheetToSchool(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $asnId = $input['asnItemIds'];
            $schoolId = $input['schoolId'];
            $asnIdsArr = explode(",", $asnId);

            $teacherList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('tbl_student', 'tbl_asn.student_id', '=', 'tbl_student.student_id')
                ->select('asnItem_id', 'tbl_asn.teacher_id', 'tbl_asn.asn_id', 'tbl_asn.school_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), DB::raw("IF(tbl_asn.student_id IS NOT NULL, CONCAT(tbl_student.firstname_txt, ' ', tbl_student.surname_txt), '') AS studentName_txt"), 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', 'tbl_asnItem.admin_approve', 'tbl_asnItem.send_to_school', 'tbl_asnItem.rejected_text', 'tbl_asnItem.lunch_time')
                ->whereIn('tbl_asnItem.asnItem_id', $asnIdsArr)
                ->groupBy('tbl_asn.teacher_id', 'asnItem_id', 'asnDate_dte')
                ->orderBy('tbl_asn.teacher_id', 'ASC')
                ->orderBy('tbl_asnItem.asnDate_dte', 'DESC')
                ->get();

            $contactDet = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $schoolId)
                ->get();
            $mailArr = array();
            foreach ($contactDet as $mKey => $mValue) {
                array_push($mailArr, $mValue->contactItem_txt);
            }

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
            if (count($teacherList) > 0 && count($contactDet) > 0) {
                DB::table('tbl_asnItem')
                    ->whereIn('tbl_asnItem.asnItem_id', $asnIdsArr)
                    ->update([
                        'send_to_school' => 1
                    ]);

                foreach ($contactDet as $mKey2 => $mValue2) {
                    if ($mValue2->contactItem_txt) {
                        $mailData['asnIds'] = $asnId;
                        $mailData['companyDetail'] = $companyDetail;
                        $mailData['schoolId'] = $schoolId;
                        $mailData['contactDet'] = $mValue2;
                        $mailData['teacherList'] = $teacherList;
                        $mailData['mail'] = $mValue2->contactItem_txt;
                        $myVar = new AlertController();
                        $myVar->sendToSchoolTimeSheet($mailData);
                    }
                }
            }

            return true;
        }
        return true;
    }

    public function teacherTimesheetReject(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $asnId = $input['asnItemIds'];
            $schoolId = $input['schoolId'];
            $asnIdsArr = explode(",", $asnId);

            // DB::table('tbl_asnItem')
            //     ->whereIn('asnItem_id', $asnIdsArr)
            //     ->update([
            //         'send_to_school' => 0,
            //         'admin_approve' => 2,
            //         'rejected_by_type' => 'Admin',
            //         'rejected_by' => $user_id,
            //         'rejected_text' => $request->remark
            //     ]);
            DB::table('tbl_asnItem')
                ->whereIn('asnItem_id', $asnIdsArr)
                ->delete();

            return true;
        }
        return true;
    }

    public function sendteacherItemSheetToApproval(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $asnId = $input['asnItemIds'];
            $schoolId = $input['schoolId'];
            $asnIdsArr = explode(",", $asnId);

            $teacherList = DB::table('teacher_timesheet')
                ->join('teacher_timesheet_item', 'teacher_timesheet.teacher_timesheet_id', '=', 'teacher_timesheet_item.teacher_timesheet_id')
                ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('teacher_timesheet.*', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'teacher_timesheet_item.start_tm as t_start_tm', 'teacher_timesheet_item.end_tm as t_end_tm', 'teacher_timesheet_item.timesheet_item_id', 'teacher_timesheet_item.asn_id as t_asn_id', 'teacher_timesheet_item.asnItem_id as t_asnItem_id', 'teacher_timesheet_item.school_id as t_school_id', 'teacher_timesheet_item.teacher_id as t_teacher_id', 'teacher_timesheet_item.admin_approve as t_admin_approve', 'teacher_timesheet_item.send_to_school as t_send_to_school', 'teacher_timesheet_item.rejected_by_type as t_rejected_by_type', 'teacher_timesheet_item.rejected_by as t_rejected_by', 'teacher_timesheet_item.rejected_text as t_rejected_text', 'teacher_timesheet_item.lunch_time as t_lunch_time')
                ->whereIn('teacher_timesheet_item.timesheet_item_id', $asnIdsArr)
                ->groupBy('teacher_timesheet.teacher_id', 'teacher_timesheet_item.asnDate_dte')
                ->orderBy('teacher_timesheet.teacher_id', 'ASC')
                ->orderBy('teacher_timesheet_item.asnDate_dte', 'DESC')
                ->get();

            $contactDet = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $schoolId)
                ->get();

            $mailArr = array();
            foreach ($contactDet as $mKey => $mValue) {
                array_push($mailArr, $mValue->contactItem_txt);
            }

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
            if (count($teacherList) > 0 && count($contactDet) > 0) {
                DB::table('teacher_timesheet_item')
                    ->whereIn('timesheet_item_id', $asnIdsArr)
                    ->update([
                        'send_to_school' => 1
                    ]);

                foreach ($contactDet as $mKey2 => $mValue2) {
                    if ($mValue2->contactItem_txt) {
                        $mailData['asnIds'] = $asnId;
                        $mailData['companyDetail'] = $companyDetail;
                        $mailData['schoolId'] = $schoolId;
                        $mailData['contactDet'] = $mValue2;
                        $mailData['teacherList'] = $teacherList;
                        $mailData['mail'] = $mValue2->contactItem_txt;
                        $myVar = new AlertController();
                        $myVar->sendToSchoolTeacherItemSheet($mailData);
                    }
                }
            }

            return true;
        }
        return true;
    }

    public function teacherItemSheetReject(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $asnId = $input['asnItemIds'];
            $schoolId = $input['schoolId'];
            $asnIdsArr = explode(",", $asnId);

            DB::table('teacher_timesheet_item')
                ->whereIn('timesheet_item_id', $asnIdsArr)
                ->update([
                    'admin_approve' => 2,
                    'rejected_by_type' => 'Admin',
                    'rejected_by' => $user_id,
                    'rejected_text' => $request->remark
                ]);

            return true;
        }
        return true;
    }

    public function teacherItemSheetDelete(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $asnId = $input['asnItemIds'];
            $schoolId = $input['schoolId'];
            $asnIdsArr = explode(",", $asnId);

            DB::table('teacher_timesheet_item')
                ->whereIn('timesheet_item_id', $asnIdsArr)
                ->delete();

            return true;
        }
        return true;
    }

    public function timesheetAsnItemLog(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        $result['add'] = 'No';
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $asnIdStr = $request->approveAsnId;
            $asnIdStr = $request->approveAsnId;
            $weekStartDate = $request->weekStartDate;
            $weekEndDate = $request->weekEndDate;
            $asnIdsArr = explode(",", $asnIdStr);

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            $messageArr = array();
            foreach ($asnIdsArr as $key => $asnId) {
                $schoolDet = DB::table('tbl_asn')
                    ->select('tbl_asn.school_id', 'tbl_school.name_txt')
                    ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                    ->where('tbl_asn.asn_id', $asnId)
                    ->first();

                $idsArr = DB::table('tbl_asn')
                    ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                    ->where('timesheet_id', NULL)
                    ->where('status_int', 3)
                    ->whereDate('asnDate_dte', '>=', $weekStartDate)
                    ->whereDate('asnDate_dte', '<=', $weekEndDate)
                    ->where('tbl_asn.asn_id', $asnId)
                    ->where('company_id', $company_id)
                    ->where('admin_approve', 1)
                    ->where('send_to_school', 0)
                    ->groupBy('tbl_asnItem.asnItem_id')
                    ->pluck('tbl_asnItem.asnItem_id')
                    ->toArray();

                if (count($idsArr) > 0 && $schoolDet) {
                    $itemList = DB::table('tbl_asnItem')
                        ->LeftJoin('tbl_asn', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                        ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                        ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                        ->select('tbl_asnItem.asnItem_id', 'tbl_asnItem.asn_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm')
                        ->whereIn('tbl_asnItem.asnItem_id', $idsArr)
                        ->groupBy('tbl_asnItem.asnItem_id')
                        ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                        ->get();

                    $timesheet_id = DB::table('tbl_timesheet')
                        ->insertGetId([
                            'school_id' => $schoolDet->school_id,
                            'timestamp_ts' => date('Y-m-d H:i:s'),
                            'log_by_type' => 'Admin',
                            'log_by' => $user_id
                        ]);

                    $pdf = PDF::loadView("web.finance.timesheet_pdf", ['itemList' => $itemList, 'companyDetail' => $companyDetail]);
                    $pdfName = 'Timesheet_' . $timesheet_id . '.pdf';
                    // return $pdf->stream($pdfName);
                    // Save the PDF to the server
                    $pdf->save(public_path('pdfs/timesheet/' . $pdfName));

                    DB::table('tbl_timesheet')
                        ->where('timesheet_id', $timesheet_id)
                        ->update([
                            'pdfLocation' => 'pdfs/timesheet/' . $pdfName,
                            'pdfName' => $pdfName
                        ]);

                    // DB::table('teacher_timesheet')
                    //     ->where('teacher_timesheet_id', $teacher_timesheet_id)
                    //     ->update([
                    //         'timesheet_status' => 1,
                    //         'timesheet_id' => $timesheet_id
                    //     ]);

                    foreach ($idsArr as $key => $id) {
                        DB::table('tbl_asnItem')
                            ->where('asnItem_id', $id)
                            ->update([
                                'timesheet_id' => $timesheet_id
                            ]);
                    }
                    $result['add'] = 'Yes';
                    $msg = $schoolDet->name_txt . '( Timesheet ID : ' . $timesheet_id . ' )';
                    array_push($messageArr, $msg);
                }
            }
            $result['message'] = implode(",", $messageArr);
            return $result;
        }
        return $result;
    }

    public function timesheetAsnItemLogNew(Request $request)
    {
        $asnItemIds = $request->asnItemIds;
        // $docStartDate = $request->docStartDate;
        // $docEndDate = $request->docEndDate;
        $schoolId = $request->schoolId;
        $idsArr = explode(",", $asnItemIds);
        $result['add'] = 'No';
        $schoolDet = DB::table('tbl_school')
            ->where('school_id', $schoolId)
            ->first();

        $webUserLoginData = Session::get('webUserLoginData');
        $companyDetail = array();
        $user_id = '';
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
        }

        if (count($idsArr) > 0) {
            $itemList = DB::table('tbl_asnItem')
                ->LeftJoin('tbl_asn', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('tbl_asnItem.asnItem_id', 'tbl_asnItem.asn_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm')
                ->whereIn('tbl_asnItem.asnItem_id', $idsArr)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                ->get();

            $timesheet_id = DB::table('tbl_timesheet')
                ->insertGetId([
                    'school_id' => $schoolId,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            $pdf = PDF::loadView("web.finance.timesheet_pdf", ['itemList' => $itemList, 'companyDetail' => $companyDetail]);
            $pdfName = 'Timesheet_' . $timesheet_id . '.pdf';
            // return $pdf->stream($pdfName);
            // Save the PDF to the server
            $pdf->save(public_path('pdfs/timesheet/' . $pdfName));

            DB::table('tbl_timesheet')
                ->where('timesheet_id', $timesheet_id)
                ->update([
                    'pdfLocation' => 'pdfs/timesheet/' . $pdfName,
                    'pdfName' => $pdfName
                ]);

            foreach ($idsArr as $key => $id) {
                DB::table('tbl_asnItem')
                    ->where('asnItem_id', $id)
                    ->update([
                        'admin_approve' => 1,
                        'timesheet_id' => $timesheet_id
                    ]);

                DB::table('teacher_timesheet_item')
                    ->where('asnItem_id', $id)
                    ->update([
                        'admin_approve' => 1,
                        'approve_by' => $user_id,
                        'approve_by_type' => 'Admin',
                        'approve_by_dte' => date('Y-m-d H:i:s'),
                    ]);
            }
            $result['add'] = 'Yes';
            $result['timesheet_id'] = $timesheet_id;
            $result['schoolName'] = $schoolDet ? $schoolDet->name_txt : '';
            return $result;
        }
        return $result;
    }

    public function teacherItemSheetApprove(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        $user_id = 0;
        $companyDetail = array();
        if ($webUserLoginData) {
            $user_id = $webUserLoginData->user_id;

            $company_id = $webUserLoginData->company_id;
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
        }
        $asnItemIds = $request->asnItemIds;
        $schoolId = $request->schoolId;
        $itemIdsArr = explode(",", $asnItemIds);
        $idsArr = array();
        foreach ($itemIdsArr as $key => $value) {
            $tDet = DB::table('teacher_timesheet_item')
                ->where('timesheet_item_id', $value)
                ->first();

            if ($tDet) {
                $asnDet = DB::table('tbl_asn')
                    ->where('asn_id', $tDet->asn_id)
                    ->first();
                $eventItemDetail = DB::table('tbl_asnItem')
                    ->LeftJoin('tbl_asn', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                    ->where('tbl_asnItem.asn_id', $tDet->asn_id)
                    ->whereDate('tbl_asnItem.asnDate_dte', $tDet->asnDate_dte)
                    ->where('tbl_asn.school_id', $tDet->school_id)
                    ->where('tbl_asn.teacher_id', $tDet->teacher_id)
                    ->first();
                if ($eventItemDetail) {
                    $asnItem_id = $eventItemDetail->asnItem_id;
                    DB::table('tbl_asnItem')
                        ->where('asnItem_id', $eventItemDetail->asnItem_id)
                        ->update([
                            'dayPart_int' => $tDet->dayPart_int,
                            'dayPercent_dec' => $tDet->dayPercent_dec,
                            'hours_dec' => $tDet->hours_dec,
                            'start_tm' => $tDet->start_tm,
                            'end_tm' => $tDet->end_tm,
                        ]);
                } else {
                    $asnItem_id = DB::table('tbl_asnItem')
                        ->insertGetId([
                            'asn_id' => $tDet->asn_id,
                            'asnDate_dte' => $tDet->asnDate_dte,
                            'dayPart_int' => $tDet->dayPart_int,
                            'dayPercent_dec' => $tDet->dayPercent_dec,
                            'hours_dec' => $tDet->hours_dec,
                            'start_tm' => $tDet->start_tm,
                            'end_tm' => $tDet->end_tm,
                            'charge_dec' => $asnDet->charge_dec,
                            'cost_dec' => $asnDet->cost_dec,
                            'timestamp_ts' => date('Y-m-d H:i:s')
                        ]);
                }
                array_push($idsArr, $asnItem_id);

                DB::table('teacher_timesheet_item')
                    ->where('timesheet_item_id', $tDet->timesheet_item_id)
                    ->update([
                        'asnItem_id' => $asnItem_id,
                        'admin_approve' => 1,
                        'approve_by' => $user_id,
                        'approve_by_type' => 'Admin',
                        'approve_by_dte' => date('Y-m-d H:i:s'),
                    ]);
            }
        }

        DB::table('tbl_asnItem')
            ->whereIn('asnItem_id', $idsArr)
            ->update([
                'admin_approve' => 1
            ]);

        $result['add'] = 'No';
        $schoolDet = DB::table('tbl_school')
            ->where('school_id', $schoolId)
            ->first();

        if (count($idsArr) > 0) {
            $itemList = DB::table('tbl_asnItem')
                ->LeftJoin('tbl_asn', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('tbl_asnItem.asnItem_id', 'tbl_asnItem.asn_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm')
                ->whereIn('tbl_asnItem.asnItem_id', $idsArr)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                ->get();

            $timesheet_id = DB::table('tbl_timesheet')
                ->insertGetId([
                    'school_id' => $schoolId,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            $pdf = PDF::loadView("web.finance.timesheet_pdf", ['itemList' => $itemList, 'companyDetail' => $companyDetail]);
            $pdfName = 'Timesheet_' . $timesheet_id . '.pdf';
            // return $pdf->stream($pdfName);
            // Save the PDF to the server
            $pdf->save(public_path('pdfs/timesheet/' . $pdfName));

            DB::table('tbl_timesheet')
                ->where('timesheet_id', $timesheet_id)
                ->update([
                    'pdfLocation' => 'pdfs/timesheet/' . $pdfName,
                    'pdfName' => $pdfName
                ]);

            foreach ($idsArr as $key => $id) {
                DB::table('tbl_asnItem')
                    ->where('asnItem_id', $id)
                    ->update([
                        'admin_approve' => 1,
                        'timesheet_id' => $timesheet_id
                    ]);
            }
            $result['add'] = 'Yes';
            $result['timesheet_id'] = $timesheet_id;
            $result['schoolName'] = $schoolDet ? $schoolDet->name_txt : '';
            return $result;
        }
        return $result;
    }

    public function fetchTeacherById(Request $request)
    {
        $input = $request->all();
        $max_date = $input['max_date'];
        $weekStartDate = Carbon::parse($max_date)->startOfWeek()->format('Y-m-d');
        $weekEndDate = Carbon::parse($max_date)->endOfWeek()->format('Y-m-d');
        $school_id = $input['school_id'];

        $teacherList = DB::table('tbl_asn')
            ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
            ->LeftJoin('tbl_student', 'tbl_asn.student_id', '=', 'tbl_student.student_id')
            ->select('asnItem_id', 'tbl_asn.teacher_id', 'tbl_asn.asn_id', 'tbl_asn.school_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), DB::raw("IF(tbl_asn.student_id IS NOT NULL, CONCAT(tbl_student.firstname_txt, ' ', tbl_student.surname_txt), '') AS studentName_txt"), 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', 'tbl_asnItem.admin_approve', 'tbl_asnItem.send_to_school', 'tbl_asnItem.rejected_text', 'tbl_asnItem.lunch_time')
            ->where('timesheet_id', NULL)
            ->where('status_int', 3)
            ->whereDate('asnDate_dte', '<', $weekStartDate)
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

                $startTime = '';
                if ($teacher->start_tm) {
                    $startTime = date("h:i a", strtotime($teacher->start_tm));
                }
                $endTime = '';
                if ($teacher->end_tm) {
                    $endTime = date("h:i a", strtotime($teacher->end_tm));
                }

                $rejectText = '';
                if ($teacher->rejected_text) {
                    $rejectText = '( ' . $teacher->rejected_text . ' )';
                }

                if ($teacher->admin_approve == 2) {
                    $tStatus = "Rejected" . $rejectText;
                } else if ($teacher->send_to_school == 1) {
                    $tStatus = "Sent to School";
                } else {
                    $tStatus = "--";
                }

                $lunch_time = '';
                if ($teacher->lunch_time) {
                    $lunch_time = '( ' . $teacher->lunch_time . ' )';
                }

                $html .= "<tr class='school-detail-table-data selectTeacherRow' id='selectTeacherRow$teacher->asnItem_id' teacher-id='$teacher->teacher_id' asn-id='$teacher->asn_id' asnitem-id='$teacher->asnItem_id' school-id='$teacher->school_id'>
                    <td>$name</td>
                    <td>$teacher->asnDate_dte</td>
                    <td>$teacher->datePart_txt $lunch_time</td>
                    <td>$teacher->start_tm</td>
                    <td>$teacher->end_tm</td>
                    <td>$tStatus</td>
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
                ->whereIn('tbl_description.description_int', [1, 4])
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

        if ($request->hours_dec) {
            $dayPercent_dec = intval(($request->hours_dec / 6) * 100) / 100;
        } else {
            $dayPercent_dec = $request->dayPercent_dec;
        }

        DB::table('tbl_asnItem')
            ->where('asnItem_id', $editEventId)
            ->update([
                'dayPart_int' => $request->dayPart_int,
                'asnDate_dte' => date("Y-m-d", strtotime($request->asnDate_dte)),
                'charge_dec' => $request->charge_dec,
                'dayPercent_dec' => $dayPercent_dec,
                'hours_dec' => $request->hours_dec,
                'start_tm' => $request->start_tm,
                'end_tm' => $request->end_tm,
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

    public function fetchTeacherSheetByIdNew(Request $request)
    {
        $input = $request->all();
        $max_date = $input['max_date'];
        $weekStartDate = Carbon::parse($max_date)->startOfWeek()->format('Y-m-d');
        $weekEndDate = Carbon::parse($max_date)->endOfWeek()->format('Y-m-d');
        $school_id = $input['school_id'];

        $teacherList = DB::table('teacher_timesheet')
            ->join('teacher_timesheet_item', 'teacher_timesheet.teacher_timesheet_id', '=', 'teacher_timesheet_item.teacher_timesheet_id')
            ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
            ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
            ->select('teacher_timesheet.*', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'teacher_timesheet_item.start_tm as t_start_tm', 'teacher_timesheet_item.end_tm as t_end_tm', 'teacher_timesheet_item.timesheet_item_id', 'teacher_timesheet_item.asn_id as t_asn_id', 'teacher_timesheet_item.asnItem_id as t_asnItem_id', 'teacher_timesheet_item.school_id as t_school_id', 'teacher_timesheet_item.teacher_id as t_teacher_id', 'teacher_timesheet_item.admin_approve as t_admin_approve', 'teacher_timesheet_item.send_to_school as t_send_to_school', 'teacher_timesheet_item.rejected_by_type as t_rejected_by_type', 'teacher_timesheet_item.rejected_by as t_rejected_by', 'teacher_timesheet_item.rejected_text as t_rejected_text', 'teacher_timesheet_item.lunch_time as t_lunch_time')
            ->where('teacher_timesheet.submit_status', 1)
            ->whereDate('teacher_timesheet_item.asnDate_dte', '<=', $weekEndDate)
            ->where('teacher_timesheet_item.school_id', $school_id)
            ->where('teacher_timesheet_item.admin_approve', '!=', 1)
            ->groupBy('teacher_timesheet.teacher_id', 'teacher_timesheet_item.asnDate_dte')
            ->orderBy('teacher_timesheet.teacher_id', 'ASC')
            ->orderByRaw("FIELD(DATE_FORMAT(teacher_timesheet_item.asnDate_dte, '%a'), 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun') ASC")
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

                // $startTime = '';
                // if ($teacher->t_start_tm) {
                //     $startTime = date("h:i a", strtotime($teacher->t_start_tm));
                // }
                // $endTime = '';
                // if ($teacher->t_end_tm) {
                //     $endTime = date("h:i a", strtotime($teacher->t_end_tm));
                // }
                $rejectText = '';
                if ($teacher->t_rejected_text) {
                    $rejectText = '( ' . $teacher->t_rejected_text . ' )';
                }

                if ($teacher->t_admin_approve == 2) {
                    $tStatus = "Rejected" . $rejectText;
                } else if ($teacher->t_send_to_school == 1) {
                    $tStatus = "Sent to School";
                } else {
                    $tStatus = "--";
                }

                $lunch_time = '';
                if ($teacher->t_lunch_time) {
                    $lunch_time = '( ' . $teacher->t_lunch_time . ' )';
                }

                $html .= "<tr class='school-detail-table-data selectLogTeacherRow' id='selectLogTeacherRow$teacher->timesheet_item_id' teacher-id='$teacher->t_teacher_id' asn-id='$teacher->t_asn_id' timesheet-item-id='$teacher->timesheet_item_id' school-id='$teacher->t_school_id'>
                    <td>$name</td>
                    <td>$teacher->asnDate_dte</td>
                    <td>$teacher->t_start_tm - $teacher->t_end_tm $lunch_time</td>
                    <td>$tStatus</td>
                </tr>";
            }
        }

        return response()->json(['html' => $html]);
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
            $todayDate = date('Y-m-d');
            $p_maxDate = Carbon::parse($todayDate)->endOfWeek()->format('Y-m-d');
            if ($request->date) {
                $p_maxDate = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));
            }
            // echo $p_maxDate;
            // exit;
            $invoiceFromDate = '';
            if ($request->invoiceFromDate) {
                $invoiceFromDate = date('Y-m-d', strtotime(str_replace('/', '-', $request->invoiceFromDate)));
            }
            $invoiceToDate = '';
            if ($request->invoiceToDate) {
                $invoiceToDate = date('Y-m-d', strtotime(str_replace('/', '-', $request->invoiceToDate)));
            }

            $p_invoiceNumberMin = '';
            if ($request->invoiceNumberMin) {
                $p_invoiceNumberMin = $request->invoiceNumberMin;
            }
            $p_invoiceNumberMax = '';
            if ($request->invoiceNumberMax) {
                $p_invoiceNumberMax = $request->invoiceNumberMax;
            }

            $showSent = 'false';
            if ($request->showSent) {
                $showSent = $request->showSent;
            }

            DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->whereRaw("tbl_asnItem.timesheet_id IS NOT NULL AND (tbl_asnItem.charge_dec IS NULL OR tbl_asnItem.cost_dec IS NULL)")
                ->update([
                    'tbl_asnItem.charge_dec' => DB::raw("tbl_asn.charge_dec"),
                    'tbl_asnItem.cost_dec' => DB::raw("tbl_asn.cost_dec")
                ]);

            $timesheetList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('asnItem_id', 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'asnDate_dte', 'tbl_asnItem.charge_dec', 'tbl_asnItem.cost_dec', DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"))
                ->where('timesheet_id', '!=', NULL)
                ->where('tbl_asnItem.invoice_id', '=', NULL)
                ->whereDate('asnDate_dte', '<=', $p_maxDate)
                ->groupBy('asnItem_id')
                ->orderByRaw('school_id,teacher_id,asnDate_dte')
                ->get();

            $invoices = DB::table('tbl_school')
                ->join('tbl_invoice', 'tbl_school.school_id', '=', 'tbl_invoice.school_id')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->leftJoin(
                    DB::raw("(SELECT tbl_contactItemSch.school_id, contactItem_txt AS invoiceEmail_txt FROM tbl_contactItemSch LEFT JOIN tbl_schoolContact ON tbl_schoolContact.contact_id = tbl_contactItemSch.schoolContact_id WHERE receiveInvoices_status <> 0 AND (tbl_schoolContact.isCurrent_status = -1 OR tbl_contactItemSch.schoolContact_id IS NULL) GROUP BY tbl_contactItemSch.school_id) AS t_email"),
                    function ($join) {
                        $join->on('tbl_school.school_id', '=', 't_email.school_id');
                    }
                )
                ->select('tbl_invoice.invoice_id', 'tbl_invoice.invoiceDate_dte', 'tbl_invoice.sentMailBy', 'tbl_invoice.sentMailDate', 'tbl_invoice.paidOn_dte', 'tbl_school.school_id', 'tbl_school.name_txt', DB::raw("CAST(SUM((numItems_dec * charge_dec * ((100 + vatRate_dec) / 100))) AS DECIMAL(7, 2)) AS gross_dec"), DB::raw("CAST(SUM(numItems_dec * charge_dec) AS DECIMAL(7, 2)) AS net_dec"), DB::raw("SUM(numItems_dec) AS days_dec"), DB::raw("COUNT(DISTINCT tbl_invoiceItem.teacher_id) AS teachers_int"), DB::raw("IF(invoiceEmail_txt IS NOT NULL, 'Y', 'N') AS hasEmail_status"), DB::raw("IF(tbl_invoice.factored_status <> 0, 'Y', 'N') AS factored_status"), 'invoiceEmail_txt', 'sentOn_dte');

            if ($showSent == 'true') {
                $invoices->where('tbl_invoice.sentMailDate', '!=', NULL);
            } else {
                $invoices->where('tbl_invoice.sentMailDate', NULL);
            }

            if ($p_invoiceNumberMin && $p_invoiceNumberMax) {
                $invoices->whereBetween('tbl_invoice.invoice_id', array($p_invoiceNumberMin, $p_invoiceNumberMax));
            } else {
                $invoices->limit(100);
            }

            if ($invoiceFromDate) {
                $invoices->whereDate('tbl_invoice.invoiceDate_dte', '>=', $invoiceFromDate);
            } else {
                $invoices->limit(100);
            }
            if ($invoiceToDate) {
                $invoices->whereDate('tbl_invoice.invoiceDate_dte', '<=', $invoiceToDate);
            } else {
                $invoices->limit(100);
            }

            $invoiceList = $invoices->where('tbl_invoice.invoice_id', '!=', null)
                ->groupBy('tbl_invoice.invoice_id')
                ->orderBy('tbl_invoice.invoice_id', 'DESC')
                ->orderBy('invoiceDate_dte', 'DESC')
                ->orderByRaw('SUM(numItems_dec * charge_dec)')
                ->get();

            $templateDet = DB::table('mail_template')
                ->where('mail_template_id', '=', 1)
                ->first();

            return view("web.finance.finance_invoice", ['title' => $title, 'headerTitle' => $headerTitle, 'timesheetList' => $timesheetList, 'p_maxDate' => $p_maxDate, 'p_invoiceNumberMin' => $p_invoiceNumberMin, 'p_invoiceNumberMax' => $p_invoiceNumberMax, 'invoiceList' => $invoiceList, 'templateDet' => $templateDet]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function timesheetEventEdit(Request $request)
    {
        $result['exist'] = "No";
        $asnItemId = $request->asnItemId;
        $eventItemDetail = DB::table('tbl_asnItem')
            ->where('tbl_asnItem.asnItem_id', $asnItemId)
            ->first();

        if ($eventItemDetail) {
            $dayPartList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 20)
                ->whereIn('tbl_description.description_int', [1, 4])
                ->get();

            $view = view("web.finance.invoice_event_edit", ['eventItemDetail' => $eventItemDetail, 'dayPartList' => $dayPartList])->render();
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

    public function timesheetEventUpdateAjax(Request $request)
    {
        $editEventId = $request->editEventId;

        if ($request->hours_dec) {
            $dayPercent_dec = intval(($request->hours_dec / 6) * 100) / 100;
        } else {
            $dayPercent_dec = $request->dayPercent_dec;
        }

        DB::table('tbl_asnItem')
            ->where('asnItem_id', $editEventId)
            ->update([
                'dayPart_int' => $request->dayPart_int,
                'asnDate_dte' => date("Y-m-d", strtotime(str_replace('/', '-', $request->asnDate_dte))),
                'charge_dec' => $request->charge_dec,
                'dayPercent_dec' => $dayPercent_dec,
                'hours_dec' => $request->hours_dec,
                'cost_dec' => $request->cost_dec
            ]);

        $p_maxDate = $request->p_maxDate;

        $timesheetList = DB::table('tbl_asn')
            ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
            ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
            ->select('asnItem_id', 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'asnDate_dte', 'tbl_asnItem.charge_dec', 'tbl_asnItem.cost_dec')
            ->where('timesheet_id', '!=', NULL)
            ->where('tbl_asnItem.invoice_id', '=', NULL)
            ->whereDate('asnDate_dte', '<=', $p_maxDate)
            ->groupBy('asnItem_id')
            ->orderByRaw('school_id,teacher_id,asnDate_dte')
            ->get();

        $html = '';
        if (count($timesheetList) > 0) {
            foreach ($timesheetList as $key1 => $timesheet) {
                $name = '';
                if ($timesheet->knownAs_txt == null && $timesheet->knownAs_txt == '') {
                    $name = $timesheet->firstName_txt . ' ' . $timesheet->surname_txt;
                } else {
                    $name = $timesheet->knownAs_txt . ' ' . $timesheet->surname_txt;
                }
                $date = date('d-m-Y', strtotime($timesheet->asnDate_dte));
                $html .= "<tr class='school-detail-table-data editTimesheetRow'
                                            id='editTimesheetRow$timesheet->asnItem_id'
                                            onclick='timesheetRow($timesheet->asnItem_id)'>
                                            <td>$timesheet->name_txt</td>
                                            <td>$name</td>
                                            <td>$date</td>
                                            <td>$timesheet->charge_dec</td>
                                        </tr>";
            }
        }

        $result['status'] = "success";
        $result['eventId'] = $editEventId;
        $result['html'] = $html;
        return response()->json($result);
    }

    public function financeProcessInvoice(Request $request)
    {
        $user_id = '';
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $user_id = $webUserLoginData->user_id;
        }
        $p_maxDate = $request->p_maxDate;
        $timesheetAsnItemIds = $request->timesheetAsnItemIds;
        $idsArr = explode(",", $timesheetAsnItemIds);
        if (count($idsArr) > 0) {
            $itemList = DB::table('tbl_asnItem')
                ->leftJoin('tbl_asn', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->leftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->leftJoin('tbl_student', 'tbl_asn.student_id', '=', 'tbl_student.student_id')
                ->select('asnItem_id', 'tbl_asnItem.asn_id', 'tbl_asn.teacher_id', 'school_id', DB::raw("CONCAT(DATE_FORMAT(asnDate_dte, '%d/%m/%Y'), ' - ', (IF(tbl_teacher.knownAs_txt IS NULL OR tbl_teacher.knownAs_txt = '', CONCAT(tbl_teacher.firstName_txt, ' ',  IFNULL(tbl_teacher.surname_txt, '')), CONCAT(tbl_teacher.firstName_txt, ' (', tbl_teacher.knownAs_txt, ') ',  IFNULL(tbl_teacher.surname_txt, '')))), ' - ', IF(tbl_asn.student_id IS NULL, IF(yearGroup_int IS NULL AND subject_int IS NULL, 'Cover', IF(subject_int IS NOT NULL, (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 6 AND description_int = subject_int), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 34 AND description_int = yearGroup_int))), CONCAT('Tutoring: ', CONCAT(tbl_student.firstname_txt, ' ', tbl_student.surname_txt)))) AS description_txt"), DB::raw("IF(hours_dec IS NULL, dayPercent_dec, hours_dec) AS numItems"), DB::raw("IF(hours_dec IS NULL, 'day', 'hour') AS numItemsDescription_txt"), 'asnDate_dte', DB::raw("IF(hours_dec IS NULL, tbl_asnItem.charge_dec, tbl_asnItem.charge_dec / 6) AS charge_dec"), DB::raw("IF(hours_dec IS NULL, tbl_asnItem.cost_dec, tbl_asnItem.cost_dec / 6) AS cost_dec"))
                ->whereIn('asnItem_id', $idsArr)
                ->get();
            // dd($itemList);
            $newItemList = array();
            if (count($itemList) > 0) {
                foreach ($itemList as $key => $value) {
                    if (!isset($newItemList[$value->school_id])) {
                        $newItemList[$value->school_id] = array();
                    }
                    array_push($newItemList[$value->school_id], $value);
                }
            }
            // dd($newItemList);
            $firstInvoiceId = '';
            $invoice_id = '';
            foreach ($newItemList as $key1 => $value1) {
                $invoice_id = DB::table('tbl_invoice')
                    ->insertGetId([
                        'school_id' => $key1,
                        'created_by' => $user_id,
                        'invoiceDate_dte' => date('Y-m-d'),
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);
                if ($firstInvoiceId == '') {
                    $firstInvoiceId = $invoice_id;
                }
                foreach ($value1 as $key2 => $val2) {
                    DB::table('tbl_invoiceItem')
                        ->insertGetId([
                            'invoice_id' => $invoice_id,
                            'asnItem_id' => $val2->asnItem_id,
                            'teacher_id' => $val2->teacher_id,
                            'description_txt' => $val2->description_txt,
                            'numItems_dec' => $val2->numItems,
                            'numItemsDescription_txt' => $val2->numItemsDescription_txt,
                            'dateFor_dte' => $val2->asnDate_dte,
                            'charge_dec' => $val2->charge_dec,
                            'cost_dec' => $val2->cost_dec
                        ]);

                    DB::table('tbl_asnItem')
                        ->where('asnItem_id', $val2->asnItem_id)
                        ->update([
                            'invoice_id' => $invoice_id
                        ]);
                }
            }

            return redirect('/finance-invoices?invoiceNumberMin=' . $firstInvoiceId . '&invoiceNumberMax=' . $invoice_id . '&date=' . $p_maxDate);
        } else {
            return redirect()->back();
        }
    }

    public function financeInvoiceSplit(Request $request)
    {
        $input = $request->all();
        $editInvoiceId = $input['editInvoiceId'];

        $invoiceDetail = DB::table('tbl_invoice')
            ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_invoice.school_id')
            ->select('tbl_invoice.*', 'tbl_school.name_txt')
            ->where('tbl_invoice.invoice_id', $editInvoiceId)
            ->first();
        $invoiceItemList = DB::table('tbl_invoiceItem')
            ->select('tbl_invoiceItem.*')
            ->where('tbl_invoiceItem.invoice_id', $editInvoiceId)
            ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
            ->get();

        $view = view("web.finance.invoice_split_view", ['invoiceDetail' => $invoiceDetail, 'invoiceItemList' => $invoiceItemList])->render();
        return response()->json(['html' => $view]);
    }

    public function financeSplitInvoiceCreate(Request $request)
    {
        // dd($request->all());
        $user_id = '';
        $editData = array();
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $user_id = $webUserLoginData->user_id;
        }
        $splitInvoiceId = $request->splitInvoiceId;
        $school_id = $request->splitInvoiceSchoolId;
        $editData['invoice_path'] = NULL;

        if ($request->invoiceDate_dte != null || $request->invoiceDate_dte != '') {
            $editData['invoiceDate_dte'] = date("Y-m-d", strtotime(str_replace('/', '-', $request->invoiceDate_dte)));
        }
        if ($request->paidOn_dte != null || $request->paidOn_dte != '') {
            $editData['paidOn_dte'] = date("Y-m-d", strtotime(str_replace('/', '-', $request->paidOn_dte)));
        }
        DB::table('tbl_invoice')
            ->where('invoice_id', $splitInvoiceId)
            ->update($editData);

        $invoice_id = DB::table('tbl_invoice')
            ->insertGetId([
                'school_id' => $school_id,
                'created_by' => $user_id,
                'invoiceDate_dte' => date('Y-m-d')
            ]);
        $splitInvoiceSelectedItems = $request->splitInvoiceSelectedItems;
        $selectedIdArray = explode(",", $splitInvoiceSelectedItems);
        foreach ($selectedIdArray as $key => $value) {
            $invoiceItemDet = DB::table('tbl_invoiceItem')
                ->select('tbl_invoiceItem.*')
                ->where('tbl_invoiceItem.invoiceItem_id', $value)
                ->first();
            if ($invoiceItemDet) {
                DB::table('tbl_invoiceItem')
                    ->insert([
                        'invoice_id' => $invoice_id,
                        'asnItem_id' => $invoiceItemDet->asnItem_id,
                        'teacher_id' => $invoiceItemDet->teacher_id,
                        'description_txt' => $invoiceItemDet->description_txt,
                        'numItems_dec' => $invoiceItemDet->numItems_dec,
                        'numItemsDescription_txt' => $invoiceItemDet->numItemsDescription_txt,
                        'dateFor_dte' => $invoiceItemDet->dateFor_dte,
                        'charge_dec' => $invoiceItemDet->charge_dec,
                        'cost_dec' => $invoiceItemDet->cost_dec,
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);

                DB::table('tbl_invoiceItem')
                    ->where('invoiceItem_id', $value)
                    ->delete();
            }
        }
        $maxNum = $request->invoiceNumberMax;
        if ($invoice_id) {
            $maxNum = $invoice_id;
        }
        $url = url("/finance-invoices?invoiceNumberMin=" . $request->invoiceNumberMin . "&invoiceNumberMax=" . $maxNum . "&date=" . $request->date . "&showSent=" . $request->showSent . "");
        $msg = "New invoice has been created with the ID : " . $invoice_id;
        return redirect($url)->with('success', $msg);
    }

    public function financeInvoiceEdit(Request $request)
    {
        $input = $request->all();
        $editInvoiceId = $input['editInvoiceId'];

        $paymentMethodList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 42)
            ->get();
        $invoiceDetail = DB::table('tbl_invoice')
            ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_invoice.school_id')
            ->select('tbl_invoice.*', 'tbl_school.name_txt')
            ->where('tbl_invoice.invoice_id', $editInvoiceId)
            ->first();
        $invoiceItemList = DB::table('tbl_invoiceItem')
            ->select('tbl_invoiceItem.*')
            ->where('tbl_invoiceItem.invoice_id', $editInvoiceId)
            ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
            ->get();

        $view = view("web.finance.invoice_edit_view", ['paymentMethodList' => $paymentMethodList, 'invoiceDetail' => $invoiceDetail, 'invoiceItemList' => $invoiceItemList])->render();
        return response()->json(['html' => $view]);
    }

    public function financeInvoiceUpdate(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $editData = array();

        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            // $editData['paymentLoggedBy_id'] = $webUserLoginData->user_id;
            // $editData['sentBy_int'] = $webUserLoginData->user_id;
        }
        if ($request->factored_status) {
            $editData['factored_status'] = -1;
        }
        if ($request->creditNote_status) {
            $editData['creditNote_status'] = -1;
        }
        if ($request->invoiceDate_dte != null || $request->invoiceDate_dte != '') {
            $editData['invoiceDate_dte'] = date("Y-m-d", strtotime(str_replace('/', '-', $request->invoiceDate_dte)));
        }
        if ($request->paidOn_dte != null || $request->paidOn_dte != '') {
            $editData['paidOn_dte'] = date("Y-m-d", strtotime(str_replace('/', '-', $request->paidOn_dte)));
        }
        $editData['paymentMethod_int'] = $request->paymentMethod_int;
        // $editData['sentOn_dte'] = date('Y-m-d');
        $editData['timestamp_ts'] = date('Y-m-d H:i:s');

        DB::table('tbl_invoice')
            ->where('invoice_id', $invoice_id)
            ->update($editData);

        return redirect()->back()->with('success', "Invoice updated successfully.");
    }

    public function financeInvItemInsert(Request $request)
    {
        $invoice_id = $request->invoice_id;

        DB::table('tbl_invoiceItem')
            ->insert([
                'invoice_id' => $invoice_id,
                'description_txt' => $request->description_txt,
                'numItems_dec' => $request->numItems_dec,
                'dateFor_dte' => date("Y-m-d", strtotime(str_replace('/', '-', $request->dateFor_dte))),
                'charge_dec' => $request->charge_dec,
                'cost_dec' => $request->cost_dec,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        $invoiceItemList = DB::table('tbl_invoiceItem')
            ->select('tbl_invoiceItem.*')
            ->where('tbl_invoiceItem.invoice_id', $invoice_id)
            ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
            ->get();

        $html = '';
        if (count($invoiceItemList) > 0) {
            foreach ($invoiceItemList as $key => $invoiceItem) {
                $asn = '';
                $tch = '';
                if ($invoiceItem->asnItem_id != '' || $invoiceItem->asnItem_id != null) {
                    $asn = 'Y';
                } else {
                    $asn = 'N';
                }
                if ($invoiceItem->teacher_id != '' || $invoiceItem->teacher_id != null) {
                    $tch = 'Y';
                } else {
                    $tch = 'N';
                }
                $html .= "<tr class='school-detail-table-data editInvItemRow'
                        onclick='invItemRowSelect($invoiceItem->invoiceItem_id)'
                        id='editInvItemRow$invoiceItem->invoiceItem_id'>
                        <td style='width: 50%;'>$invoiceItem->description_txt</td>
                        <td>" . $invoiceItem->numItems_dec . "</td>
                        <td>" . $invoiceItem->charge_dec . "</td>
                        <td>" . $invoiceItem->cost_dec . "</td>
                        <td>$asn</td>
                        <td>$tch</td>
                    </tr>";
            }
        }

        $result['status'] = "success";
        $result['eventId'] = $invoice_id;
        $result['html'] = $html;
        return response()->json($result);
    }

    public function financeInvoiceItemEdit(Request $request)
    {
        $input = $request->all();
        $invoiceItem_id = $input['editInvItemId'];

        $itemDetail = DB::table('tbl_invoiceItem')
            ->where('invoiceItem_id', "=", $invoiceItem_id)
            ->first();

        $view = view("web.finance.invoice_item_edit_view", ['itemDetail' => $itemDetail])->render();
        return response()->json(['html' => $view]);
    }

    public function financeInvoiceItemUpdate(Request $request)
    {
        $result['status'] = "failed";
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $invoiceItem_id = $request->editInvItemId;
            $invoice_id = $request->invoice_id;

            DB::table('tbl_invoiceItem')
                ->where('invoiceItem_id', $invoiceItem_id)
                ->update([
                    'description_txt' => $request->description_txt,
                    'numItems_dec' => $request->numItems_dec,
                    'dateFor_dte' => date("Y-m-d", strtotime(str_replace('/', '-', $request->dateFor_dte))),
                    'charge_dec' => $request->charge_dec,
                    'cost_dec' => $request->cost_dec,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            $invoiceItemList = DB::table('tbl_invoiceItem')
                ->select('tbl_invoiceItem.*')
                ->where('tbl_invoiceItem.invoice_id', $invoice_id)
                ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                ->get();

            $html = '';
            if (count($invoiceItemList) > 0) {
                foreach ($invoiceItemList as $key => $invoiceItem) {
                    $asn = '';
                    $tch = '';
                    if ($invoiceItem->asnItem_id != '' || $invoiceItem->asnItem_id != null) {
                        $asn = 'Y';
                    } else {
                        $asn = 'N';
                    }
                    if ($invoiceItem->teacher_id != '' || $invoiceItem->teacher_id != null) {
                        $tch = 'Y';
                    } else {
                        $tch = 'N';
                    }
                    $html .= "<tr class='school-detail-table-data editInvItemRow'
                        onclick='invItemRowSelect($invoiceItem->invoiceItem_id)'
                        id='editInvItemRow$invoiceItem->invoiceItem_id'>
                        <td style='width: 50%;'>$invoiceItem->description_txt</td>
                        <td>" . $invoiceItem->numItems_dec . "</td>
                        <td>" . $invoiceItem->charge_dec . "</td>
                        <td>" . $invoiceItem->cost_dec . "</td>
                        <td>$asn</td>
                        <td>$tch</td>
                    </tr>";
                }
            }

            $schoolInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_invoice.created_by')
                ->select('tbl_invoice.*', 'tbl_user.firstName_txt as admin_fname', 'tbl_user.surname_txt as admin_sname', 'tbl_user.user_name as admin_email', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.invoice_id', $invoice_id)
                ->groupBy('tbl_invoice.invoice_id')
                ->first();
            if ($schoolInvoices) {
                $contactDet = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    // ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                    // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                    ->first();

                $invoiceItemList = DB::table('tbl_invoiceItem')
                    ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asnItem_id', '=', 'tbl_invoiceItem.asnItem_id')
                    ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_invoiceItem.teacher_id')
                    ->select('tbl_invoiceItem.*', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', DB::raw("IF(tbl_asnItem.dayPart_int = 4, CONCAT(tbl_asnItem.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem.dayPart_int)) AS dayAvail_txt"))
                    ->where('tbl_invoiceItem.invoice_id', $invoice_id)
                    ->orderBy('tbl_teacher.firstName_txt', 'ASC')
                    ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                    ->get();

                $companyDetail = DB::table('company')
                    ->select('company.*')
                    ->where('company.company_id', $company_id)
                    ->first();

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

                $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDet]);
                $pdfName = 'invoice-' . $invoice_id . '.pdf';
                $pdf->save(public_path('pdfs/invoice/' . $pdfName));
                $fPath = 'pdfs/invoice/' . $pdfName;

                DB::table('tbl_invoice')
                    ->where('invoice_id', '=', $invoice_id)
                    ->update([
                        'invoice_path' => $fPath
                    ]);
            }

            $result['status'] = "success";
            $result['html'] = $html;
        }
        return response()->json($result);
    }

    public function financeInvoiceItemDelete(Request $request)
    {
        $invoiceItem_id = $request->editInvItemId;

        $itemDetail = DB::table('tbl_invoiceItem')
            ->where('invoiceItem_id', "=", $invoiceItem_id)
            ->first();
        $html = '';
        $result['status'] = "failed";
        if ($itemDetail) {
            DB::table('tbl_invoiceItem')
                ->where('invoiceItem_id', $invoiceItem_id)
                ->delete();

            $invoiceItemList = DB::table('tbl_invoiceItem')
                ->select('tbl_invoiceItem.*')
                ->where('tbl_invoiceItem.invoice_id', $itemDetail->invoice_id)
                ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                ->get();

            if (count($invoiceItemList) > 0) {
                foreach ($invoiceItemList as $key => $invoiceItem) {
                    $asn = '';
                    $tch = '';
                    if ($invoiceItem->asnItem_id != '' || $invoiceItem->asnItem_id != null) {
                        $asn = 'Y';
                    } else {
                        $asn = 'N';
                    }
                    if ($invoiceItem->teacher_id != '' || $invoiceItem->teacher_id != null) {
                        $tch = 'Y';
                    } else {
                        $tch = 'N';
                    }
                    $html .= "<tr class='school-detail-table-data editInvItemRow'
                        onclick='invItemRowSelect($invoiceItem->invoiceItem_id)'
                        id='editInvItemRow$invoiceItem->invoiceItem_id'>
                        <td style='width: 50%;'>$invoiceItem->description_txt</td>
                        <td>" . $invoiceItem->numItems_dec . "</td>
                        <td>" . $invoiceItem->charge_dec . "</td>
                        <td>" . $invoiceItem->cost_dec . "</td>
                        <td>$asn</td>
                        <td>$tch</td>
                    </tr>";
                }
            }
            $result['status'] = "success";
        }

        $result['html'] = $html;
        return response()->json($result);
    }

    public function financeInvoiceSave(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $editInvoiceId = $input['editInvoiceId'];
            $result['exist'] = 'No';

            $schoolInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_invoice.created_by')
                ->select('tbl_invoice.*', 'tbl_user.firstName_txt as admin_fname', 'tbl_user.surname_txt as admin_sname', 'tbl_user.user_name as admin_email', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.invoice_id', $editInvoiceId)
                ->groupBy('tbl_invoice.invoice_id')
                ->first();
            if ($schoolInvoices) {
                $contactDet = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    // ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                    ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                    ->get();
                $sendMail = [];
                // if ($contactDet && $contactDet->contactItem_txt) {
                //     $sendMail = $contactDet->contactItem_txt;
                // }
                foreach ($contactDet as $mKey => $mValue) {
                    array_push($sendMail, $mValue->contactItem_txt);
                }

                $fileExist = 'No';
                if ($schoolInvoices->invoice_path) {
                    // if (file_exists(public_path($schoolInvoices->invoice_path))) {
                    //     $fileExist = 'Yes';
                    // }
                }

                if ($fileExist == 'Yes') {
                    $result['exist'] = 'Yes';
                    $result['sendMail'] = $sendMail;
                    $result['invoice_path'] = asset($schoolInvoices->invoice_path);
                    $fPath = $schoolInvoices->invoice_path;
                } else {
                    $invoiceItemList = DB::table('tbl_invoiceItem')
                        ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asnItem_id', '=', 'tbl_invoiceItem.asnItem_id')
                        ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_invoiceItem.teacher_id')
                        ->select('tbl_invoiceItem.*', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', DB::raw("CONCAT(IF(tbl_asnItem.dayPart_int = 4, CONCAT(tbl_asnItem.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem.dayPart_int)),IF(lunch_time, CONCAT(' ( ', lunch_time,' )'), '')) AS dayAvail_txt"))
                        ->where('tbl_invoiceItem.invoice_id', $editInvoiceId)
                        ->orderBy('tbl_teacher.firstName_txt', 'ASC')
                        ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                        ->get();

                    $companyDetail = DB::table('company')
                        ->select('company.*')
                        ->where('company.company_id', $company_id)
                        ->first();

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

                    $contactDetNew = DB::table('tbl_schoolContact')
                        ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                        ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                        ->where('tbl_schoolContact.isCurrent_status', '-1')
                        ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                        // ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                        // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                        ->where('tbl_contactItemSch.type_int', 1)
                        ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                        ->first();

                    $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDetNew]);
                    $pdfName = 'invoice-' . $editInvoiceId . '.pdf';
                    $pdf->save(public_path('pdfs/invoice/' . $pdfName));
                    $fPath = 'pdfs/invoice/' . $pdfName;

                    DB::table('tbl_invoice')
                        ->where('invoice_id', '=', $editInvoiceId)
                        ->update([
                            'invoice_path' => $fPath
                        ]);

                    if (file_exists(public_path($fPath))) {
                        $result['exist'] = 'Yes';
                        $result['invoice_path'] = asset($fPath);
                    }
                    $result['sendMail'] = $sendMail;
                }

                // if (file_exists(public_path($fPath))) {
                //     $mailData['subject'] = 'Finance Invoice';
                //     $mailData['mail_description'] = "A pdf file of finance invoice is attach with this mail. Please check it out.";
                //     $mailData['invoice_path'] = asset($fPath);
                //     $mailData['contactDet'] = $contactDet;
                //     $mailData['mail'] = $sendMail;
                // $mailData['companyDetail'] = $companyDetail;
                //     $myVar = new AlertController();
                //     $myVar->sendSchFinanceInvoiceMail($mailData);
                // }
            }
        } else {
            $result['exist'] = 'No';
        }
        return response()->json($result);
    }

    public function financeInvoiceSaveNew(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $editInvoiceId = $input['editInvoiceId'];
            $result['exist'] = 'No';

            $schoolInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_invoice.created_by')
                ->select('tbl_invoice.*', 'tbl_user.firstName_txt as admin_fname', 'tbl_user.surname_txt as admin_sname', 'tbl_user.user_name as admin_email', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.invoice_id', $editInvoiceId)
                ->groupBy('tbl_invoice.invoice_id')
                ->first();
            if ($schoolInvoices) {
                $contactDet = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    // ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                    ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                    ->get();
                $companyDetail = DB::table('company')
                    ->select('company.*')
                    ->where('company.company_id', $company_id)
                    ->first();

                $sendMail = [];
                // if ($contactDet && $contactDet->contactItem_txt) {
                //     $sendMail = $contactDet->contactItem_txt;
                // }
                foreach ($contactDet as $mKey => $mValue) {
                    array_push($sendMail, $mValue->contactItem_txt);
                }

                $fileExist = 'No';
                // if ($schoolInvoices->invoice_path) {
                //     if (file_exists(public_path($schoolInvoices->invoice_path))) {
                //         $fileExist = 'Yes';
                //     }
                // }

                if ($fileExist == 'Yes') {
                    $result['exist'] = 'Yes';
                    $result['sendMail'] = $sendMail;
                    $result['invoice_path'] = asset($schoolInvoices->invoice_path);
                    $fPath = $schoolInvoices->invoice_path;
                } else {
                    $invoiceItemList = DB::table('tbl_invoiceItem')
                        ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asnItem_id', '=', 'tbl_invoiceItem.asnItem_id')
                        ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_invoiceItem.teacher_id')
                        ->select('tbl_invoiceItem.*', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', DB::raw("CONCAT(IF(tbl_asnItem.dayPart_int = 4, CONCAT(tbl_asnItem.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem.dayPart_int)),IF(lunch_time, CONCAT(' ( ', lunch_time,' )'), '')) AS dayAvail_txt"))
                        ->where('tbl_invoiceItem.invoice_id', $editInvoiceId)
                        ->orderBy('tbl_teacher.firstName_txt', 'ASC')
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

                    $contactDetNew = DB::table('tbl_schoolContact')
                        ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                        ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                        ->where('tbl_schoolContact.isCurrent_status', '-1')
                        ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                        // ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                        // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                        ->where('tbl_contactItemSch.type_int', 1)
                        ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                        ->first();

                    $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDetNew]);
                    $pdfName = 'invoice-' . $editInvoiceId . '.pdf';
                    $pdf->save(public_path('pdfs/invoice/' . $pdfName));
                    $fPath = 'pdfs/invoice/' . $pdfName;

                    DB::table('tbl_invoice')
                        ->where('invoice_id', '=', $editInvoiceId)
                        ->update([
                            'invoice_path' => $fPath
                        ]);

                    if (file_exists(public_path($fPath))) {
                        $result['exist'] = 'Yes';
                        $result['invoice_path'] = asset($fPath);
                    }
                    $result['sendMail'] = $sendMail;
                }

                if (file_exists(public_path($fPath))) {
                    foreach ($contactDet as $mKey2 => $mValue2) {
                        if ($mValue2->contactItem_txt) {
                            $mailData['subject'] = 'Finance Invoice';
                            $mailData['mail_description'] = "<p>Please find attached your invoice for this weeks agency staff. If you have an queries on this invoice please kindly respond within 24 hours of receiving this email.</p><p><b>*Please note that if we do not receive notification of any adjustments needed within the 24 hour period, this will be accepted as all invoices being authorised and amendments will not be able to be made thereafter.*</b></p><p>*A kind reminder that our payment terms are 14 days from the date of this invoice*</p><p>Many thanks in advance</p>";
                            $mailData['invoice_path'] = asset($fPath);
                            $mailData['contactDet'] = $mValue2;
                            $mailData['mail'] = $mValue2->contactItem_txt;
                            $mailData['companyDetail'] = $companyDetail;
                            $myVar = new AlertController();
                            $myVar->sendSchFinanceInvoiceMail($mailData);
                        }
                    }
                }
            }
        } else {
            $result['exist'] = 'No';
        }
        return response()->json($result);
    }

    public function sendOverdueInvoice(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->school_id;
            $result['exist'] = 'No';

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            $contactDet = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $school_id)
                ->get();

            $sendMail = [];
            foreach ($contactDet as $mKey => $mValue) {
                array_push($sendMail, $mValue->contactItem_txt);
            }

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
                ->where('tbl_school.school_id', $school_id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                ->first();

            $contactDetNew = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $school_id)
                ->first();

            $thresholdDate = Carbon::now()->subDays(30);
            $dueInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_invoice.created_by')
                ->select('tbl_invoice.*', 'tbl_user.firstName_txt as admin_fname', 'tbl_user.surname_txt as admin_sname', 'tbl_user.user_name as admin_email', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.school_id', $school_id)
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->where('tbl_invoice.invoiceDate_dte', '<', $thresholdDate)
                ->groupBy('tbl_invoice.invoice_id')
                ->orderBy('tbl_invoice.invoiceDate_dte', 'DESC')
                ->get();

            $invoiceOverdueCal = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select(DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"))
                ->where('tbl_invoice.school_id', $school_id)
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->where('tbl_invoice.invoiceDate_dte', '<', $thresholdDate)
                ->first();
            if (count($dueInvoices) > 0) {
                $fileArr = [];
                foreach ($dueInvoices as $key => $value) {
                    $invoiceItemList = DB::table('tbl_invoiceItem')
                        ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asnItem_id', '=', 'tbl_invoiceItem.asnItem_id')
                        ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_invoiceItem.teacher_id')
                        ->select('tbl_invoiceItem.*', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', DB::raw("CONCAT(IF(tbl_asnItem.dayPart_int = 4, CONCAT(tbl_asnItem.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem.dayPart_int)),IF(lunch_time, CONCAT(' ( ', lunch_time,' )'), '')) AS dayAvail_txt"))
                        ->where('tbl_invoiceItem.invoice_id', $value->invoice_id)
                        ->orderBy('tbl_teacher.firstName_txt', 'ASC')
                        ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                        ->get();

                    $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $value, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDetNew]);
                    $pdfName = 'invoice-' . $value->invoice_id . '.pdf';
                    $pdf->save(public_path('pdfs/invoice/' . $pdfName));
                    $fPath = 'pdfs/invoice/' . $pdfName;

                    DB::table('tbl_invoice')
                        ->where('invoice_id', '=', $value->invoice_id)
                        ->update([
                            'invoice_path' => $fPath,
                            'sentMailBy' => $user_id,
                            'sentMailDate' => date('Y-m-d')
                        ]);

                    if (file_exists(public_path($fPath))) {
                        $fD['name'] = $pdfName;
                        $fD['invoice_path'] = asset($fPath);
                        array_push($fileArr, $fD);
                    }
                }

                if (count($fileArr) > 0) {
                    foreach ($contactDet as $mKey2 => $mValue2) {
                        if ($mValue2->contactItem_txt) {
                            $mailData['subject'] = 'Overdue Invoice';
                            $mailData['mail_description'] = "<p>Please find attached your overdue invoice(s) to date, Could we kindly request that all overdue invoices are paid as a matter of urgency to prevent late payment charges and interest being added.</p><p>*A kind reminder that our payment terms are 14 days from the date of the invoice*</p><p>Many thanks in advance</p>";
                            $mailData['fileArr'] = $fileArr;
                            $mailData['contactDet'] = $mValue2;
                            $mailData['mail'] = $mValue2->contactItem_txt;
                            $mailData['companyDetail'] = $companyDetail;
                            $mailData['dueInvoices'] = $dueInvoices;
                            $mailData['invoiceOverdueCal'] = $invoiceOverdueCal;
                            $myVar = new AlertController();
                            $myVar->sendSchOverdueInvoiceMail($mailData);
                        }
                    }
                }
            }
        } else {
            $result['exist'] = 'No';
        }
        return response()->json($result);
    }

    public function sendOneOverdueInvoice(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $overdueInvoiceIds = explode(",", $request->overdueInvoiceId);
            $result['exist'] = 'No';

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            $dueInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_invoice.created_by')
                ->select('tbl_invoice.*', 'tbl_user.firstName_txt as admin_fname', 'tbl_user.surname_txt as admin_sname', 'tbl_user.user_name as admin_email', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->whereIn('tbl_invoice.invoice_id', $overdueInvoiceIds)
                ->groupBy('tbl_invoice.invoice_id')
                ->get();

            $invoiceOverdueCal = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select(DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"))
                ->whereIn('tbl_invoice.invoice_id', $overdueInvoiceIds)
                ->first();
            if (count($dueInvoices) > 0) {
                $contactDet = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                    ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $dueInvoices[0]->school_id)
                    ->get();

                $sendMail = [];
                foreach ($contactDet as $mKey => $mValue) {
                    array_push($sendMail, $mValue->contactItem_txt);
                }

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
                    ->where('tbl_school.school_id', $dueInvoices[0]->school_id)
                    ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                    ->first();

                $contactDetNew = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $dueInvoices[0]->school_id)
                    ->first();

                $fileArr = [];
                foreach ($dueInvoices as $key => $value) {
                    $invoiceItemList = DB::table('tbl_invoiceItem')
                        ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asnItem_id', '=', 'tbl_invoiceItem.asnItem_id')
                        ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_invoiceItem.teacher_id')
                        ->select('tbl_invoiceItem.*', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', DB::raw("CONCAT(IF(tbl_asnItem.dayPart_int = 4, CONCAT(tbl_asnItem.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem.dayPart_int)),IF(lunch_time, CONCAT(' ( ', lunch_time,' )'), '')) AS dayAvail_txt"))
                        ->where('tbl_invoiceItem.invoice_id', $value->invoice_id)
                        ->orderBy('tbl_teacher.firstName_txt', 'ASC')
                        ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                        ->get();

                    $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $value, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDetNew]);
                    $pdfName = 'invoice-' . $value->invoice_id . '.pdf';
                    $pdf->save(public_path('pdfs/invoice/' . $pdfName));
                    $fPath = 'pdfs/invoice/' . $pdfName;

                    DB::table('tbl_invoice')
                        ->where('invoice_id', '=', $value->invoice_id)
                        ->update([
                            'invoice_path' => $fPath,
                            'sentMailBy' => $user_id,
                            'sentMailDate' => date('Y-m-d')
                        ]);

                    if (file_exists(public_path($fPath))) {
                        $fD['name'] = $pdfName;
                        $fD['invoice_path'] = asset($fPath);
                        array_push($fileArr, $fD);
                    }
                }

                if (count($fileArr) > 0) {
                    foreach ($contactDet as $mKey2 => $mValue2) {
                        if ($mValue2->contactItem_txt) {
                            $mailData['subject'] = 'Overdue Invoice';
                            $mailData['mail_description'] = "<p>Please find attached your overdue invoice(s) to date, Could we kindly request that all overdue invoices are paid as a matter of urgency to prevent late payment charges and interest being added.</p><p><b>*A kind reminder that our payment terms are 14 days from the date of the invoice*</b></p><p>Many thanks in advance</p>";
                            $mailData['fileArr'] = $fileArr;
                            $mailData['contactDet'] = $mValue2;
                            $mailData['mail'] = $mValue2->contactItem_txt;
                            $mailData['companyDetail'] = $companyDetail;
                            $mailData['dueInvoices'] = $dueInvoices;
                            $mailData['invoiceOverdueCal'] = $invoiceOverdueCal;
                            $myVar = new AlertController();
                            $myVar->sendSchOverdueInvoiceMail($mailData);
                        }
                    }
                }
            }
        } else {
            $result['exist'] = 'No';
        }
        return response()->json($result);
    }

    public function financeInvoiceMail(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $editInvoiceId = $input['editInvoiceId'];
            $temp_description = $input['temp_description'];
            $result['exist'] = 'No';

            $schoolInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_invoice.created_by')
                ->select('tbl_invoice.*', 'tbl_user.firstName_txt as admin_fname', 'tbl_user.surname_txt as admin_sname', 'tbl_user.user_name as admin_email', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.invoice_id', $editInvoiceId)
                ->groupBy('tbl_invoice.invoice_id')
                ->first();
            if ($schoolInvoices) {
                $contactDet = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    // ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                    ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                    ->get();
                $companyDetail = DB::table('company')
                    ->select('company.*')
                    ->where('company.company_id', $company_id)
                    ->first();

                $sendMail = [];
                $invoice_path = '';
                // if ($contactDet && $contactDet->contactItem_txt) {
                //     $sendMail = $contactDet->contactItem_txt;
                // }
                foreach ($contactDet as $mKey => $mValue) {
                    array_push($sendMail, $mValue->contactItem_txt);
                }

                $fileExist = 'No';
                if ($schoolInvoices->invoice_path) {
                    // if (file_exists(public_path($schoolInvoices->invoice_path))) {
                    //     $fileExist = 'Yes';
                    //     $invoice_path = asset($schoolInvoices->invoice_path);
                    // }
                }

                if ($fileExist == 'Yes') {
                    $result['exist'] = 'Yes';
                    $result['sendMail'] = $sendMail;
                    // $result['invoice_path'] = asset($schoolInvoices->invoice_path);
                } else {
                    $invoiceItemList = DB::table('tbl_invoiceItem')
                        ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asnItem_id', '=', 'tbl_invoiceItem.asnItem_id')
                        ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_invoiceItem.teacher_id')
                        ->select('tbl_invoiceItem.*', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', DB::raw("CONCAT(IF(tbl_asnItem.dayPart_int = 4, CONCAT(tbl_asnItem.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem.dayPart_int)),IF(lunch_time, CONCAT(' ( ', lunch_time,' )'), '')) AS dayAvail_txt"))
                        ->where('tbl_invoiceItem.invoice_id', $editInvoiceId)
                        ->orderBy('tbl_teacher.firstName_txt', 'ASC')
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

                    $contactDetNew = DB::table('tbl_schoolContact')
                        ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                        ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                        ->where('tbl_schoolContact.isCurrent_status', '-1')
                        ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                        // ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                        // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                        ->where('tbl_contactItemSch.type_int', 1)
                        ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                        ->first();

                    $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDetNew]);
                    $pdfName = 'invoice-' . $editInvoiceId . '.pdf';
                    $pdf->save(public_path('pdfs/invoice/' . $pdfName));
                    $fPath = 'pdfs/invoice/' . $pdfName;

                    DB::table('tbl_invoice')
                        ->where('invoice_id', '=', $editInvoiceId)
                        ->update([
                            'invoice_path' => $fPath
                        ]);

                    if (file_exists(public_path($fPath))) {
                        $result['exist'] = 'Yes';
                        $result['sendMail'] = $sendMail;
                        $invoice_path = asset($fPath);
                    }
                }

                $invoice_name = '';
                if ($invoice_path) {
                    $parts = explode("/", $invoice_path);
                    $invoice_name = end($parts);
                }

                if (count($contactDet) > 0) {
                    foreach ($contactDet as $mKey2 => $mValue2) {
                        if ($mValue2->contactItem_txt) {
                            $mailData['subject'] = "Invoice - " . $editInvoiceId;
                            $mailData['temp_description'] = $temp_description;
                            $mailData['invoice_path'] = $invoice_path;
                            $mailData['invoice_name'] = $invoice_name;
                            $mailData['contactDet'] = $mValue2;
                            $mailData['mail'] = $mValue2->contactItem_txt;
                            $mailData['companyDetail'] = $companyDetail;
                            $myVar = new AlertController();
                            $myVar->sendInvoiceToSchool($mailData);
                        }
                    }

                    DB::table('tbl_invoice')
                        ->where('invoice_id', '=', $editInvoiceId)
                        ->update([
                            'sentMailDate' => date('Y-m-d'),
                            'sentMailBy' => $user_id
                        ]);
                }

                return redirect()->back()->with('success', "Mail send successfully.");
            }
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeInvoiceAllMail(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $p_invoiceNumberMin = $input['invoiceNumberMin'];
            $p_invoiceNumberMax = $input['invoiceNumberMax'];
            $temp_description = $input['temp_description'];
            $result['exist'] = 'No';

            $invoiceList = DB::table('tbl_school')
                ->LeftJoin('tbl_invoice', 'tbl_school.school_id', '=', 'tbl_invoice.school_id')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->leftJoin(
                    DB::raw("(SELECT tbl_contactItemSch.school_id, contactItem_txt AS invoiceEmail_txt FROM tbl_contactItemSch LEFT JOIN tbl_schoolContact ON tbl_schoolContact.contact_id = tbl_contactItemSch.schoolContact_id WHERE receiveInvoices_status <> 0 AND (tbl_schoolContact.isCurrent_status = -1 OR tbl_contactItemSch.schoolContact_id IS NULL) GROUP BY tbl_contactItemSch.school_id) AS t_email"),
                    function ($join) {
                        $join->on('tbl_school.school_id', '=', 't_email.school_id');
                    }
                )
                ->select('tbl_invoice.invoice_id', 'tbl_invoice.invoiceDate_dte', 'tbl_school.school_id', 'tbl_school.name_txt', DB::raw("CAST(SUM((numItems_dec * charge_dec * ((100 + vatRate_dec) / 100))) AS DECIMAL(7, 2)) AS gross_dec"), DB::raw("CAST(SUM(numItems_dec * charge_dec) AS DECIMAL(7, 2)) AS net_dec"), DB::raw("SUM(numItems_dec) AS days_dec"), DB::raw("COUNT(DISTINCT tbl_invoiceItem.teacher_id) AS teachers_int"), DB::raw("IF(invoiceEmail_txt IS NOT NULL, 'Y', 'N') AS hasEmail_status"), DB::raw("IF(tbl_invoice.factored_status <> 0, 'Y', 'N') AS factored_status"), 'invoiceEmail_txt', 'sentOn_dte')
                ->whereBetween('tbl_invoice.invoice_id', array($p_invoiceNumberMin, $p_invoiceNumberMax))
                ->groupBy('tbl_invoice.invoice_id')
                ->orderBy('tbl_invoice.invoice_id', 'ASC')
                ->orderBy('invoiceDate_dte', 'DESC')
                ->orderByRaw('SUM(numItems_dec * charge_dec)')
                ->get();

            $attachmentArr = array();
            foreach ($invoiceList as $key => $value) {
                $schoolInvoices = DB::table('tbl_invoice')
                    ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                    ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_invoice.created_by')
                    ->select('tbl_invoice.*', 'tbl_user.firstName_txt as admin_fname', 'tbl_user.surname_txt as admin_sname', 'tbl_user.user_name as admin_email', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                    ->where('tbl_invoice.invoice_id', $value->invoice_id)
                    ->groupBy('tbl_invoice.invoice_id')
                    ->first();
                if ($schoolInvoices) {
                    $contactDet = DB::table('tbl_schoolContact')
                        ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                        ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                        ->where('tbl_schoolContact.isCurrent_status', '-1')
                        // ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                        ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                        ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                        ->where('tbl_contactItemSch.type_int', 1)
                        ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                        ->get();

                    $companyDetail = DB::table('company')
                        ->select('company.*')
                        ->where('company.company_id', $company_id)
                        ->first();

                    $sendMail = [];
                    $invoice_path = '';
                    // if ($contactDet && $contactDet->contactItem_txt) {
                    //     $sendMail = $contactDet->contactItem_txt;
                    // }
                    foreach ($contactDet as $mKey => $mValue) {
                        array_push($sendMail, $mValue->contactItem_txt);
                    }

                    $fileExist = 'No';
                    if ($schoolInvoices->invoice_path) {
                        // if (file_exists(public_path($schoolInvoices->invoice_path))) {
                        //     $fileExist = 'Yes';
                        //     $invoice_path = asset($schoolInvoices->invoice_path);
                        // }
                    }

                    if ($fileExist == 'Yes') {
                        $invoice_path = asset($schoolInvoices->invoice_path);
                        // array_push($attachmentArr, $invoice_path);
                    } else {
                        $invoiceItemList = DB::table('tbl_invoiceItem')
                            ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asnItem_id', '=', 'tbl_invoiceItem.asnItem_id')
                            ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_invoiceItem.teacher_id')
                            ->select('tbl_invoiceItem.*', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', DB::raw("CONCAT(IF(tbl_asnItem.dayPart_int = 4, CONCAT(tbl_asnItem.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem.dayPart_int)),IF(lunch_time, CONCAT(' ( ', lunch_time,' )'), '')) AS dayAvail_txt"))
                            ->where('tbl_invoiceItem.invoice_id', $value->invoice_id)
                            ->orderBy('tbl_teacher.firstName_txt', 'ASC')
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

                        $contactDetNew = DB::table('tbl_schoolContact')
                            ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                            ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                            ->where('tbl_schoolContact.isCurrent_status', '-1')
                            ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                            // ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                            // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                            ->where('tbl_contactItemSch.type_int', 1)
                            ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                            ->first();

                        $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDetNew]);
                        $pdfName = 'invoice-' . $value->invoice_id . '.pdf';
                        $pdf->save(public_path('pdfs/invoice/' . $pdfName));
                        $fPath = 'pdfs/invoice/' . $pdfName;

                        DB::table('tbl_invoice')
                            ->where('invoice_id', '=', $value->invoice_id)
                            ->update([
                                'invoice_path' => $fPath
                            ]);

                        if (file_exists(public_path($fPath))) {
                            $invoice_path = asset($fPath);
                            array_push($attachmentArr, $invoice_path);
                        }
                    }

                    $invoice_name = '';
                    if ($invoice_path) {
                        $parts = explode("/", $invoice_path);
                        $invoice_name = end($parts);
                    }

                    if (count($contactDet) > 0) {
                        foreach ($contactDet as $mKey2 => $mValue2) {
                            if ($mValue2->contactItem_txt) {
                                $mailData['subject'] = "Invoice - " . $value->invoice_id;
                                $mailData['invoice_path'] = $invoice_path;
                                $mailData['temp_description'] = $temp_description;
                                $mailData['invoice_name'] = $invoice_name;
                                $mailData['contactDet'] = $mValue2;
                                $mailData['mail'] = $mValue2->contactItem_txt;
                                $mailData['companyDetail'] = $companyDetail;
                                $myVar = new AlertController();
                                $myVar->sendInvoiceToSchool($mailData);
                            }
                        }

                        DB::table('tbl_invoice')
                            ->where('invoice_id', '=', $value->invoice_id)
                            ->update([
                                'sentMailDate' => date('Y-m-d'),
                                'sentMailBy' => $user_id
                            ]);
                    }
                }
            }
            return redirect()->back()->with('success', "Mail send successfully.");
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

            if (Carbon::now()->isFriday()) {
                $friday = Carbon::now()->format('Y-m-d');
            } else {
                $friday = Carbon::now()->next('Friday')->format('Y-m-d');
            }

            $payrollList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('tbl_asnItem.asnItem_id', 'tbl_asn.asn_id', 'tbl_asn.teacher_id', 'tbl_asn.school_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'asnDate_dte', 'dayPercent_dec AS dayPart_dec', 'tbl_asnItem.cost_dec AS pay_dec')
                ->where('invoice_id', '!=', NULL)
                ->where('payroll_id', '=', NULL)
                ->groupBy(['teacher_id', 'school_id', 'asnItem_id'])
                ->orderBy('teacher_id')
                ->orderBy('asnDate_dte')
                ->get();

            $paySummaryList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_payrollRun', 'tbl_asnItem.payroll_id', '=', 'tbl_payrollRun.payroll_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('tbl_asn.teacher_id', DB::raw("SUM(dayPercent_dec) AS days_dec"), DB::raw("CAST(SUM(dayPercent_dec * tbl_asnItem.cost_dec) AS DECIMAL(7, 2)) AS grossPay_dec"), 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt')
                ->where('tbl_asnItem.payroll_id', '!=', NULL)
                ->whereDate('tbl_payrollRun.payDate_dte', '=', $friday)
                ->groupBy('tbl_asn.teacher_id')
                ->get();

            $payrollRunList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_payrollRun', 'tbl_asnItem.payroll_id', '=', 'tbl_payrollRun.payroll_id')
                ->select('tbl_payrollRun.payroll_id', 'payDate_dte', DB::raw("COUNT(DISTINCT teacher_id) AS teachers_int"), DB::raw("CAST(SUM(dayPercent_dec * tbl_asnItem.cost_dec) AS DECIMAL(9,2)) AS grossPay_dec"))
                ->where('tbl_asnItem.payroll_id', '!=', NULL)
                ->groupBy('payDate_dte')
                ->orderBy('payDate_dte', 'DESC')
                ->get();

            return view("web.finance.finance_payroll", ['title' => $title, 'headerTitle' => $headerTitle, 'friday' => $friday, 'payrollList' => $payrollList, 'paySummaryList' => $paySummaryList, 'payrollRunList' => $payrollRunList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function payrollEventEdit(Request $request)
    {
        $result['exist'] = "No";
        $asnItemId = $request->asnItemId;
        $eventItemDetail = DB::table('tbl_asnItem')
            ->where('tbl_asnItem.asnItem_id', $asnItemId)
            ->first();

        if ($eventItemDetail) {
            $result['exist'] = "Yes";
            $result['eventItemDetail'] = $eventItemDetail;
            return response()->json($result);
        } else {
            $result['exist'] = "No";
            return response()->json($result);
        }
        return response()->json($result);
    }

    public function payrollEventUpdate(Request $request)
    {
        $editEventId = $request->asnItem_id;

        DB::table('tbl_asnItem')
            ->where('asnItem_id', $editEventId)
            ->update([
                'cost_dec' => $request->cost_dec
            ]);

        $payrollList = DB::table('tbl_asn')
            ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
            ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
            ->select('tbl_asnItem.asnItem_id', 'tbl_asn.asn_id', 'tbl_asn.teacher_id', 'tbl_asn.school_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'asnDate_dte', 'dayPercent_dec AS dayPart_dec', 'tbl_asnItem.cost_dec AS pay_dec')
            ->where('invoice_id', '!=', NULL)
            ->where('payroll_id', '=', NULL)
            ->groupBy(['teacher_id', 'school_id', 'asnItem_id'])
            ->orderBy('teacher_id')
            ->orderBy('asnDate_dte')
            ->get();

        $html = '';
        if (count($payrollList) > 0) {
            foreach ($payrollList as $key1 => $payroll) {
                $name = '';
                if ($payroll->knownAs_txt == null && $payroll->knownAs_txt == '') {
                    $name = $payroll->firstName_txt . ' ' . $payroll->surname_txt;
                } else {
                    $name = $payroll->firstName_txt . ' (' . $payroll->knownAs_txt . ') ' . $payroll->surname_txt;
                }
                $date = date('d-m-Y', strtotime($payroll->asnDate_dte));
                $html .= "<tr class='school-detail-table-data editPayrollRow'
                                            id='editPayrollRow$payroll->asnItem_id'
                                            onclick='payrollRow($payroll->asnItem_id)'>
                                            <td>$name</td>
                                            <td>$payroll->name_txt</td>
                                            <td>$date</td>
                                            <td>$payroll->dayPart_dec</td>
                                            <td>$payroll->pay_dec</td>
                                        </tr>";
            }
        }

        $result['status'] = "success";
        $result['eventId'] = $editEventId;
        $result['html'] = $html;
        return response()->json($result);
    }

    public function financeProcessPayroll(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            if (Carbon::now()->isFriday()) {
                $friday = Carbon::now()->format('Y-m-d');
            } else {
                $friday = Carbon::now()->next('Friday')->format('Y-m-d');
            }

            $payrollAsnItemIds = $request->payrollAsnItemIds;
            $idsArr = explode(",", $payrollAsnItemIds);
            if (count($idsArr) > 0) {
                $payrollList = DB::table('tbl_asn')
                    ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                    ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                    ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                    ->select('tbl_asnItem.asnItem_id', 'tbl_asn.asn_id', 'tbl_asn.teacher_id', 'tbl_asn.school_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'asnDate_dte', 'dayPercent_dec AS dayPart_dec', 'tbl_asnItem.cost_dec AS pay_dec')
                    ->where('invoice_id', '!=', NULL)
                    ->where('payroll_id', '=', NULL)
                    ->whereIn('asnItem_id', $idsArr)
                    ->groupBy(['teacher_id', 'school_id', 'asnItem_id'])
                    ->orderBy('teacher_id')
                    ->orderBy('asnDate_dte')
                    ->get();

                if (count($payrollList) > 0) {
                    $payroll_id = DB::table('tbl_payrollRun')
                        ->insertGetId([
                            'runOn_dtm' => date('Y-m-d H:i:s'),
                            'runBy_id' => $user_id,
                            'payDate_dte' => $friday,
                            'timestamp_ts' => date('Y-m-d H:i:s')
                        ]);

                    foreach ($payrollList as $key2 => $val2) {
                        DB::table('tbl_asnItem')
                            ->where('asnItem_id', $val2->asnItem_id)
                            ->update([
                                'payroll_id' => $payroll_id
                            ]);
                    }
                }

                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->intended('/');
        }
    }

    public function payrollDateChange(Request $request)
    {
        $dateType = $request->dateType;
        $fridayDate = $request->fridayDate;

        $newFriday = '';
        $paySummaryList = array();
        if ($fridayDate) {
            if ($dateType == 'prev') {
                $newFriday = Carbon::parse($fridayDate)->previous('Friday')->format('Y-m-d');
            } else if ($dateType == 'next') {
                $newFriday = Carbon::parse($fridayDate)->next('Friday')->format('Y-m-d');
            } else {
                $newFriday = $fridayDate;
            }
        }
        $html = '';
        if ($newFriday) {
            $paySummaryList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_payrollRun', 'tbl_asnItem.payroll_id', '=', 'tbl_payrollRun.payroll_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('tbl_asn.teacher_id', DB::raw("SUM(dayPercent_dec) AS days_dec"), DB::raw("CAST(SUM(dayPercent_dec * tbl_asnItem.cost_dec) AS DECIMAL(7, 2)) AS grossPay_dec"), 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt')
                ->where('tbl_asnItem.payroll_id', '!=', NULL)
                ->whereDate('tbl_payrollRun.payDate_dte', '=', $newFriday)
                ->groupBy('tbl_asn.teacher_id')
                ->get();

            if (count($paySummaryList) > 0) {
                foreach ($paySummaryList as $key2 => $paySummary) {
                    $name = '';
                    if ($paySummary->knownAs_txt == null && $paySummary->knownAs_txt == '') {
                        $name = $paySummary->firstName_txt . ' ' . $paySummary->surname_txt;
                    } else {
                        $name = $paySummary->firstName_txt . ' (' . $paySummary->knownAs_txt . ') ' . $paySummary->surname_txt;
                    }
                    $html .= "<tr class='school-detail-table-data'>
                                    <td>$name</td>
                                    <td>$paySummary->days_dec</td>
                                    <td>$paySummary->grossPay_dec</td>
                                </tr>";
                }
            }
        }
        $result['newFriday'] = $newFriday;
        $result['formattedDate'] = date('d-m-Y', strtotime($newFriday));
        $result['html'] = $html;
        return response()->json($result);
    }

    public function exportPayroll(Request $request, $date)
    {
        $fileName = 'PayrollExport' . time() . '.xlsx';

        return Excel::download(new PayrollExport($date), $fileName);
    }

    public function financeRemittance(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance Remittance");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $thresholdDate = Carbon::now()->subDays(30);

            $Invoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_user as paymentLoggedTbl', 'tbl_invoice.paymentLoggedBy_id', '=', 'paymentLoggedTbl.user_id')
                ->LeftJoin('tbl_user as senderTbl', 'tbl_invoice.sentMailBy', '=', 'senderTbl.user_id')
                ->LeftJoin('tbl_description as SchoolPaymentMethod', function ($join) {
                    $join->on('SchoolPaymentMethod.description_int', '=', 'tbl_invoice.school_paid_method')
                        ->where(function ($query) {
                            $query->where('SchoolPaymentMethod.descriptionGroup_int', '=', 42);
                        });
                })
                ->LeftJoin('tbl_description as invPaymentMethod', function ($join) {
                    $join->on('invPaymentMethod.description_int', '=', 'tbl_invoice.paymentMethod_int')
                        ->where(function ($query) {
                            $query->where('invPaymentMethod.descriptionGroup_int', '=', 42);
                        });
                })
                ->select('tbl_invoice.invoice_id', 'tbl_invoice.school_id', 'tbl_invoice.invoiceDate_dte As invoice_dte', 'tbl_school.name_txt As school_txt', 'tbl_invoice.paidOn_dte As paid_dte', 'tbl_invoice.school_paid_dte', DB::raw("CONCAT(paymentLoggedTbl.firstName_txt, ' ', paymentLoggedTbl.surname_txt) As remittee_txt"), 'tbl_invoice.sentOn_dte As sent_dte', DB::raw("CONCAT(senderTbl.firstName_txt, ' ', senderTbl.surname_txt) As sender_txt"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"), 'SchoolPaymentMethod.description_txt as paymentMethod_txt', 'invPaymentMethod.description_txt as invPaymentMethod_txt', 'tbl_invoice.sentMailDate');
            if ($request->include == '') {
                $Invoices->where('tbl_invoice.paidOn_dte', NULL);
                // ->where('tbl_invoice.invoiceDate_dte', '<', $thresholdDate);
            }
            if ($request->method) {
                $Invoices->where('tbl_invoice.paymentMethod_int', $request->method);
            }
            $remitInvoices = $Invoices->groupBy('tbl_invoice.invoice_id')
                // ->orderBy('tbl_invoice.invoiceDate_dte', 'DESC')
                ->get();

            $paymentMethodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 42)
                ->get();

            $invoiceCal = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select(DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"))
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->first();

            $invoiceOverdue = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select(DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"))
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->where('tbl_invoice.invoiceDate_dte', '<', $thresholdDate)
                ->first();

            return view("web.finance.finance_remittance", ['title' => $title, 'headerTitle' => $headerTitle, 'remitInvoices' => $remitInvoices, 'paymentMethodList' => $paymentMethodList, 'invoiceCal' => $invoiceCal, 'invoiceOverdue' => $invoiceOverdue]);
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
                ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_invoice.created_by')
                ->select('tbl_invoice.*', 'tbl_user.firstName_txt as admin_fname', 'tbl_user.surname_txt as admin_sname', 'tbl_user.user_name as admin_email', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.invoice_id', $invoice_id)
                ->groupBy('tbl_invoice.invoice_id')
                ->first();
            $invoiceItemList = DB::table('tbl_invoiceItem')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asnItem_id', '=', 'tbl_invoiceItem.asnItem_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_invoiceItem.teacher_id')
                ->select('tbl_invoiceItem.*', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', DB::raw("IF(tbl_asnItem.dayPart_int = 4, CONCAT(tbl_asnItem.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem.dayPart_int)) AS dayAvail_txt"))
                ->where('tbl_invoiceItem.invoice_id', $invoice_id)
                ->orderBy('tbl_teacher.firstName_txt', 'ASC')
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

            $contactDet = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                // ->where('tbl_schoolContact.receiveInvoice_status', '-1')
                // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                ->first();

            $pdf = PDF::loadView('web.school.school_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDet]);
            $pdfName = 'invoice-' . $invoice_id . '.pdf';
            // return $pdf->download('test.pdf');
            return $pdf->stream($pdfName);
        } else {
            return redirect()->intended('/');
        }
    }

    public function exportInvoiceByDate(Request $request, $from, $to, $type)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            if ($type == 'Excel') {
                $fileName = 'InvoiceExport' . time() . '.xlsx';

                return Excel::download(new InvoiceExport($from, $to), $fileName);
            }
            if ($type == 'CSV') {
                $fileName = 'InvoiceExport' . time() . '.csv';

                return Excel::download(new InvoiceExport($from, $to), $fileName, \Maatwebsite\Excel\Excel::CSV);
            }
            if ($type == 'Pdf') {
                $invoicesList = DB::table('tbl_invoice')
                    ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                    ->LeftJoin('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                    ->select('tbl_invoice.invoice_id AS InvoiceNo', 'name_txt AS Customer', DB::raw("DATE_FORMAT(invoiceDate_dte, '%d/%m/%Y') AS InvoiceDate"), DB::raw("DATE_FORMAT(DATE_ADD(invoiceDate_dte, INTERVAL 30 DAY), '%d/%m/%Y') AS DueDate"), DB::raw("'Net 30' AS Terms"), DB::raw("'' AS Memo"), DB::raw("'Teachers' AS prodOrService"), DB::raw("'Teachers' AS ItemDescription"), DB::raw("'' AS ItemQuantity"), DB::raw("'' AS ItemRate"), DB::raw("CAST(SUM(numItems_dec * charge_dec) AS DECIMAL(9,2)) AS ItemAmount"), DB::raw("'20%' AS ItemTaxCode"), DB::raw("CAST(SUM(numItems_dec * charge_dec) * .2 AS DECIMAL(9,2)) AS ItemTaxAmount"), DB::raw("CAST((SUM(numItems_dec * charge_dec)+(SUM(numItems_dec * charge_dec) * .2)) AS DECIMAL(9,2)) AS GrossAmount"))
                    ->whereBetween('tbl_invoice.invoiceDate_dte', [$from, $to])
                    ->groupBy('tbl_invoice.invoice_id')
                    ->get();

                $fileName = 'InvoiceExport' . time() . '.pdf';

                $pdf = PDF::loadView('web.finance.invoice_by_date_pdf', ['invoicesList' => $invoicesList, 'companyDetail' => $companyDetail])->setPaper('a4', 'landscape');

                return $pdf->download($fileName);
            }
        }
    }
}
