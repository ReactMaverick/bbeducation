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

            $ageRangeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 28)
                ->get();
            $schoolTypeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 30)
                ->get();
            $laBoroughList = DB::table('tbl_localAuthority')
                ->select('tbl_localAuthority.*')
                ->where('tbl_localAuthority.coveredByBumbleBee_status', '<>', 0)
                ->orderBy('laName_txt', 'ASC')
                ->get();

            $schoolList = array();
            $srchCnt = 0;
            if ($request->search) {
                $schoolQry = DB::table('tbl_school')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_contactItemSch.school_id', '=', 'tbl_school.school_id')
                    ->LeftJoin('tbl_schoolContact', 'tbl_schoolContact.school_id', '=', 'tbl_school.school_id')
                    ->LeftJoin('tbl_localAuthority', 'tbl_localAuthority.la_id', '=', 'tbl_school.la_id')
                    ->LeftJoin('tbl_schoolContactLog', 'tbl_schoolContactLog.school_id', '=', 'tbl_school.school_id')
                    ->LeftJoin('tbl_asn', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                    ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                    ->LeftJoin('tbl_description as AgeRange', function ($join) {
                        $join->on('AgeRange.description_int', '=', 'tbl_school.ageRange_int')
                            ->where(function ($query) {
                                $query->where('AgeRange.descriptionGroup_int', '=', 28);
                            });
                    })
                    ->LeftJoin('tbl_description as SchoolType', function ($join) {
                        $join->on('SchoolType.description_int', '=', 'tbl_school.type_int')
                            ->where(function ($query) {
                                $query->where('SchoolType.descriptionGroup_int', '=', 30);
                            });
                    })
                    ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', DB::raw('SUM(IF(tbl_asnItem.hours_dec IS NOT NULL, tbl_asnItem.hours_dec / 6, tbl_asnItem.dayPercent_dec)) AS days_dec'), DB::raw('MAX(tbl_schoolContactLog.contactOn_dtm) AS lastContact_dte'))
                    ->whereIn('tbl_school.la_id', function ($query) {
                        $query->select('la_id')
                            ->from('tbl_localAuthority')
                            ->where('tbl_localAuthority.coveredByBumbleBee_status', '<>', 0)
                            ->get();
                    });

                if ($request->search_input) {
                    $srchCnt = 1;
                    $search_input = $request->search_input;
                    $schoolQry->where(function ($query) use ($search_input) {
                        $query->where('tbl_school.name_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('firstName_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('surname_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere(DB::raw("CONCAT(`firstName_txt`, ' ', `surname_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere('contactItem_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('tbl_school.postcode_txt', 'LIKE', '%' . $search_input . '%');
                    });
                }

                if ($request->ageRangeId) {
                    $srchCnt = 1;
                    $schoolQry->where('tbl_school.ageRange_int', $request->ageRangeId);
                }

                if ($request->schoolTypeId) {
                    $srchCnt = 1;
                    $schoolQry->where('tbl_school.type_int', $request->schoolTypeId);
                }

                if ($request->laId) {
                    $srchCnt = 1;
                    $schoolQry->where('tbl_school.la_id', $request->laId);
                }

                if ($request->lastContactRadio && $request->lasContactDate) {
                    if ($request->lastContactRadio == 'Before') {
                        $srchCnt = 1;
                        $schoolQry->whereDate('tbl_schoolContactLog.contactOn_dtm', '<', $request->lasContactDate);
                    }
                    if ($request->lastContactRadio == 'After') {
                        $srchCnt = 1;
                        $schoolQry->whereDate('tbl_schoolContactLog.contactOn_dtm', '>', $request->lasContactDate);
                    }
                }

                if ($request->dayBookedRadio && $request->booked_day) {
                    if ($request->dayBookedRadio == 'More') {
                        $srchCnt = 1;
                        // $schoolQry->whereRaw('SUM(IF(tbl_asnItem.hours_dec IS NOT NULL, tbl_asnItem.hours_dec / 6, tbl_asnItem.dayPercent_dec)', '>', $request->booked_day);
                    }
                    if ($request->dayBookedRadio == 'Less') {
                        $srchCnt = 1;
                        // $schoolQry->whereRaw('SUM(IF(tbl_asnItem.hours_dec IS NOT NULL, tbl_asnItem.hours_dec / 6, tbl_asnItem.dayPercent_dec)', '<', $request->booked_day);
                    }
                }

                if ($srchCnt != 1) {
                    $schoolQry->groupBy('tbl_school.school_id')
                        ->limit(50);
                } else {
                    $schoolQry->groupBy('tbl_school.school_id');
                }

                $schoolList = $schoolQry->get();
            }

            return view("web.school.school_search", ['title' => $title, 'headerTitle' => $headerTitle, 'ageRangeList' => $ageRangeList, 'schoolTypeList' => $schoolTypeList, 'laBoroughList' => $laBoroughList, 'schoolList' => $schoolList]);
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

    public function schoolContact(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Contact");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.school.school_contact", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolAssignment(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Assignment");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.school.school_assignment", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolFinance(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Finance");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.school.school_finance", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolTeacher(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Teacher");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.school.school_teacher", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }
}
