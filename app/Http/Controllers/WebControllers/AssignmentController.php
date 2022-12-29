<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use Illuminate\Support\Carbon;

class AssignmentController extends Controller
{
    public function assignments(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $assignment = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, MIN(asnDate_dte) AS asnStartDate_dte FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS t_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 't_asnItems.asn_id');
                    }
                )
                ->LeftJoin('tbl_description as yearDescription', function ($join) {
                    $join->on('yearDescription.description_int', '=', 'tbl_asn.ageRange_int')
                        ->where(function ($query) {
                            $query->where('yearDescription.descriptionGroup_int', '=', 5);
                        });
                })
                ->LeftJoin('tbl_description as assStatusDescription', function ($join) {
                    $join->on('assStatusDescription.description_int', '=', 'tbl_asn.status_int')
                        ->where(function ($query) {
                            $query->where('assStatusDescription.descriptionGroup_int', '=', 33);
                        });
                })
                ->LeftJoin('tbl_description as teacherProff', function ($join) {
                    $join->on('teacherProff.description_int', '=', 'tbl_asn.professionalType_int')
                        ->where(function ($query) {
                            $query->where('teacherProff.descriptionGroup_int', '=', 7);
                        });
                })
                ->LeftJoin('tbl_description as assType', function ($join) {
                    $join->on('assType.description_int', '=', 'tbl_asn.asnLength_int')
                        ->where(function ($query) {
                            $query->where('assType.descriptionGroup_int', '=', 35);
                        });
                })
                ->select('tbl_asn.*', 'tbl_asnItem.hours_dec', 'tbl_asnItem.dayPercent_dec', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession', 'assType.description_txt as assignmentType', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), DB::raw('IF(t_asnItems.asn_id IS NULL, IF(createdOn_dtm IS NULL, tbl_asn.timestamp_ts, createdOn_dtm), asnStartDate_dte) AS asnStartDate_dte'))
                ->where('tbl_asn.company_id', $company_id);
            $openAssignmentQuery = clone $assignment;
            $closeAssignmentQuery = clone $assignment;
            $pendingAssignmentQuery = clone $assignment;
            $completeAssignmentQuery = clone $assignment;
            $allAssignmentQuery = clone $assignment;

            if ($request->include != 1) {
                $assignment->whereIn('assStatusDescription.description_int', array('1', '2'));
            }
            $assignmentList = $assignment->groupBy('tbl_asn.asn_id')->get();

            $openAssignmentList = $openAssignmentQuery->where('assStatusDescription.description_int', 1)->groupBy('tbl_asn.asn_id')->get();
            $closeAssignmentList = $closeAssignmentQuery->whereIn('assStatusDescription.description_int', array('6', '7'))->groupBy('tbl_asn.asn_id')->get();
            $pendingAssignmentList = $pendingAssignmentQuery->where('assStatusDescription.description_int', 2)->groupBy('tbl_asn.asn_id')->get();
            $completeAssignmentList = $completeAssignmentQuery->where('assStatusDescription.description_int', 3)->groupBy('tbl_asn.asn_id')->get();
            $allAssignmentList = $allAssignmentQuery->groupBy('tbl_asn.asn_id')->get();

            return view("web.assignment.index", ['title' => $title, 'headerTitle' => $headerTitle, 'assignmentList' => $assignmentList, 'openAssignmentList' => $openAssignmentList, 'closeAssignmentList' => $closeAssignmentList, 'pendingAssignmentList' => $pendingAssignmentList, 'completeAssignmentList' => $completeAssignmentList, 'allAssignmentList' => $allAssignmentList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function assignmentDetails(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments Detail");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $assignmentDetail = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, MIN(asnDate_dte) AS asnStartDate_dte FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS t_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 't_asnItems.asn_id');
                    }
                )
                ->LeftJoin('tbl_description as yearDescription', function ($join) {
                    $join->on('yearDescription.description_int', '=', 'tbl_asn.ageRange_int')
                        ->where(function ($query) {
                            $query->where('yearDescription.descriptionGroup_int', '=', 5);
                        });
                })
                ->LeftJoin('tbl_description as assStatusDescription', function ($join) {
                    $join->on('assStatusDescription.description_int', '=', 'tbl_asn.status_int')
                        ->where(function ($query) {
                            $query->where('assStatusDescription.descriptionGroup_int', '=', 33);
                        });
                })
                ->LeftJoin('tbl_description as teacherProff', function ($join) {
                    $join->on('teacherProff.description_int', '=', 'tbl_asn.professionalType_int')
                        ->where(function ($query) {
                            $query->where('teacherProff.descriptionGroup_int', '=', 7);
                        });
                })
                ->LeftJoin('tbl_description as assType', function ($join) {
                    $join->on('assType.description_int', '=', 'tbl_asn.asnLength_int')
                        ->where(function ($query) {
                            $query->where('assType.descriptionGroup_int', '=', 35);
                        });
                })
                ->select('tbl_asn.*', 'tbl_asnItem.hours_dec', 'tbl_asnItem.dayPercent_dec', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession', 'assType.description_txt as assignmentType', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), DB::raw('IF(t_asnItems.asn_id IS NULL, IF(createdOn_dtm IS NULL, tbl_asn.timestamp_ts, createdOn_dtm), asnStartDate_dte) AS asnStartDate_dte'))
                ->where('tbl_asn.asn_id', $id)
                ->groupBy('tbl_asn.asn_id')
                ->first();

            $ageRangeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 5)
                ->get();

            $subjectList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 6)
                ->get();

            $yearGrList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 34)
                ->get();

            $assLengthList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 35)
                ->get();

            $profTypeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 7)
                ->get();

            $studentList = DB::table('tbl_student')
                ->select('tbl_student.*')
                ->where('tbl_student.isCurrent_ysn', -1)
                ->get();

            $assignmentStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 33)
                ->get();

            return view("web.assignment.assignment_detail", ['title' => $title, 'headerTitle' => $headerTitle, 'assignmentDetail' => $assignmentDetail, 'ageRangeList' => $ageRangeList, 'subjectList' => $subjectList, 'yearGrList' => $yearGrList, 'assLengthList' => $assLengthList, 'profTypeList' => $profTypeList, 'studentList' => $studentList, 'assignmentStatusList' => $assignmentStatusList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function assignmentContact(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments Contact");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;

            return view("web.assignment.assignment_contact", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function assignmentCandidate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments Candidate");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;

            return view("web.assignment.assignment_candidate", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function assignmentSchool(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments School Detail");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;

            return view("web.assignment.assignment_school", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function assignmentFinance(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments Finance");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;

            return view("web.assignment.assignment_finance", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }
}
