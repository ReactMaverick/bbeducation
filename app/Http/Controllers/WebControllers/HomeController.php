<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        $title = array('pageTitle' => "Dashboard");
        $headerTitle = "Dashboard";
        // $admin = Auth::guard('subadmin')->user();
        // dd($admin);
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            if ($request->date) {
                $weekStartDate = $request->date;
            } else {
                $now = Carbon::now();
                $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            }
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));

            $latestAssignment = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
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
                ->select('tbl_asn.*', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', DB::raw('SUM(tbl_asnItem.dayPercent_dec) as daysThisWeek'), DB::raw('SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS predictedGP'), DB::raw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking'), DB::raw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing'), 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession')
                ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                // ->whereDate('tbl_asnItem.asnDate_dte', '>=', $weekStartDate)
                // ->whereDate('tbl_asnItem.asnDate_dte', '<=', $plusFiveDate)
                ->groupBy('tbl_asn.asn_id')
                ->get();
            $sideBarData = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->select(DB::raw('SUM(tbl_asnItem.dayPercent_dec) as daysThisWeek'), DB::raw('SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS predictedGP'), DB::raw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking'), DB::raw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing'))
                ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                // ->whereDate('tbl_asnItem.asnDate_dte', '>=', $weekStartDate)
                // ->whereDate('tbl_asnItem.asnDate_dte', '<=', $plusFiveDate)
                ->get();
            // dd($sideBarData);
            return view("web.dashboard", ['title' => $title, 'latestAssignment' => $latestAssignment, 'headerTitle' => $headerTitle, 'weekStartDate' => $weekStartDate, 'sideBarData' => $sideBarData]);
        } else {
            return redirect()->intended('/');
        }
    }
}
