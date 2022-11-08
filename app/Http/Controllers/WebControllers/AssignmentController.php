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

            $assignmentList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
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
                ->select('tbl_asn.*', 'tbl_asnItem.hours_dec', 'tbl_asnItem.dayPercent_dec', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession', 'assType.description_txt as assignmentType', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'),)
                // ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                ->groupBy('tbl_asn.asn_id')
                ->get();

            return view("web.assignment.index", ['title' => $title, 'headerTitle' => $headerTitle, 'assignmentList' => $assignmentList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function assignmentDetails(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments Detail");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;

            return view("web.assignment.assignment_detail", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }
}
