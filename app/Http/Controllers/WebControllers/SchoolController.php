<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use Illuminate\Support\Carbon;

class SchoolController extends Controller
{
    public function schools(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Schools");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $fabSchoolList = DB::table('tbl_school')
                ->leftJoin(
                    DB::raw('(SELECT school_id, CAST(MAX(contactOn_dtm) AS DATE) AS lastContact_dte FROM tbl_schoolContactLog GROUP BY school_id) AS t_contact'),
                    function ($join) {
                        $join->on('tbl_school.school_id', '=', 't_contact.school_id');
                    }
                )
                ->select('tbl_school.*', 't_contact.school_id as contactSchoolId', 't_contact.lastContact_dte')
                ->whereIn('tbl_school.school_id', function ($query) use ($user_id) {
                    $query->select('link_id')
                        ->from('tbl_userFavourite')
                        ->where('tbl_userFavourite.user_id', $user_id)
                        ->where('tbl_userFavourite.type_int', 2)
                        ->get();
                })
                ->get();
            // dd($fabSchoolList);

            return view("web.school.index", ['title' => $title, 'headerTitle' => $headerTitle, 'fabSchoolList' => $fabSchoolList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolSearch(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Search");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.school.school_search", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolDetail(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Detail");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.school.school_detail", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }
}
