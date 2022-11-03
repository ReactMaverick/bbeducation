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
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate .' +4 days'));

            $latestAssignment = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->select('tbl_asn.*', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', DB::raw('SUM(tbl_asnItem.dayPercent_dec) as totalDay'))
                ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                // ->whereDate('tbl_asnItem.asnDate_dte', '>=', $weekStartDate)
                // ->whereDate('tbl_asnItem.asnDate_dte', '<=', $plusFiveDate)
                ->groupBy('tbl_asn.asn_id')
                ->get();

            return view("web.dashboard", ['title' => $title, 'latestAssignment' => $latestAssignment, 'headerTitle' => $headerTitle, 'weekStartDate' => $weekStartDate]);
        } else {
            return redirect()->intended('/');
        }
    }
}
