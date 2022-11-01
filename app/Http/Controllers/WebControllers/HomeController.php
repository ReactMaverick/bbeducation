<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;

class HomeController extends Controller
{
    public function dashboard()
    {
        $title = array('pageTitle' => "Dashboard");
        $headerTitle = "Dashboard";        
        // $admin = Auth::guard('subadmin')->user();
        // dd($admin);
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $latestAssignment = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->select('tbl_asn.*', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', DB::raw('SUM(tbl_asnItem.dayPercent_dec) as totalDay'))
                ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                ->groupBy('tbl_asn.asn_id')
                ->get();

            return view("web.dashboard", ['title' => $title, 'latestAssignment' => $latestAssignment, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }
}
