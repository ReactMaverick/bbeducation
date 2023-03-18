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
            $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
            $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
            $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
            $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));

            // $timesheetSchoolList = DB::table('tbl_asn')
            //     ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            //     ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
            //     ->select('tbl_asn.school_id', 'tbl_school.name_txt As schoolName_txt', DB::raw("COUNT(asnItem_id) AS timesheetDatesRequired_int"))
            //     ->where('timesheet_id', NULL)
            //     ->where('status_int', 3)
            //     ->whereDate('asnDate_dte', '<=', $p_maxDate)
            //     ->groupBy('school_id')
            //     ->orderByRaw('COUNT(asnItem_id) DESC')
            //     ->get();

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
                ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.admin_approve AS admin_approve1', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.admin_approve AS admin_approve2', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.admin_approve AS admin_approve3', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.admin_approve AS admin_approve4', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.admin_approve AS admin_approve5', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"))
                ->whereIn('tbl_asn.asn_id', function ($query) use ($weekStartDate, $plusFiveDate, $company_id) {
                    $query->select('tbl_asn.asn_id')
                        ->from('tbl_asn')
                        ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->where('timesheet_id', NULL)
                        ->where('status_int', 3)
                        ->whereDate('asnDate_dte', '>=', $weekStartDate)
                        ->whereDate('asnDate_dte', '<=', $plusFiveDate)
                        ->where('company_id', $company_id)
                        ->where('admin_approve', '!=', 1)
                        ->where('send_to_school', 0)
                        ->groupBy('tbl_asn.asn_id')
                        ->get();
                })
                ->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();
            // dd($calenderList);
            // exit;

            $approvedList = DB::table('tbl_asn')
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
                ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), DB::raw("0 AS reject_status"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"))
                ->whereIn('tbl_asn.asn_id', function ($query) use ($weekStartDate, $plusFiveDate, $company_id) {
                    $query->select('tbl_asn.asn_id')
                        ->from('tbl_asn')
                        ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->where('timesheet_id', NULL)
                        ->where('status_int', 3)
                        ->whereDate('asnDate_dte', '>=', $weekStartDate)
                        ->whereDate('asnDate_dte', '<=', $plusFiveDate)
                        ->where('company_id', $company_id)
                        ->where('admin_approve', 1)
                        ->where('send_to_school', 0)
                        ->groupBy('tbl_asn.asn_id')
                        ->get();
                })
                ->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();

            return view("web.finance.finance_timesheet", ['title' => $title, 'headerTitle' => $headerTitle, 'calenderList' => $calenderList, 'p_maxDate' => $p_maxDate, 'documentList' => $documentList, 'weekStartDate' => $weekStartDate, 'weekEndDate' => $weekEndDate, 'approvedList' => $approvedList, 'plusFiveDate' => $plusFiveDate]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeTimesheetApprove(Request $request)
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
                ->update([
                    'admin_approve' => 1
                ]);

            return true;
        }
        return true;
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

            DB::table('tbl_asnItem')
                ->whereIn('asnItem_id', $itemList)
                ->update([
                    'send_to_school' => 0,
                    'admin_approve' => 2,
                    'rejected_by_type' => 'Admin',
                    'rejected_by' => $user_id
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
            $asnId = $input['approveAsnId'];
            $weekStartDate = $input['weekStartDate'];
            $weekEndDate = $input['weekEndDate'];

            $idsList = DB::table('tbl_asn')
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

            DB::table('tbl_asnItem')
                ->whereIn('asnItem_id', $idsList)
                ->update([
                    'send_to_school' => 1
                ]);

            $schoolDet = DB::table('tbl_asn')
                ->select('tbl_asn.school_id', 'tbl_school.name_txt')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_asn.asn_id', $asnId)
                ->first();

            if (count($idsList) > 0 && $schoolDet) {
                $itemList = DB::table('tbl_asnItem')
                    ->LeftJoin('tbl_asn', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                    ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                    ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                    ->select('tbl_asnItem.asnItem_id', 'tbl_asnItem.asn_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt')
                    ->whereIn('tbl_asnItem.asnItem_id', $idsList)
                    ->groupBy('tbl_asnItem.asnItem_id')
                    ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                    ->get();

                $contactDet = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $schoolDet->school_id)
                    ->first();

                if ($contactDet && $contactDet->contactItem_txt) {
                    $asnIdEnc = base64_encode($asnId);
                    $weekStartDateEnc = base64_encode($weekStartDate);
                    $weekEndDateEnc = base64_encode($weekEndDate);
                    $school_idEnc = base64_encode($schoolDet->school_id);
                    $mailData['contactDet'] = $contactDet;
                    $mailData['itemList'] = $itemList;
                    $mailData['mail'] = $contactDet->contactItem_txt;
                    $mailData['rUrl'] = url('/school/teacher-timesheet-approve') . '/' . $asnIdEnc . '/' . $school_idEnc . '/' . $weekStartDateEnc . '/' . $weekEndDateEnc;
                    $myVar = new AlertController();
                    $myVar->sendToSchoolApproval($mailData);
                }
            }

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
            $asnId = $request->approveAsnId;
            $weekStartDate = $request->weekStartDate;
            $weekEndDate = $request->weekEndDate;

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
                    ->select('tbl_asnItem.asnItem_id', 'tbl_asnItem.asn_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt')
                    ->whereIn('tbl_asnItem.asnItem_id', $idsArr)
                    ->groupBy('tbl_asnItem.asnItem_id')
                    ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                    ->get();

                $timesheet_id = DB::table('tbl_timesheet')
                    ->insertGetId([
                        'school_id' => $schoolDet->school_id,
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);

                $pdf = PDF::loadView("web.finance.timesheet_pdf", ['itemList' => $itemList]);
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
                $result['timesheet_id'] = $timesheet_id;
                $result['schoolName'] = $schoolDet ? $schoolDet->name_txt : '';
                return $result;
            }
        }
        return $result;
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
            $p_maxDate = date('Y-m-d');
            if ($request->date) {
                $p_maxDate = date('Y-m-d', strtotime($request->date));
            }

            $p_invoiceNumberMin = '';
            if ($request->invoiceNumberMin) {
                $p_invoiceNumberMin = $request->invoiceNumberMin;
            }
            $p_invoiceNumberMax = '';
            if ($request->invoiceNumberMax) {
                $p_invoiceNumberMax = $request->invoiceNumberMax;
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
                ->select('asnItem_id', 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'asnDate_dte', 'tbl_asnItem.charge_dec', 'tbl_asnItem.cost_dec')
                ->where('timesheet_id', '!=', NULL)
                ->where('tbl_asnItem.invoice_id', '=', NULL)
                ->whereDate('asnDate_dte', '<=', $p_maxDate)
                ->groupBy('asnItem_id')
                ->orderByRaw('school_id,teacher_id,asnDate_dte')
                ->get();

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

            return view("web.finance.finance_invoice", ['title' => $title, 'headerTitle' => $headerTitle, 'timesheetList' => $timesheetList, 'p_maxDate' => $p_maxDate, 'p_invoiceNumberMin' => $p_invoiceNumberMin, 'p_invoiceNumberMax' => $p_invoiceNumberMax, 'invoiceList' => $invoiceList]);
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

        if ($request->invoiceDate_dte != null || $request->invoiceDate_dte != '') {
            $editData['invoiceDate_dte'] = date("Y-m-d", strtotime($request->invoiceDate_dte));
        }
        if ($request->paidOn_dte != null || $request->paidOn_dte != '') {
            $editData['paidOn_dte'] = date("Y-m-d", strtotime($request->paidOn_dte));
        }
        DB::table('tbl_invoice')
            ->where('invoice_id', $splitInvoiceId)
            ->update($editData);

        $invoice_id = DB::table('tbl_invoice')
            ->insertGetId([
                'school_id' => $school_id,
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

        $msg = "New invoice has been created with the ID : " . $invoice_id;
        return redirect()->back()->with('success', $msg);
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
            $editData['paymentLoggedBy_id'] = $webUserLoginData->user_id;
            $editData['sentBy_int'] = $webUserLoginData->user_id;
        }
        if ($request->factored_status) {
            $editData['factored_status'] = -1;
        }
        if ($request->creditNote_status) {
            $editData['creditNote_status'] = -1;
        }
        if ($request->invoiceDate_dte != null || $request->invoiceDate_dte != '') {
            $editData['invoiceDate_dte'] = date("Y-m-d", strtotime($request->invoiceDate_dte));
        }
        if ($request->paidOn_dte != null || $request->paidOn_dte != '') {
            $editData['paidOn_dte'] = date("Y-m-d", strtotime($request->paidOn_dte));
        }
        $editData['paymentMethod_int'] = $request->paymentMethod_int;
        $editData['sentOn_dte'] = date('Y-m-d');
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
                'dateFor_dte' => date("Y-m-d", strtotime($request->dateFor_dte)),
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
                        <td>" . (int)$invoiceItem->numItems_dec . "</td>
                        <td>" . (int)$invoiceItem->charge_dec . "</td>
                        <td>" . (int)$invoiceItem->cost_dec . "</td>
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
        $invoiceItem_id = $request->editInvItemId;
        $invoice_id = $request->invoice_id;

        DB::table('tbl_invoiceItem')
            ->where('invoiceItem_id', $invoiceItem_id)
            ->update([
                'description_txt' => $request->description_txt,
                'numItems_dec' => $request->numItems_dec,
                'dateFor_dte' => date("Y-m-d", strtotime($request->dateFor_dte)),
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
                        <td>" . (int)$invoiceItem->numItems_dec . "</td>
                        <td>" . (int)$invoiceItem->charge_dec . "</td>
                        <td>" . (int)$invoiceItem->cost_dec . "</td>
                        <td>$asn</td>
                        <td>$tch</td>
                    </tr>";
            }
        }

        $result['status'] = "success";
        $result['html'] = $html;
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
                        <td>" . (int)$invoiceItem->numItems_dec . "</td>
                        <td>" . (int)$invoiceItem->charge_dec . "</td>
                        <td>" . (int)$invoiceItem->cost_dec . "</td>
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
                ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.invoice_id', $editInvoiceId)
                ->groupBy('tbl_invoice.invoice_id')
                ->first();
            if ($schoolInvoices) {
                $fileExist = 'No';
                if ($schoolInvoices->invoice_path) {
                    if (file_exists(public_path($schoolInvoices->invoice_path))) {
                        $fileExist = 'Yes';
                    }
                }

                if ($fileExist == 'Yes') {
                    $result['exist'] = 'Yes';
                    $result['invoice_path'] = asset($schoolInvoices->invoice_path);
                } else {
                    $invoiceItemList = DB::table('tbl_invoiceItem')
                        ->select('tbl_invoiceItem.*')
                        ->where('tbl_invoiceItem.invoice_id', $editInvoiceId)
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

                    $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail]);
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
            $result['exist'] = 'No';

            $schoolInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
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
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $schoolInvoices->school_id)
                    ->first();
                $sendMail = 'demo@gmail.com';
                if ($contactDet && $contactDet->contactItem_txt) {
                    $sendMail = $contactDet->contactItem_txt;
                }

                $fileExist = 'No';
                if ($schoolInvoices->invoice_path) {
                    if (file_exists(public_path($schoolInvoices->invoice_path))) {
                        $fileExist = 'Yes';
                    }
                }

                if ($fileExist == 'Yes') {
                    $result['exist'] = 'Yes';
                    $result['sendMail'] = $sendMail;
                    $result['invoice_path'] = asset($schoolInvoices->invoice_path);
                } else {
                    $invoiceItemList = DB::table('tbl_invoiceItem')
                        ->select('tbl_invoiceItem.*')
                        ->where('tbl_invoiceItem.invoice_id', $editInvoiceId)
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

                    $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail]);
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
                        $result['invoice_path'] = asset($fPath);
                    }
                }
            }
        } else {
            $result['exist'] = 'No';
        }
        return response()->json($result);
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
                    ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                    ->where('tbl_invoice.invoice_id', $value->invoice_id)
                    ->groupBy('tbl_invoice.invoice_id')
                    ->first();
                if ($schoolInvoices) {
                    $sendMail = 'demo@gmail.com';

                    $fileExist = 'No';
                    if ($schoolInvoices->invoice_path) {
                        if (file_exists(public_path($schoolInvoices->invoice_path))) {
                            $fileExist = 'Yes';
                        }
                    }

                    if ($fileExist == 'Yes') {
                        $invoice_path = asset($schoolInvoices->invoice_path);
                        array_push($attachmentArr, $invoice_path);
                    } else {
                        $invoiceItemList = DB::table('tbl_invoiceItem')
                            ->select('tbl_invoiceItem.*')
                            ->where('tbl_invoiceItem.invoice_id', $value->invoice_id)
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

                        $pdf = PDF::loadView('web.finance.finance_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail]);
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
                }
            }
            if (count($attachmentArr) > 0) {
                $result['exist'] = 'Yes';
                $result['sendMail'] = $sendMail;
                $result['attachmentArr'] = $attachmentArr;
            }
        } else {
            $result['exist'] = 'No';
        }
        return response()->json($result);
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
