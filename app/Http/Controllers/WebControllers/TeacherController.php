<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use Illuminate\Support\Carbon;

class TeacherController extends Controller
{
    public function teachers(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teachers");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $fabTeacherList = DB::table('tbl_teacher')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, CAST(MAX(contactOn_dtm) AS DATE) AS lastContact_dte FROM tbl_teacherContactLog GROUP BY teacher_id) AS t_contact'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_contact.teacher_id');
                    }
                )
                ->select('tbl_teacher.*', 't_contact.teacher_id as contactTeacherId', 't_contact.lastContact_dte')
                ->whereIn('tbl_teacher.teacher_id', function ($query) use ($user_id) {
                    $query->select('link_id')
                        ->from('tbl_userFavourite')
                        ->where('tbl_userFavourite.user_id', $user_id)
                        ->where('tbl_userFavourite.type_int', 1)
                        ->get();
                })
                ->get();
            // dd($fabTeacherList);
            return view("web.teacher.index", ['title' => $title, 'headerTitle' => $headerTitle, 'fabTeacherList' => $fabTeacherList]);
        } else {
            return redirect()->intended('/');
        }
    }
}
