<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use PDF;
use Illuminate\Support\Facades\Validator;
use Hash;

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
                ->where('tbl_school.company_id', $company_id)
                ->whereIn('tbl_school.school_id', function ($query) use ($user_id) {
                    $query->select('link_id')
                        ->from('tbl_userFavourite')
                        ->where('tbl_userFavourite.user_id', $user_id)
                        ->where('tbl_userFavourite.type_int', 2)
                        ->get();
                })
                ->get();
            // dd($fabSchoolList);
            $laBoroughList = DB::table('tbl_localAuthority')
                ->select('tbl_localAuthority.*')
                ->where('tbl_localAuthority.coveredByBumbleBee_status', '<>', 0)
                ->orderBy('laName_txt', 'ASC')
                ->get();
            $ageRangeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 28)
                ->get();
            $schoolTypeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 30)
                ->get();
            $religiousList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 29)
                ->get();

            return view("web.school.index", ['title' => $title, 'headerTitle' => $headerTitle, 'fabSchoolList' => $fabSchoolList, 'laBoroughList' => $laBoroughList, 'ageRangeList' => $ageRangeList, 'schoolTypeList' => $schoolTypeList, 'religiousList' => $religiousList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function checkSchoolMailExist(Request $request)
    {
        $loginMail = $request->loginMail;
        $teacherDet = DB::table('tbl_school')
            ->select('tbl_school.*')
            ->where('login_mail', $loginMail)
            ->get();
        if (count($teacherDet) > 0) {
            return "Yes";
        } else {
            return "No";
        }
    }

    public function newSchoolInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;

            $lat_txt = 0;
            if ($request->lat_txt) {
                $lat_txt = $request->lat_txt;
            }
            $lon_txt = 0;
            if ($request->lon_txt) {
                $lon_txt = $request->lon_txt;
            }
            $activeStatus = 0;
            if ($request->activeStatus) {
                $activeStatus = 1;
            }
            $school_id = DB::table('tbl_school')
                ->insertGetId([
                    'company_id' => $company_id,
                    'name_txt' => $request->name_txt,
                    'login_mail' => $request->login_mail,
                    'address1_txt' => $request->address1_txt,
                    'address2_txt' => $request->address2_txt,
                    'address3_txt' => $request->address3_txt,
                    'address4_txt' => $request->address4_txt,
                    'postcode_txt' => $request->postcode_txt,
                    'main_contact_no' => $request->main_contact_no,
                    'lat_txt' => $lat_txt,
                    'lon_txt' => $lon_txt,
                    'la_id' => $request->la_id,
                    'ageRange_int' => $request->ageRange_int,
                    'type_int' => $request->type_int,
                    'religion_int' => $request->religion_int,
                    'website_txt' => $request->website_txt,
                    'activeStatus' => $activeStatus,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
            if ($request->passwordReset && $request->login_mail) {
                // $mail = 'sudip.websadroit@gmail.com';
                $uID = base64_encode($school_id);
                $mailData['companyDetail'] = $companyDetail;
                $mailData['name_txt'] = $request->name_txt;
                $mailData['mail'] = $request->login_mail;
                $mailData['rUrl'] = url('/school/set-password') . '/' . $uID;
                $myVar = new AlertController();
                $myVar->school_reset_password($mailData);
            }

            return redirect('/school-detail/' . $school_id)->with('success', "School added successfully.");
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
                    ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', DB::raw("(SELECT round(SUM(IF(hours_dec IS NOT NULL, hours_dec / 6, dayPercent_dec)),2) FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE school_id = tbl_school.school_id GROUP BY school_id) as days_dec"), DB::raw('MAX(tbl_schoolContactLog.contactOn_dtm) AS lastContact_dte'))
                    ->where('tbl_school.company_id', $company_id)
                    ->whereIn('tbl_school.la_id', function ($query) {
                        $query->select('la_id')
                            ->from('tbl_localAuthority')
                            ->where('tbl_localAuthority.coveredByBumbleBee_status', '<>', 0)
                            ->get();
                    });

                if ($request->search_input) {
                    $srchCnt = 1;
                    $search_input = str_replace(" ", "", $request->search_input);
                    $schoolQry->where(function ($query) use ($search_input) {
                        $query->where(DB::raw("REPLACE(name_txt, ' ', '')"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere('firstName_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('surname_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere(DB::raw("CONCAT(`firstName_txt`, `surname_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere(DB::raw("REPLACE(contactItem_txt, ' ', '')"), 'LIKE', '%' . $search_input . '%')
                            ->orWhere(DB::raw("REPLACE(postcode_txt, ' ', '')"), 'LIKE', '%' . $search_input . '%');
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
                        $schoolQry->where(DB::raw("(SELECT SUM(IF(hours_dec IS NOT NULL, hours_dec / 6, dayPercent_dec)) FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE school_id = tbl_school.school_id GROUP BY school_id)"), '>', $request->booked_day);
                    }
                    if ($request->dayBookedRadio == 'Less') {
                        $srchCnt = 1;
                        $schoolQry->where(DB::raw("(SELECT SUM(IF(hours_dec IS NOT NULL, hours_dec / 6, dayPercent_dec)) FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE school_id = tbl_school.school_id GROUP BY school_id)"), '<', $request->booked_day);
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

    public function schoolDetail(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Detail");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                // ->take(1)
                ->first();
            // dd($schoolDetail);
            $schoolContacts = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_description as JobRole', function ($join) {
                    $join->on('JobRole.description_int', '=', 'tbl_schoolContact.jobRole_int')
                        ->where(function ($query) {
                            $query->where('JobRole.descriptionGroup_int', '=', 11);
                        });
                })
                ->LeftJoin('tbl_description as TitleTbl', function ($join) {
                    $join->on('TitleTbl.description_int', '=', 'tbl_schoolContact.title_int')
                        ->where(function ($query) {
                            $query->where('TitleTbl.descriptionGroup_int', '=', 1);
                        });
                })
                ->select('tbl_schoolContact.*', 'JobRole.description_txt as jobRole_txt', 'TitleTbl.description_txt as title_txt')
                ->where('tbl_schoolContact.school_id', $id)
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->get();

            $contactItems = DB::table('tbl_contactItemSch')
                ->LeftJoin('tbl_schoolContact', 'tbl_contactItemSch.schoolContact_id', '=', 'tbl_schoolContact.contact_id')
                ->LeftJoin('tbl_description as JobRole', function ($join) {
                    $join->on('JobRole.description_int', '=', 'tbl_schoolContact.jobRole_int')
                        ->where(function ($query) {
                            $query->where('JobRole.descriptionGroup_int', '=', 11);
                        });
                })
                ->LeftJoin('tbl_description as ContactType', function ($join) {
                    $join->on('ContactType.description_int', '=', 'tbl_contactItemSch.type_int')
                        ->where(function ($query) {
                            $query->where('ContactType.descriptionGroup_int', '=', 13);
                        });
                })
                ->select('tbl_contactItemSch.*', 'JobRole.description_txt as jobRole_txt', 'ContactType.description_txt as type_txt', 'tbl_schoolContact.title_int', 'tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_schoolContact.jobRole_int', 'tbl_schoolContact.receiveTimesheets_status', 'tbl_schoolContact.receiveInvoice_status', 'tbl_schoolContact.receiveVetting_status', 'tbl_schoolContact.isCurrent_status')
                ->where('tbl_contactItemSch.school_id', $id)
                ->where(function ($query) {
                    $query->where('tbl_contactItemSch.schoolContact_id', NULL);
                    // ->orWhere('tbl_schoolContact.isCurrent_status', '=', '-1');
                })
                ->get();

            $titleList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 1)
                ->get();

            $jobRoleList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 11)
                ->get();

            $contactMethodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 13)
                ->get();

            return view("web.school.school_detail", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'schoolDetail' => $schoolDetail, 'schoolContacts' => $schoolContacts, 'contactItems' => $contactItems, 'school_id' => $id, 'titleList' => $titleList, 'jobRoleList' => $jobRoleList, 'contactMethodList' => $contactMethodList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function checkSchoolLogMail(Request $request)
    {
        $school_id = $request->school_id;
        $rData['lMailExist'] = "No";
        $rData['loginMail'] = "";
        $rData['contactMail'] = [];

        $schoolDetail = DB::table('tbl_school')
            ->where('tbl_school.school_id', $school_id)
            ->first();
        if ($schoolDetail) {
            // if ($schoolDetail->login_mail) {
            //     $rData['lMailExist'] = "Yes";
            //     $rData['loginMail'] = $schoolDetail->login_mail;
            // } else {

            // }
            $contactItemList = DB::table('tbl_contactItemSch')
                ->LeftJoin('tbl_description', function ($join) {
                    $join->on('tbl_description.description_int', '=', 'tbl_contactItemSch.type_int')
                        ->where(function ($query) {
                            $query->where('tbl_description.descriptionGroup_int', '=', 13);
                        });
                })
                ->select('tbl_contactItemSch.*', 'tbl_description.description_txt as type_txt')
                ->where('tbl_contactItemSch.school_id', $school_id)
                ->where('tbl_contactItemSch.type_int', 1)
                ->orderBy('tbl_contactItemSch.type_int')
                ->get();
            $rData['contactMail'] = $contactItemList;
        }
        return response()->json(['rData' => $rData]);
    }

    public function resendSchoolPasswordLink(Request $request)
    {
        $school_id = $request->school_id;
        $contactItemSch_id = $request->log_mail;

        $contDet = DB::table('tbl_contactItemSch')
            ->where('contactItemSch_id', $contactItemSch_id)
            ->first();

        if ($contDet) {
            $log_mail = $contDet->contactItem_txt;
            $logContId = $contDet->schoolContact_id;
            $logContItemId = $contDet->contactItemSch_id;
        } else {
            $log_mail = "";
            $logContId = "";
            $logContItemId = "";
        }

        $mailExist = DB::table('tbl_school')
            ->where('login_mail', $log_mail)
            ->where('school_id', '!=', $school_id)
            ->first();
        if ($mailExist) {
            return "notEdit";
        }

        DB::table('tbl_school')
            ->where('school_id', $school_id)
            ->update([
                'login_mail' => $log_mail,
                'logContId' => $logContId,
                'logContItemId' => $logContItemId
            ]);

        $schoolDetail = DB::table('tbl_school')
            ->where('tbl_school.school_id', $school_id)
            ->first();
        if ($schoolDetail && $schoolDetail->login_mail) {
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $schoolDetail->company_id)
                ->first();

            $uID = base64_encode($school_id);
            $mailData['companyDetail'] = $companyDetail;
            $mailData['name_txt'] = $schoolDetail->name_txt;
            $mailData['mail'] = $schoolDetail->login_mail;
            $mailData['rUrl'] = url('/school/set-password') . '/' . $uID;
            $myVar = new AlertController();
            $myVar->school_reset_password($mailData);

            return true;
        } else {
            return false;
        }
    }

    public function schoolAddressUpdate(Request $request)
    {
        $school_id = $request->school_id;
        $lat_txt = 0;
        if ($request->lat_txt) {
            $lat_txt = $request->lat_txt;
        }
        $lon_txt = 0;
        if ($request->lon_txt) {
            $lon_txt = $request->lon_txt;
        }
        DB::table('tbl_school')->where('school_id', '=', $school_id)
            ->update([
                'address1_txt' =>    $request->address1_txt,
                'address2_txt' =>    $request->address2_txt,
                'address3_txt' =>    $request->address3_txt,
                'address4_txt' =>    $request->address4_txt,
                'postcode_txt' =>    $request->postcode_txt,
                'baseRate_dec' =>    $request->baseRate_dec,
                'website_txt' =>    $request->website_txt,
                'main_contact_no' =>    $request->main_contact_no,
                'lat_txt' => $lat_txt,
                'lon_txt' => $lon_txt
            ]);

        return redirect('/school-detail/' . $school_id)->with('success', "Address updated successfully.");
    }

    public function schoolContactInsert(Request $request)
    {
        $school_id = $request->school_id;
        $receiveVetting_status = 0;
        if ($request->receiveVetting_status) {
            $receiveVetting_status = -1;
        }
        $receiveTimesheets_status = 0;
        if ($request->receiveTimesheets_status) {
            $receiveTimesheets_status = -1;
        }
        $receiveInvoice_status = 0;
        if ($request->receiveInvoice_status) {
            $receiveInvoice_status = -1;
        }
        DB::table('tbl_schoolContact')
            ->insert([
                'school_id' => $school_id,
                'title_int' => $request->title_int,
                'firstName_txt' => $request->firstName_txt,
                'surname_txt' => $request->surname_txt,
                'jobRole_int' => $request->jobRole_int,
                'receiveTimesheets_status' => $receiveTimesheets_status,
                'receiveInvoice_status' => $receiveInvoice_status,
                'receiveVetting_status' => $receiveVetting_status,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        return redirect('/school-detail/' . $school_id)->with('success', "Contact added successfully.");
    }

    public function getSchoolContactDetail(Request $request)
    {
        $input = $request->all();
        $contact_id = $input['contact_id'];
        $schoolId = $input['schoolId'];

        $contactDetail = DB::table('tbl_schoolContact')
            ->where('contact_id', "=", $contact_id)
            ->first();

        $timesheetContact = DB::table('tbl_schoolContact')
            ->where('contact_id', "!=", $contact_id)
            ->where('school_id', "=", $schoolId)
            ->where('receiveTimesheets_status', "=", '-1')
            ->first();
        $sheetContactExit = 0;
        if ($timesheetContact) {
            $sheetContactExit = 1;
        }

        $titleList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 1)
            ->get();

        $jobRoleList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 11)
            ->get();

        $view = view("web.school.contact_edit_view", ['contactDetail' => $contactDetail, 'titleList' => $titleList, 'jobRoleList' => $jobRoleList, 'sheetContactExit' => $sheetContactExit])->render();
        return response()->json(['html' => $view]);
    }

    public function schoolContactUpdate(Request $request)
    {
        $contact_id = $request->editContactId;
        $school_id = $request->school_id;
        $editData = array();
        $receiveVetting_status = 0;
        if ($request->receiveVetting_status) {
            $receiveVetting_status = -1;
        }
        $receiveTimesheets_status = 0;
        if ($request->receiveTimesheets_status) {
            $receiveTimesheets_status = -1;
        }
        $receiveInvoice_status = 0;
        if ($request->receiveInvoice_status) {
            $receiveInvoice_status = -1;
        }
        $editData['title_int'] = $request->title_int;
        $editData['firstName_txt'] = $request->firstName_txt;
        $editData['surname_txt'] = $request->surname_txt;
        $editData['jobRole_int'] = $request->jobRole_int;
        $editData['receiveTimesheets_status'] = $receiveTimesheets_status;
        $editData['receiveInvoice_status'] = $receiveInvoice_status;
        $editData['receiveVetting_status'] = $receiveVetting_status;
        $editData['title_int'] = $request->title_int;

        if (count($editData) > 0) {
            $editData['timestamp_ts'] = date('Y-m-d H:i:s');
            DB::table('tbl_schoolContact')->where('contact_id', '=', $contact_id)
                ->update($editData);
        }

        return redirect('/school-detail/' . $school_id)->with('success', "Contact updated successfully.");
    }

    public function schoolContactDelete(Request $request)
    {
        $contact_id = $request->contact_id;
        $Detail = DB::table('tbl_schoolContact')
            ->where('contact_id', '=', $contact_id)
            ->first();

        DB::table('tbl_contactItemSch')
            ->where('schoolContact_id', '=', $contact_id)
            ->delete();

        DB::table('tbl_schoolContactLog')
            ->where('spokeTo_id', '=', $contact_id)
            ->delete();

        DB::table('tbl_schoolContact')
            ->where('contact_id', '=', $contact_id)
            ->delete();

        if ($Detail) {
            $userExist = DB::table('tbl_school')
                ->where('tbl_school.school_id', $Detail->school_id)
                ->where('tbl_school.logContId', $contact_id)
                ->first();
            if ($userExist) {
                DB::table('tbl_school')
                    ->where('school_id', '=', $Detail->school_id)
                    ->update([
                        'login_mail' => null,
                        'logContId' => null,
                        'logContItemId' => null,
                        'password' => null
                    ]);
            }
        }

        return 1;
    }

    public function schoolContactItemInsert(Request $request)
    {
        $school_id = $request->school_id;
        $receiveInvoices_status = 0;
        if ($request->receiveInvoices_status) {
            $receiveInvoices_status = -1;
        }
        $schoolContact_id = null;
        if ($request->schoolContact_id) {
            $schoolContact_id = $request->schoolContact_id;
        }
        if ($request->schoolMainId) {
            $schoolContact_id = null;
        }
        DB::table('tbl_contactItemSch')
            ->insert([
                'school_id' => $school_id,
                'schoolContact_id' => $schoolContact_id,
                'type_int' => $request->type_int,
                'contactItem_txt' => $request->contactItem_txt,
                'receiveInvoices_status' => $receiveInvoices_status,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        return redirect('/school-detail/' . $school_id)->with('success', "Contact item added successfully.");
    }

    public function fetchContactItemList(Request $request)
    {
        $input = $request->all();
        $school_id = $input['school_id'];
        $contact_id = $input['contact_id'];
        $selectStat = $input['selectStat'];

        $contact = DB::table('tbl_contactItemSch')
            ->LeftJoin('tbl_schoolContact', 'tbl_contactItemSch.schoolContact_id', '=', 'tbl_schoolContact.contact_id')
            ->LeftJoin('tbl_description as JobRole', function ($join) {
                $join->on('JobRole.description_int', '=', 'tbl_schoolContact.jobRole_int')
                    ->where(function ($query) {
                        $query->where('JobRole.descriptionGroup_int', '=', 11);
                    });
            })
            ->LeftJoin('tbl_description as ContactType', function ($join) {
                $join->on('ContactType.description_int', '=', 'tbl_contactItemSch.type_int')
                    ->where(function ($query) {
                        $query->where('ContactType.descriptionGroup_int', '=', 13);
                    });
            })
            ->select('tbl_contactItemSch.*', 'JobRole.description_txt as jobRole_txt', 'ContactType.description_txt as type_txt', 'tbl_schoolContact.title_int', 'tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_schoolContact.jobRole_int', 'tbl_schoolContact.receiveTimesheets_status', 'tbl_schoolContact.receiveInvoice_status', 'tbl_schoolContact.receiveVetting_status', 'tbl_schoolContact.isCurrent_status')
            ->where('tbl_contactItemSch.school_id', $school_id);
        if ($selectStat == 'Yes') {
            $contact->where(function ($query) use ($contact_id) {
                $query->where('tbl_contactItemSch.schoolContact_id', $contact_id)
                    ->orWhere('tbl_contactItemSch.schoolContact_id', NULL);
                // ->orWhere('tbl_schoolContact.isCurrent_status', '=', '-1');
            });
        } else {
            $contact->where(function ($query) {
                $query->where('tbl_contactItemSch.schoolContact_id', NULL);
            });
        }
        $contactItems = $contact->get();

        $html = '';
        if (count($contactItems) > 0) {
            foreach ($contactItems as $key2 => $Items) {
                $name = '';
                if ($Items->schoolContact_id == '') {
                    $name = 'School Main';
                } else {
                    if ($Items->firstName_txt != '' && $Items->surname_txt != '') {
                        $name = $Items->firstName_txt . ' ' . $Items->surname_txt;
                    } elseif ($Items->firstName_txt != '' && $Items->surname_txt == '') {
                        $name = $Items->firstName_txt;
                    } elseif ($Items->title_int != '' && $Items->surname_txt != '') {
                        $name = $Items->title_txt . ' ' . $Items->surname_txt;
                    } elseif ($Items->jobRole_int != '') {
                        $name = $Items->jobRole_txt . ' (name unknown)';
                    } else {
                        $name = 'Name unknown';
                    }
                }
                // $html .= '<tr class="school-detail-table-data editContactItemRow"
                //     id="editContactItemRow' . $Items->contactItemSch_id . '"
                //     onclick="contactItemRowSelect(' . $Items->contactItemSch_id . ', ' . $name . ')">
                //     <td>' . $name . '</td>
                //     <td>' . $Items->type_txt . '</td>
                //     <td>' . $Items->contactItem_txt . '</td>
                // </tr>';
                $html .= "<tr class='school-detail-table-data editContactItemRow'
                    id='editContactItemRow$Items->contactItemSch_id'  onclick='contactItemRowSelect($Items->contactItemSch_id, \"$name\")'>
                    <td>$name</td>
                    <td>$Items->type_txt</td>
                    <td>$Items->contactItem_txt</td>
                </tr>";
            }
        } else {
            $html .= '<tr>
                <td colspan="3">
                    Empty contact item.
                </td>
            </tr>';
        }

        return response()->json(['html' => $html]);
    }

    public function getContactItemDetail(Request $request)
    {
        $input = $request->all();
        $contactItemSch_id = $input['editContactItemId'];
        $school_id = $input['contactItemSchoolId'];

        $contactItemDetail = DB::table('tbl_contactItemSch')
            ->where('contactItemSch_id', "=", $contactItemSch_id)
            ->first();

        $contactMethodList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 13)
            ->get();

        $schoolContacts = DB::table('tbl_schoolContact')
            ->LeftJoin('tbl_description as JobRole', function ($join) {
                $join->on('JobRole.description_int', '=', 'tbl_schoolContact.jobRole_int')
                    ->where(function ($query) {
                        $query->where('JobRole.descriptionGroup_int', '=', 11);
                    });
            })
            ->LeftJoin('tbl_description as TitleTbl', function ($join) {
                $join->on('TitleTbl.description_int', '=', 'tbl_schoolContact.title_int')
                    ->where(function ($query) {
                        $query->where('TitleTbl.descriptionGroup_int', '=', 1);
                    });
            })
            ->select('tbl_schoolContact.*', 'JobRole.description_txt as jobRole_txt', 'TitleTbl.description_txt as title_txt')
            ->where('tbl_schoolContact.school_id', $school_id)
            ->where('tbl_schoolContact.isCurrent_status', '-1')
            ->get();

        $view = view("web.school.contact_item_edit_view", ['contactItemDetail' => $contactItemDetail, 'contactMethodList' => $contactMethodList, 'schoolContacts' => $schoolContacts])->render();
        return response()->json(['html' => $view]);
    }

    public function getContactItemEmail(Request $request)
    {
        $input = $request->all();
        $contactItemSch_id = $input['editContactItemId'];
        $school_id = $input['contactItemSchoolId'];

        $Detail = DB::table('tbl_contactItemSch')
            ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_contactItemSch.school_id')
            ->select('tbl_contactItemSch.*', 'tbl_school.name_txt')
            ->where('contactItemSch_id', "=", $contactItemSch_id)
            ->first();

        return response()->json(['Detail' => $Detail]);
    }

    public function getContactItemPhone(Request $request)
    {
        $input = $request->all();
        $contactItemSch_id = $input['editContactItemId'];
        $school_id = $input['contactItemSchoolId'];

        $Detail = DB::table('tbl_contactItemSch')
            ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_contactItemSch.school_id')
            ->select('tbl_contactItemSch.*', 'tbl_school.name_txt')
            ->where('contactItemSch_id', "=", $contactItemSch_id)
            ->first();

        return response()->json(['Detail' => $Detail]);
    }

    public function schoolContactItemUpdate(Request $request)
    {
        $contactItemSch_id = $request->editContactItemId;
        $school_id = $request->school_id;
        $receiveInvoices_status = 0;
        if ($request->receiveInvoices_status) {
            $receiveInvoices_status = -1;
        }
        $schoolContact_id = null;
        if ($request->schoolContact_id) {
            $schoolContact_id = $request->schoolContact_id;
        }
        if ($request->schoolMainId) {
            $schoolContact_id = null;
        }
        DB::table('tbl_contactItemSch')
            ->where('contactItemSch_id', '=', $contactItemSch_id)
            ->update([
                'schoolContact_id' => $schoolContact_id,
                'type_int' => $request->type_int,
                'contactItem_txt' => $request->contactItem_txt,
                'receiveInvoices_status' => $receiveInvoices_status,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        return redirect('/school-detail/' . $school_id)->with('success', "Contact item updated successfully.");
    }

    public function schoolContactItemDelete(Request $request)
    {
        $contactItemSch_id = $request->editContactItemId;
        $Detail = DB::table('tbl_contactItemSch')
            ->where('contactItemSch_id', '=', $contactItemSch_id)
            ->first();

        DB::table('tbl_contactItemSch')
            ->where('contactItemSch_id', '=', $contactItemSch_id)
            ->delete();

        if ($Detail) {
            $userExist = DB::table('tbl_school')
                ->where('tbl_school.school_id', $Detail->school_id)
                ->where('tbl_school.logContItemId', $contactItemSch_id)
                ->first();
            if ($userExist) {
                DB::table('tbl_school')
                    ->where('school_id', '=', $Detail->school_id)
                    ->update([
                        'login_mail' => null,
                        'logContId' => null,
                        'logContItemId' => null,
                        'password' => null
                    ]);
            }
        }

        return 1;
    }

    public function schoolContact(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Contact");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                // ->take(1)
                ->first();

            $ContactHistory = DB::table('tbl_schoolContactLog')
                ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_schoolContactLog.contactBy_id')
                ->LeftJoin('tbl_description', function ($join) {
                    $join->on('tbl_description.description_int', '=', 'tbl_schoolContactLog.method_int')
                        ->where(function ($query) {
                            $query->where('tbl_description.descriptionGroup_int', '=', 17);
                        });
                })
                ->select('tbl_schoolContactLog.*', 'tbl_description.description_txt as method_txt', 'tbl_user.firstName_txt', 'tbl_user.surname_txt')
                ->where('tbl_schoolContactLog.school_id', $id)
                ->orderBy('tbl_schoolContactLog.contactOn_dtm', 'DESC')
                ->get();

            $schoolContacts = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_description as JobRole', function ($join) {
                    $join->on('JobRole.description_int', '=', 'tbl_schoolContact.jobRole_int')
                        ->where(function ($query) {
                            $query->where('JobRole.descriptionGroup_int', '=', 11);
                        });
                })
                ->LeftJoin('tbl_description as TitleTbl', function ($join) {
                    $join->on('TitleTbl.description_int', '=', 'tbl_schoolContact.title_int')
                        ->where(function ($query) {
                            $query->where('TitleTbl.descriptionGroup_int', '=', 1);
                        });
                })
                ->select('tbl_schoolContact.*', 'JobRole.description_txt as jobRole_txt', 'TitleTbl.description_txt as title_txt')
                ->where('tbl_schoolContact.school_id', $id)
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->get();

            $quickSettingList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 18)
                ->get();

            $methodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 17)
                ->get();

            $reasonList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 31)
                ->get();

            $outcomeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 32)
                ->get();

            return view("web.school.school_contact", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'ContactHistory' => $ContactHistory, 'schoolContacts' => $schoolContacts, 'quickSettingList' => $quickSettingList, 'methodList' => $methodList, 'reasonList' => $reasonList, 'outcomeList' => $outcomeList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolContactLogInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->school_id;
            $callbackOn_dtm = null;
            if ($request->callBackCheck && $request->quick_setting_date && $request->quick_setting_time) {
                $d = date("Y-m-d", strtotime($request->quick_setting_date));
                $callbackOn_dtm = $d . ' ' . $request->quick_setting_time . ':00';
            }

            DB::table('tbl_schoolContactLog')
                ->insert([
                    'school_id' => $school_id,
                    'spokeTo_id' => $request->spokeTo_id,
                    'spokeTo_txt' => $request->spokeTo_txt,
                    'method_int' => $request->method_int,
                    'notes_txt' => $request->notes_txt,
                    'contactAbout_int' => $request->contactAbout_int,
                    'outcome_int' => $request->outcome_int,
                    'contactOn_dtm' => date('Y-m-d H:i:s'),
                    'contactBy_id' => $user_id,
                    'callbackOn_dtm' => $callbackOn_dtm,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect('/school-contact/' . $school_id)->with('success', "Contact history added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolContactHistoryEdit(Request $request)
    {
        $input = $request->all();
        $schoolContactLog_id = $input['ContactHistoryId'];
        $school_id = $input['editSchoolId'];

        $contactDetail = DB::table('tbl_schoolContactLog')
            ->where('schoolContactLog_id', "=", $schoolContactLog_id)
            ->first();

        $schoolContacts = DB::table('tbl_schoolContact')
            ->LeftJoin('tbl_description as JobRole', function ($join) {
                $join->on('JobRole.description_int', '=', 'tbl_schoolContact.jobRole_int')
                    ->where(function ($query) {
                        $query->where('JobRole.descriptionGroup_int', '=', 11);
                    });
            })
            ->LeftJoin('tbl_description as TitleTbl', function ($join) {
                $join->on('TitleTbl.description_int', '=', 'tbl_schoolContact.title_int')
                    ->where(function ($query) {
                        $query->where('TitleTbl.descriptionGroup_int', '=', 1);
                    });
            })
            ->select('tbl_schoolContact.*', 'JobRole.description_txt as jobRole_txt', 'TitleTbl.description_txt as title_txt')
            ->where('tbl_schoolContact.school_id', $school_id)
            ->where('tbl_schoolContact.isCurrent_status', '-1')
            ->get();

        $quickSettingList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 18)
            ->get();

        $methodList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 17)
            ->get();

        $reasonList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 31)
            ->get();

        $outcomeList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 32)
            ->get();

        $view = view("web.school.contact_history_edit_view", ['contactDetail' => $contactDetail, 'schoolContacts' => $schoolContacts, 'quickSettingList' => $quickSettingList, 'methodList' => $methodList, 'reasonList' => $reasonList, 'outcomeList' => $outcomeList])->render();
        return response()->json(['html' => $view]);
    }

    public function schoolContactLogUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->school_id;
            $schoolContactLog_id = $request->schoolContactLog_id;
            $callbackOn_dtm = null;
            if ($request->callBackCheck && $request->quick_setting_date && $request->quick_setting_time) {
                $d = date("Y-m-d", strtotime($request->quick_setting_date));
                $callbackOn_dtm = $d . ' ' . $request->quick_setting_time . ':00';
            }

            DB::table('tbl_schoolContactLog')
                ->where('schoolContactLog_id', $schoolContactLog_id)
                ->update([
                    'spokeTo_id' => $request->spokeTo_id,
                    'spokeTo_txt' => $request->spokeTo_txt,
                    'method_int' => $request->method_int,
                    'notes_txt' => $request->notes_txt,
                    'contactAbout_int' => $request->contactAbout_int,
                    'outcome_int' => $request->outcome_int,
                    'contactOn_dtm' => date('Y-m-d H:i:s'),
                    'contactBy_id' => $user_id,
                    'callbackOn_dtm' => $callbackOn_dtm,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect('/school-contact/' . $school_id)->with('success', "Contact history updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolContactHistoryDelete(Request $request)
    {
        $schoolContactLog_id = $request->ContactHistoryId;
        DB::table('tbl_schoolContactLog')
            ->where('schoolContactLog_id', $schoolContactLog_id)
            ->delete();
        return 1;
    }

    public function schoolAssignment(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Assignment");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                // ->take(1)
                ->first();

            $assignment = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_student', 'tbl_student.student_id', '=', 'tbl_asn.student_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, MIN(asnDate_dte) AS asnStartDate_dte FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS t_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 't_asnItems.asn_id');
                    }
                )
                ->LeftJoin('tbl_description as yearGroupType', function ($join) {
                    $join->on('yearGroupType.description_int', '=', 'tbl_asn.yearGroup_int')
                        ->where(function ($query) {
                            $query->where('yearGroupType.descriptionGroup_int', '=', 34);
                        });
                })
                ->LeftJoin('tbl_description as subjectType', function ($join) {
                    $join->on('subjectType.description_int', '=', 'tbl_asn.subject_int')
                        ->where(function ($query) {
                            $query->where('subjectType.descriptionGroup_int', '=', 6);
                        });
                })
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
                ->LeftJoin('tbl_description as assType', function ($join) {
                    $join->on('assType.description_int', '=', 'tbl_asn.asnLength_int')
                        ->where(function ($query) {
                            $query->where('assType.descriptionGroup_int', '=', 35);
                        });
                })
                ->LeftJoin('tbl_description as teacherProff', function ($join) {
                    $join->on('teacherProff.description_int', '=', 'tbl_asn.professionalType_int')
                        ->where(function ($query) {
                            $query->where('teacherProff.descriptionGroup_int', '=', 7);
                        });
                })
                ->select('tbl_asn.*', 'yearGroupType.description_txt as yearGroupTxt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'assType.description_txt as assignmentType', 'subjectType.description_txt as subjectTxt', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), 'teacherProff.description_txt as teacherProfession', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', DB::raw('MIN(asnDate_dte) AS firstDate_dte'), 'tbl_student.firstName_txt as studentfirstName', 'tbl_student.surname_txt as studentsurname_txt', DB::raw('IF(t_asnItems.asn_id IS NULL, IF(createdOn_dtm IS NULL, tbl_asn.timestamp_ts, createdOn_dtm), asnStartDate_dte) AS asnStartDate_dte'))
                ->where('tbl_asn.school_id', $id);
            // ->where('tbl_teacher.is_delete', 0);
            if ($request->include != 1 && $request->status) {
                $assignment->where('tbl_asn.status_int', $request->status);
            }
            $assignmentList = $assignment->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_asn.createdOn_dtm', 'ASC')
                ->get();

            $completeCount = DB::table('tbl_asn')
                ->where('tbl_asn.school_id', $id)
                ->where('tbl_asn.status_int', 3)
                ->count();

            $statusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 33)
                ->get();

            return view("web.school.school_assignment", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'assignmentList' => $assignmentList, 'statusList' => $statusList, 'completeCount' => $completeCount]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolFinance(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Finance");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                // ->take(1)
                ->first();

            $Invoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                // ->leftJoin(
                //     DB::raw('(SELECT school_id, contactItem_txt As email_txt FROM tbl_contactItemSch WHERE school_id = ' . $id . ' AND receiveInvoices_status <> 0 LIMIT 1) AS t_email'),
                //     function ($join) {
                //         $join->on('tbl_invoice.school_id', '=', 't_email.school_id');
                //     }
                // )
                ->LeftJoin('tbl_description as invPaymentMethod', function ($join) {
                    $join->on('invPaymentMethod.description_int', '=', 'tbl_invoice.paymentMethod_int')
                        ->where(function ($query) {
                            $query->where('invPaymentMethod.descriptionGroup_int', '=', 42);
                        });
                })
                ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'), 'invPaymentMethod.description_txt as invPaymentMethod_txt')
                ->where('tbl_invoice.school_id', $id);
            if ($request->include == '') {
                $Invoices->where('tbl_invoice.paidOn_dte', NULL);
            }
            if ($request->method) {
                $Invoices->where('tbl_invoice.paymentMethod_int', $request->method);
            }
            $schoolInvoices = $Invoices->groupBy('tbl_invoice.invoice_id')
                ->orderBy('tbl_invoice.invoiceDate_dte', 'DESC')
                ->get();

            $schoolTimesheet = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->select('tbl_asn.*', DB::raw('COUNT(asnItem_id) AS items_int'), 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt')
                ->where('tbl_asn.school_id', $id)
                ->whereDate('tbl_asnItem.asnDate_dte', '<', date('Y-m-d'))
                ->where('tbl_asn.status_int', 3)
                ->where('timesheet_id', null)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('tbl_asn.teacher_id')
                ->orderBy(DB::raw('COUNT(asnItem_id)'), 'DESC')
                ->get();

            $paymentMethodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 42)
                ->get();

            $profTypeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 7)
                ->get();

            $candRateList = DB::table('tbl_description')
                ->LeftJoin('tbl_asnRates', function ($join) {
                    $join->on('tbl_asnRates.descriptionGroup_int', '=', 'tbl_description.description_int')
                        ->where(function ($query) {
                            $query->where('tbl_asnRates.descriptionGroup_id', '=', 7);
                        });
                })
                ->LeftJoin('tbl_asnRatesSchool', function ($join) use ($id) {
                    $join->on('tbl_asnRatesSchool.teacherType_int', '=', 'tbl_description.description_int')
                        ->where(function ($query) use ($id) {
                            $query->where('tbl_asnRatesSchool.school_id', '=', $id);
                        });
                })
                ->select('tbl_description.description_int', 'tbl_description.description_txt', 'tbl_asnRates.asnRate_dec as mainAsnRate_dec', 'tbl_asnRatesSchool.asnRateSchool_id', 'tbl_asnRatesSchool.asnRate_dec as schAsnRate_dec')
                ->where('tbl_description.descriptionGroup_int', 7)
                ->where('tbl_description.description_int', '<=', 12)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            // dd($candRateList);
            $thresholdDate = Carbon::now()->subDays(30);
            $overdueInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_description as invPaymentMethod', function ($join) {
                    $join->on('invPaymentMethod.description_int', '=', 'tbl_invoice.paymentMethod_int')
                        ->where(function ($query) {
                            $query->where('invPaymentMethod.descriptionGroup_int', '=', 42);
                        });
                })
                ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'), 'invPaymentMethod.description_txt as invPaymentMethod_txt')
                ->where('tbl_invoice.school_id', $id)
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->where('tbl_invoice.invoiceDate_dte', '<', $thresholdDate)
                ->groupBy('tbl_invoice.invoice_id')
                ->orderBy('tbl_invoice.invoiceDate_dte', 'DESC')
                ->get();

            $invoiceCal = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select(DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"))
                ->where('tbl_invoice.school_id', $id)
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->first();

            $invoiceOverdueCal = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select(DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"))
                ->where('tbl_invoice.school_id', $id)
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->where('tbl_invoice.invoiceDate_dte', '<', $thresholdDate)
                ->first();

            return view("web.school.school_finance", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'schoolTimesheet' => $schoolTimesheet, 'paymentMethodList' => $paymentMethodList, 'profTypeList' => $profTypeList, 'candRateList' => $candRateList, 'overdueInvoices' => $overdueInvoices, 'invoiceCal' => $invoiceCal, 'invoiceOverdueCal' => $invoiceOverdueCal]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolFinanceInvoiceInsert(Request $request)
    {
        $user_id = '';
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $user_id = $webUserLoginData->user_id;
        }
        $school_id = $request->school_id;
        $include = $request->include;
        $method = $request->method;
        $invoice_id = DB::table('tbl_invoice')
            ->insertGetId([
                'school_id' => $school_id,
                'invoiceDate_dte' => date('Y-m-d'),
                // 'paymentLoggedBy_id' => $user_id,
                // 'sentOn_dte' => date('Y-m-d'),
                // 'sentBy_int' => $user_id,
                'created_by' => $user_id,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        return response()->json(['school_id' => $school_id, 'include' => $include, 'method' => $method, 'invoice_id' => $invoice_id]);
    }

    public function schoolFinanceInvoiceEdit(Request $request, $id, $invoice_id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Finance");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $include = $request->include;
            $method = $request->method;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                ->first();

            $paymentMethodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 42)
                ->get();

            $invoiceDetail = DB::table('tbl_invoice')
                ->select('tbl_invoice.*')
                ->where('tbl_invoice.invoice_id', $invoice_id)
                ->first();
            $invoiceItemList = DB::table('tbl_invoiceItem')
                ->select('tbl_invoiceItem.*')
                ->where('tbl_invoiceItem.invoice_id', $invoice_id)
                ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                ->get();

            return view("web.school.school_invoice_edit", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'invoice_id' => $invoice_id, 'include' => $include, 'method' => $method, 'schoolDetail' => $schoolDetail, 'paymentMethodList' => $paymentMethodList, 'invoiceDetail' => $invoiceDetail, 'invoiceItemList' => $invoiceItemList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolFinanceInvItemInsert(Request $request)
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

        return redirect()->back();
    }

    public function getInvoiceItemDetail(Request $request)
    {
        $input = $request->all();
        $invoiceItem_id = $input['editInvItemId'];

        $itemDetail = DB::table('tbl_invoiceItem')
            ->where('invoiceItem_id', "=", $invoiceItem_id)
            ->first();

        $view = view("web.school.invoice_item_edit_view", ['itemDetail' => $itemDetail])->render();
        return response()->json(['html' => $view]);
    }

    public function schoolFinanceInvItemUpdate(Request $request)
    {
        $invoiceItem_id = $request->editInvItemId;

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

        return redirect()->back();
    }

    public function schoolFinanceInvItemDelete(Request $request)
    {
        $invoiceItem_id = $request->editInvItemId;
        DB::table('tbl_invoiceItem')
            ->where('invoiceItem_id', $invoiceItem_id)
            ->delete();

        return 1;
    }

    public function schoolFinanceInvoiceUpdate(Request $request)
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

    public function schoolCreditInvoiceInsert(Request $request)
    {
        $editInvoiceId = $request->editInvoiceId;
        $user_id = '';
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $user_id = $webUserLoginData->user_id;
        }
        $invoiceDetail = DB::table('tbl_invoice')
            ->select('tbl_invoice.*')
            ->where('tbl_invoice.invoice_id', $editInvoiceId)
            ->first();
        $invoiceItemList = DB::table('tbl_invoiceItem')
            ->select('tbl_invoiceItem.*')
            ->where('tbl_invoiceItem.invoice_id', $editInvoiceId)
            ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
            ->get();

        $school_id = $request->school_id;
        $invoice_id = DB::table('tbl_invoice')
            ->insertGetId([
                'school_id' => $school_id,
                'invoiceDate_dte' => date('Y-m-d'),
                // 'paymentLoggedBy_id' => $user_id,
                // 'sentOn_dte' => date('Y-m-d'),
                // 'sentBy_int' => $user_id,
                'creditNote_status' => -1,
                'created_by' => $user_id,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        if (count($invoiceItemList) > 0) {
            foreach ($invoiceItemList as $key => $value) {
                DB::table('tbl_invoiceItem')
                    ->insert([
                        'invoice_id' => $invoice_id,
                        'description_txt' => $value->description_txt,
                        'numItems_dec' => $value->numItems_dec,
                        'dateFor_dte' => $value->dateFor_dte,
                        'charge_dec' => '-' . $value->charge_dec,
                        'cost_dec' => '-' . $value->cost_dec,
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);
            }
        }

        return response()->json(['invoice_id' => $invoice_id]);
    }

    public function invoiceDetailForSplit(Request $request)
    {
        $input = $request->all();
        $editInvoiceId = $input['editInvoiceId'];

        $invoiceDetail = DB::table('tbl_invoice')
            ->select('tbl_invoice.*')
            ->where('tbl_invoice.invoice_id', $editInvoiceId)
            ->first();
        $invoiceItemList = DB::table('tbl_invoiceItem')
            ->select('tbl_invoiceItem.*')
            ->where('tbl_invoiceItem.invoice_id', $editInvoiceId)
            ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
            ->get();

        $view = view("web.school.invoice_split_view", ['invoiceDetail' => $invoiceDetail, 'invoiceItemList' => $invoiceItemList])->render();
        return response()->json(['html' => $view]);
    }

    public function schoolSplitInvoiceCreate(Request $request)
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
                'invoiceDate_dte' => date('Y-m-d'),
                // 'paymentLoggedBy_id' => $user_id,
                // 'sentOn_dte' => date('Y-m-d'),
                // 'sentBy_int' => $user_id,
                'created_by' => $user_id,
                'timestamp_ts' => date('Y-m-d H:i:s')
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
                        'description_txt' => $invoiceItemDet->description_txt,
                        'numItems_dec' => $invoiceItemDet->numItems_dec,
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

    public function schoolInvoicePdf(Request $request, $id, $invoice_id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                ->first();

            $schoolInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.invoice_id', $invoice_id)
                ->groupBy('tbl_invoice.invoice_id')
                ->first();
            $invoiceItemList = DB::table('tbl_invoiceItem')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asnItem_id', '=', 'tbl_invoiceItem.asnItem_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_invoiceItem.teacher_id')
                ->select('tbl_invoiceItem.*', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', DB::raw("CONCAT(IF(tbl_asnItem.dayPart_int = 4, CONCAT(tbl_asnItem.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem.dayPart_int)),IF(lunch_time, CONCAT(' ( ', lunch_time,' )'), '')) AS dayAvail_txt"))
                ->where('tbl_invoiceItem.invoice_id', $invoice_id)
                ->orderBy('tbl_teacher.firstName_txt', 'ASC')
                ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                ->get();

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
            $comFooterLogos = DB::table('company_logo')
                ->where('company_logo.company_id', $company_id)
                ->orderBy('company_logo.image_id', 'DESC')
                ->get();

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

            $pdf = PDF::loadView('web.school.school_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDet, 'comFooterLogos' => $comFooterLogos]);
            $pdfName = 'invoice-' . $invoice_id . '.pdf';
            // return $pdf->download('test.pdf');
            return $pdf->stream($pdfName);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolInvoiceRemit(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $invoice_id = $request->editInvoiceId;
            $paymentMethod_int = NULL;
            if ($request->paymentInt) {
                $paymentMethod_int = $request->paymentInt;
            }
            DB::table('tbl_invoice')
                ->where('invoice_id', $invoice_id)
                ->update([
                    'paidOn_dte' => date("Y-m-d"),
                    'paymentLoggedBy_id' => $user_id,
                    'paymentMethod_int' => $paymentMethod_int
                ]);
        }
        return 1;
    }

    public function schoolInvoiceDelete(Request $request)
    {
        $editInvoiceId = $request->editInvoiceId;

        DB::table('tbl_asnItem')
            ->where('invoice_id', $editInvoiceId)
            ->update([
                'invoice_id' => NULL
            ]);

        DB::table('tbl_invoiceItem')
            ->where('invoice_id', $editInvoiceId)
            ->delete();
        DB::table('tbl_invoice')
            ->where('invoice_id', $editInvoiceId)
            ->delete();

        return 1;
    }

    public function schoolTeacher(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Teacher");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $tStatus = 'All';
            if ($request->status) {
                $tStatus = $request->status;
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                // ->take(1)
                ->first();

            $teacher = DB::table('tbl_schoolTeacherList')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn  LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE school_id = ' . $id . ' GROUP BY teacher_id) AS t_days'),
                    function ($join) {
                        $join->on('tbl_schoolTeacherList.teacher_id', '=', 't_days.teacher_id');
                    }
                )
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_schoolTeacherList.teacher_id')
                ->LeftJoin('tbl_description as applicationStatus', function ($join) {
                    $join->on('applicationStatus.description_int', '=', 'tbl_teacher.applicationStatus_int')
                        ->where(function ($query) {
                            $query->where('applicationStatus.descriptionGroup_int', '=', 3);
                        });
                })
                ->select('tbl_schoolTeacherList.*', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_teacher.applicationStatus_int', 'applicationStatus.description_txt as status_txt', 'daysWorked_dec')
                ->where('tbl_schoolTeacherList.school_id', $id);
            // ->where('tbl_teacher.is_delete', 0);
            if ($tStatus != 'all') {
                if ($tStatus == 'preferred') {
                    $teacher->where('tbl_schoolTeacherList.rejectOrPreferred_int', 1);
                }
                if ($tStatus == 'rejected') {
                    $teacher->where('tbl_schoolTeacherList.rejectOrPreferred_int', 2);
                }
            }
            $teacherList = $teacher->groupBy('tbl_schoolTeacherList.teacher_id')
                ->get();

            return view("web.school.school_teacher", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'teacherList' => $teacherList, 'tStatus' => $tStatus]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function searchTeacherList(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $searchTeacherKey = $input['searchTeacherKey'];
            $school_id = $input['school_id'];
            $teacherList = array();

            if ($searchTeacherKey) {
                $teacherQry = DB::table('tbl_teacher')
                    ->leftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                    ->leftJoin(
                        DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                        function ($join) {
                            $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                        }
                    )
                    ->LeftJoin('tbl_description as ageRangeSpecialism', function ($join) {
                        $join->on('ageRangeSpecialism.description_int', '=', 'tbl_teacher.ageRangeSpecialism_int')
                            ->where(function ($query) {
                                $query->where('ageRangeSpecialism.descriptionGroup_int', '=', 5);
                            });
                    })
                    ->LeftJoin('tbl_description as professionalType', function ($join) {
                        $join->on('professionalType.description_int', '=', 'tbl_teacher.professionalType_int')
                            ->where(function ($query) {
                                $query->where('professionalType.descriptionGroup_int', '=', 7);
                            });
                    })
                    ->LeftJoin('tbl_description as applicationStatus', function ($join) {
                        $join->on('applicationStatus.description_int', '=', 'tbl_teacher.applicationStatus_int')
                            ->where(function ($query) {
                                $query->where('applicationStatus.descriptionGroup_int', '=', 3);
                            });
                    })
                    ->LeftJoin('tbl_teacherContactLog', 'tbl_teacherContactLog.teacher_id', '=', 'tbl_teacher.teacher_id')
                    ->LeftJoin('tbl_description as titleTable', function ($join) {
                        $join->on('titleTable.description_int', '=', 'tbl_teacher.title_int')
                            ->where(function ($query) {
                                $query->where('titleTable.descriptionGroup_int', '=', 1);
                            });
                    })
                    ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt')
                    ->where('tbl_teacher.company_id', $company_id)
                    // ->where('tbl_teacher.is_delete', 0)
                    ->where('tbl_teacher.isCurrent_status', '<>', 0)
                    ->whereNotIn('tbl_teacher.teacher_id', function ($query) use ($school_id) {
                        $query->select('teacher_id')
                            ->from('tbl_schoolTeacherList')
                            ->where('tbl_schoolTeacherList.school_id', $school_id)
                            ->where('tbl_schoolTeacherList.rejectOrPreferred_int', 2)
                            ->get();
                    });

                if ($searchTeacherKey) {
                    $search_input = str_replace(" ", "", $searchTeacherKey);
                    $teacherQry->where(function ($query) use ($search_input) {
                        $query->where('firstName_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('knownAs_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('surname_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('contactItem_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere(DB::raw("CONCAT(`knownAs_txt`, `surname_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere(DB::raw("CONCAT(`firstName_txt`, `surname_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere('middleNames_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere(DB::raw("CONCAT(`firstName_txt`, `middleNames_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere(DB::raw("CONCAT(`knownAs_txt`, `middleNames_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere(DB::raw("CONCAT(`middleNames_txt`, `surname_txt`)"), 'LIKE', "%" . $search_input . "%");
                    });
                }

                $teacherList = $teacherQry->groupBy('tbl_teacher.teacher_id')->limit(10)->get();
            }

            $html = '';
            if (count($teacherList) > 0) {
                foreach ($teacherList as $key2 => $Items) {
                    $name = '';
                    if ($Items->knownAs_txt == null && $Items->knownAs_txt == '') {
                        $name = $Items->firstName_txt . ' ' . $Items->surname_txt;
                    } else {
                        $name = $Items->firstName_txt . ' (' . $Items->knownAs_txt . ') ' . $Items->surname_txt;
                    }
                    $html .= "<tr class='table-data searchTeacherRow'
                    id='searchTeacherRow$Items->teacher_id'  onclick='searchTeacherRowSelect($Items->teacher_id)'>
                    <td>$name</td>
                    <td>$Items->professionalType_txt</td>
                    <td>$Items->appStatus_txt</td>
                    <td>$Items->daysWorked_dec</td>
                    <td>$Items->ageRangeSpecialism_txt</td>
                </tr>";
                }
            } else {
                $html .= '<tr>
                <td colspan="5">
                    No teacher found.
                </td>
            </tr>';
            }

            return response()->json(['html' => $html]);
        } else {
            return 'login';
        }
    }

    public function schoolTeacherInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->school_id;
            $teacher_id = $request->searchTeacherId;

            $validator = Validator::make($request->all(), [
                'rejectOrPreferred_int' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }

            DB::table('tbl_schoolTeacherList')
                ->insert([
                    'school_id' => $school_id,
                    'teacher_id' => $teacher_id,
                    'rejectOrPreferred_int' => $request->rejectOrPreferred_int,
                    'notes_txt' => $request->notes_txt,
                    'addedBy_id' => $user_id,
                    'addedOn_dtm' => date('Y-m-d H:i:s'),
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Teacher added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolTeacherEdit(Request $request)
    {
        $input = $request->all();
        $schoolTeacherList_id = $input['editTeacherId'];
        $school_id = $input['editSchoolId'];
        $teacherList = array();

        $Detail = DB::table('tbl_schoolTeacherList')
            ->where('schoolTeacherList_id', "=", $schoolTeacherList_id)
            ->first();
        if ($Detail) {
            $teacherList = DB::table('tbl_teacher')
                ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                    }
                )
                ->LeftJoin('tbl_description as ageRangeSpecialism', function ($join) {
                    $join->on('ageRangeSpecialism.description_int', '=', 'tbl_teacher.ageRangeSpecialism_int')
                        ->where(function ($query) {
                            $query->where('ageRangeSpecialism.descriptionGroup_int', '=', 5);
                        });
                })
                ->LeftJoin('tbl_description as professionalType', function ($join) {
                    $join->on('professionalType.description_int', '=', 'tbl_teacher.professionalType_int')
                        ->where(function ($query) {
                            $query->where('professionalType.descriptionGroup_int', '=', 7);
                        });
                })
                ->LeftJoin('tbl_description as applicationStatus', function ($join) {
                    $join->on('applicationStatus.description_int', '=', 'tbl_teacher.applicationStatus_int')
                        ->where(function ($query) {
                            $query->where('applicationStatus.descriptionGroup_int', '=', 3);
                        });
                })
                ->LeftJoin('tbl_teacherContactLog', 'tbl_teacherContactLog.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('tbl_description as titleTable', function ($join) {
                    $join->on('titleTable.description_int', '=', 'tbl_teacher.title_int')
                        ->where(function ($query) {
                            $query->where('titleTable.descriptionGroup_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt')
                ->where('tbl_teacher.teacher_id', $Detail->teacher_id)
                ->groupBy('tbl_teacher.teacher_id')
                ->limit(1)
                ->get();

            $editSchoolDetail = DB::table('tbl_school')
                ->select('tbl_school.*')
                ->where('tbl_school.school_id', $school_id)
                ->first();
        }

        $view = view("web.school.edit_school_teacher_view", ['Detail' => $Detail, 'teacherList' => $teacherList, 'editSchoolDetail' => $editSchoolDetail])->render();
        return response()->json(['html' => $view]);
    }

    public function editSearchTeacherList(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $input = $request->all();
            $searchTeacherKey = $input['searchTeacherKey'];
            $teacherList = array();

            if ($searchTeacherKey) {
                $teacherQry = DB::table('tbl_teacher')
                    ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                    ->leftJoin(
                        DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                        function ($join) {
                            $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                        }
                    )
                    ->LeftJoin('tbl_description as ageRangeSpecialism', function ($join) {
                        $join->on('ageRangeSpecialism.description_int', '=', 'tbl_teacher.ageRangeSpecialism_int')
                            ->where(function ($query) {
                                $query->where('ageRangeSpecialism.descriptionGroup_int', '=', 5);
                            });
                    })
                    ->LeftJoin('tbl_description as professionalType', function ($join) {
                        $join->on('professionalType.description_int', '=', 'tbl_teacher.professionalType_int')
                            ->where(function ($query) {
                                $query->where('professionalType.descriptionGroup_int', '=', 7);
                            });
                    })
                    ->LeftJoin('tbl_description as applicationStatus', function ($join) {
                        $join->on('applicationStatus.description_int', '=', 'tbl_teacher.applicationStatus_int')
                            ->where(function ($query) {
                                $query->where('applicationStatus.descriptionGroup_int', '=', 3);
                            });
                    })
                    ->LeftJoin('tbl_teacherContactLog', 'tbl_teacherContactLog.teacher_id', '=', 'tbl_teacher.teacher_id')
                    ->LeftJoin('tbl_description as titleTable', function ($join) {
                        $join->on('titleTable.description_int', '=', 'tbl_teacher.title_int')
                            ->where(function ($query) {
                                $query->where('titleTable.descriptionGroup_int', '=', 1);
                            });
                    })
                    ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt')
                    ->where('tbl_teacher.company_id', $company_id)
                    // ->where('tbl_teacher.is_delete', 0)
                    ->where('tbl_teacher.isCurrent_status', '<>', 0);

                if ($searchTeacherKey) {
                    $search_input = str_replace(" ", "", $searchTeacherKey);
                    $teacherQry->where(function ($query) use ($search_input) {
                        $query->where('firstName_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('knownAs_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('surname_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere('contactItem_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere(DB::raw("CONCAT(`knownAs_txt`, `surname_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere(DB::raw("CONCAT(`firstName_txt`, `surname_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere('middleNames_txt', 'LIKE', '%' . $search_input . '%')
                            ->orWhere(DB::raw("CONCAT(`firstName_txt`, `middleNames_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere(DB::raw("CONCAT(`knownAs_txt`, `middleNames_txt`)"), 'LIKE', "%" . $search_input . "%")
                            ->orWhere(DB::raw("CONCAT(`middleNames_txt`, `surname_txt`)"), 'LIKE', "%" . $search_input . "%");
                    });
                }

                $teacherList = $teacherQry->groupBy('tbl_teacher.teacher_id')->limit(10)->get();
            }

            $html = '';
            if (count($teacherList) > 0) {
                foreach ($teacherList as $key2 => $Items) {
                    $name = '';
                    if ($Items->knownAs_txt == null && $Items->knownAs_txt == '') {
                        $name = $Items->firstName_txt . ' ' . $Items->surname_txt;
                    } else {
                        $name = $Items->firstName_txt . ' (' . $Items->knownAs_txt . ') ' . $Items->surname_txt;
                    }
                    $html .= "<tr class='table-data editSearchTeacherRow'
                    id='editSearchTeacherRow$Items->teacher_id'  onclick='editSearchTeacherRowSelect($Items->teacher_id)'>
                    <td>$name</td>
                    <td>$Items->professionalType_txt</td>
                    <td>$Items->appStatus_txt</td>
                    <td>$Items->daysWorked_dec</td>
                    <td>$Items->ageRangeSpecialism_txt</td>
                </tr>";
                }
            } else {
                $html .= '<tr>
                <td colspan="5">
                    No teacher found.
                </td>
            </tr>';
            }

            return response()->json(['html' => $html]);
        } else {
            return 'login';
        }
    }

    public function schoolTeacherUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            // $school_id = $request->school_id;
            $teacher_id = $request->editSearchTeacherId;
            $schoolTeacherList_id = $request->editSchoolTeacherId;

            $validator = Validator::make($request->all(), [
                'rejectOrPreferred_int' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }

            DB::table('tbl_schoolTeacherList')
                ->where('schoolTeacherList_id', $schoolTeacherList_id)
                ->update([
                    'teacher_id' => $teacher_id,
                    'rejectOrPreferred_int' => $request->rejectOrPreferred_int,
                    'notes_txt' => $request->notes_txt,
                    'addedBy_id' => $user_id,
                    // 'addedOn_dtm' => date('Y-m-d H:i:s'),
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Teacher updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolTeacherDelete(Request $request)
    {
        $schoolTeacherList_id = $request->editTeacherId;
        DB::table('tbl_schoolTeacherList')
            ->where('schoolTeacherList_id', '=', $schoolTeacherList_id)
            ->delete();

        return 1;
    }

    public function schoolDocument(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Document");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                ->first();

            $documentList = DB::table('tbl_schooldocument')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_schooldocument.school_id')
                ->LeftJoin('document_type', 'document_type.document_type_id', '=', 'tbl_schooldocument.documentType')
                ->select('tbl_schooldocument.*', 'tbl_school.name_txt', 'document_type.document_type_text')
                ->where('tbl_schooldocument.school_id', $id)
                ->orderBy('tbl_schooldocument.uploadOn_dtm', 'DESC')
                ->get();

            $typeList = DB::table('document_type')
                ->select('document_type.*')
                ->orderBy('document_type.document_type_id', 'DESC')
                ->get();

            return view("web.school.school_document", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'documentList' => $documentList, 'typeList' => $typeList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolDocumentInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->school_id;

            $fPath = '';
            $fType = '';
            $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'txt');
            if ($image = $request->file('file')) {
                $extension = $image->getClientOriginalExtension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "_" . $file_name;
                    $image->move(public_path('images/school'), $name);
                    $fPath = 'images/school/' . $name;
                    $fType = $extension;
                } else {
                    return redirect('/school-document/' . $school_id)->with('error', "Please upload valid file.");
                }
            } else {
                return redirect('/school-document/' . $school_id)->with('error', "Please upload valid file.");
            }

            DB::table('tbl_schooldocument')
                ->insert([
                    'school_id' => $school_id,
                    'file_location' => $fPath,
                    'file_name' => $request->file_name ? $request->file_name : $request->file_name_hidden,
                    'documentType' => $request->documentType,
                    'othersText' => $request->othersText,
                    'file_type' => $fType,
                    'uploadOn_dtm' => date('Y-m-d H:i:s'),
                    'loggedBy_id' => $user_id,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect('/school-document/' . $school_id)->with('success', "Document added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function getSchoolDocDetail(Request $request)
    {
        $input = $request->all();
        $schoolDocument_id = $input['editDocumentId'];

        $docDetail = DB::table('tbl_schooldocument')
            ->where('schoolDocument_id', "=", $schoolDocument_id)
            ->first();
        $typeList = DB::table('document_type')
            ->select('document_type.*')
            ->orderBy('document_type.document_type_id', 'DESC')
            ->get();

        $view = view("web.school.document_edit_view", ['docDetail' => $docDetail, 'typeList' => $typeList])->render();
        return response()->json(['html' => $view]);
    }

    public function schoolDocumentUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->school_id;
            $editDocumentId = $request->editDocumentId;
            $file_location = $request->file_location;

            $docDetail = DB::table('tbl_schooldocument')
                ->where('schoolDocument_id', '=', $editDocumentId)
                ->first();

            if ($docDetail) {
                $fPath = $docDetail->file_location;
                $fType = $docDetail->file_type;
                $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'txt');
                if ($image = $request->file('file')) {
                    $extension = $image->getClientOriginalExtension();
                    $file_name = $image->getClientOriginalName();
                    if (in_array(strtolower($extension), $allowed_types)) {
                        $rand = mt_rand(100000, 999999);
                        $name = time() . "_" . $rand . "_" . $file_name;
                        $image->move(public_path('images/school'), $name);
                        $fPath = 'images/school/' . $name;
                        $fType = $extension;
                        if (file_exists($file_location)) {
                            unlink($file_location);
                        }
                    } else {
                        return redirect('/school-document/' . $school_id)->with('error', "Please upload valid file.");
                    }
                }

                DB::table('tbl_schooldocument')
                    ->where('schoolDocument_id', '=', $editDocumentId)
                    ->update([
                        'file_location' => $fPath,
                        'file_name' => $request->file_name ? $request->file_name : $request->file_name_hidden,
                        'documentType' => $request->documentType,
                        'othersText' => $request->othersText,
                        'file_type' => $fType,
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);
            }

            return redirect('/school-document/' . $school_id)->with('success', "Document updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolDocumentDelete(Request $request)
    {
        $editDocumentId = $request->editDocumentId;
        $docDetail = DB::table('tbl_schooldocument')
            ->where('schoolDocument_id', "=", $editDocumentId)
            ->first();
        if ($docDetail) {
            DB::table('tbl_schooldocument')
                ->where('schoolDocument_id', "=", $editDocumentId)
                ->delete();

            if (file_exists($docDetail->file_location)) {
                unlink($docDetail->file_location);
            }
        }
        return 1;
    }

    public function schoolBillingAddressUpdate(Request $request)
    {
        $school_id = $request->school_id;
        $include = $request->include;
        $method = $request->method;
        $editData = array();
        $timesheetWithInvoice_status = 0;
        if ($request->timesheetWithInvoice_status) {
            $timesheetWithInvoice_status = -1;
        }
        $isFactored_status = 0;
        if ($request->isFactored_status) {
            $isFactored_status = -1;
        }
        $editData['billingAddress1_txt'] = $request->billingAddress1_txt;
        $editData['billingAddress2_txt'] = $request->billingAddress2_txt;
        $editData['billingAddress3_txt'] = $request->billingAddress3_txt;
        $editData['billingAddress4_txt'] = $request->billingAddress4_txt;
        $editData['billingAddress5_txt'] = $request->billingAddress5_txt;
        $editData['billingPostcode_txt'] = $request->billingPostcode_txt;
        $editData['timesheetWithInvoice_status'] = $timesheetWithInvoice_status;
        $editData['isFactored_status'] = $isFactored_status;

        if (count($editData) > 0) {
            // $editData['timestamp_ts'] = date('Y-m-d H:i:s');
            DB::table('tbl_school')->where('school_id', '=', $school_id)
                ->update($editData);
        }

        return redirect('/school-finance/' . $school_id . '?include=' . $include . '&method=' . $method)->with('success', "Billing details updated successfully.");
    }

    public function schoolCalendar(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "School Calendar");
            $headerTitle = "Schools";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                // ->take(1)
                ->first();

            if ($request->date) {
                $weekStartDate = $request->date;
            } else {
                $now = Carbon::now();
                $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            }
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
            $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
            $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
            $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekStartDate6 = date('Y-m-d', strtotime($weekStartDate . ' +5 days'));
            $weekStartDate7 = date('Y-m-d', strtotime($weekStartDate . ' +6 days'));

            $calenderList = DB::table('tbl_teacher')
                ->LeftJoin('tbl_teacherDocument', function ($join) {
                    $join->on('tbl_teacherDocument.teacher_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_teacherDocument.type_int', '=', 1)
                                ->where('tbl_teacherDocument.isCurrent_status', '<>', 0);
                        });
                })
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, IF(COUNT(asnItem_id) > 1, 'Multiple Bookings', CONCAT((SELECT name_txt FROM tbl_school WHERE school_id = '$id'), ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)))) AS day1Avail_txt, tbl_asn.asn_id AS day1Link_id, dayPart_int AS day1LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day1Amount_dec, school_id AS day1School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE asnDate_dte = '$weekStartDate' AND status_int = 3 GROUP BY teacher_id) AS t_day1"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day1.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, IF(COUNT(asnItem_id) > 1, 'Multiple Bookings', CONCAT((SELECT name_txt FROM tbl_school WHERE school_id = '$id'), ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)))) AS day2Avail_txt, tbl_asn.asn_id AS day2Link_id, dayPart_int AS day2LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day2Amount_dec, school_id AS day2School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE asnDate_dte = '$weekStartDate2' AND status_int = 3 GROUP BY teacher_id) AS t_day2"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day2.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, IF(COUNT(asnItem_id) > 1, 'Multiple Bookings', CONCAT((SELECT name_txt FROM tbl_school WHERE school_id = '$id'), ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)))) AS day3Avail_txt, tbl_asn.asn_id AS day3Link_id, dayPart_int AS day3LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day3Amount_dec, school_id AS day3School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE asnDate_dte = '$weekStartDate3' AND status_int = 3 GROUP BY teacher_id) AS t_day3"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day3.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, IF(COUNT(asnItem_id) > 1, 'Multiple Bookings', CONCAT((SELECT name_txt FROM tbl_school WHERE school_id = '$id'), ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)))) AS day4Avail_txt, tbl_asn.asn_id AS day4Link_id, dayPart_int AS day4LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day4Amount_dec, school_id AS day4School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE asnDate_dte = '$weekStartDate4' AND status_int = 3 GROUP BY teacher_id) AS t_day4"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day4.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, IF(COUNT(asnItem_id) > 1, 'Multiple Bookings', CONCAT((SELECT name_txt FROM tbl_school WHERE school_id = '$id'), ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)))) AS day5Avail_txt, tbl_asn.asn_id AS day5Link_id, dayPart_int AS day5LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day5Amount_dec, school_id AS day5School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE asnDate_dte = '$weekStartDate5' AND status_int = 3 GROUP BY teacher_id) AS t_day5"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day5.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, IF(COUNT(asnItem_id) > 1, 'Multiple Bookings', CONCAT((SELECT name_txt FROM tbl_school WHERE school_id = '$id'), ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)))) AS day6Avail_txt, tbl_asn.asn_id AS day6Link_id, dayPart_int AS day6LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day6Amount_dec, school_id AS day6School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE asnDate_dte = '$weekStartDate6' AND status_int = 3 GROUP BY teacher_id) AS t_day6"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day6.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, CONCAT((SELECT name_txt FROM tbl_school WHERE school_id = '$id'), ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int))) AS day7Avail_txt, tbl_asn.asn_id AS day7Link_id, dayPart_int AS day7LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day7Amount_dec, school_id AS day7School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE asnDate_dte = '$weekStartDate7' AND status_int = 3 GROUP BY teacher_id) AS t_day7"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day7.teacher_id');
                    }
                )
                ->select('tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_teacherDocument.file_location', 'day1Avail_txt', 'day1Link_id', 'day1LinkType_int', 'day1School_id', 'day2Avail_txt', 'day2Link_id', 'day2LinkType_int', 'day2School_id', 'day3Avail_txt', 'day3Link_id', 'day3LinkType_int', 'day3School_id', 'day4Avail_txt', 'day4Link_id', 'day4LinkType_int', 'day4School_id', 'day5Avail_txt', 'day5Link_id', 'day5LinkType_int', 'day5School_id', 'day6Avail_txt', 'day6Link_id', 'day6LinkType_int', 'day6School_id', 'day7Avail_txt', 'day7Link_id', 'day7LinkType_int', 'day7School_id', DB::raw("CAST((IFNULL(day1Amount_dec, 0) + IFNULL(day2Amount_dec, 0) + IFNULL(day3Amount_dec, 0) + IFNULL(day4Amount_dec, 0) + IFNULL(day5Amount_dec, 0) + IFNULL(day6Amount_dec, 0) + IFNULL(day7Amount_dec, 0)) AS DECIMAL(3, 1)) AS totalDays"))
                ->whereRaw("(t_day1.teacher_id IS NOT NULL OR t_day2.teacher_id IS NOT NULL OR t_day3.teacher_id IS NOT NULL OR t_day4.teacher_id IS NOT NULL OR t_day5.teacher_id IS NOT NULL OR t_day6.teacher_id IS NOT NULL OR t_day7.teacher_id IS NOT NULL) AND (day1School_id = '$id' OR day2School_id = '$id' OR day3School_id = '$id' OR day4School_id = '$id' OR day5School_id = '$id' OR day6School_id = '$id' OR day7School_id = '$id')")
                ->where('tbl_teacher.company_id', $company_id)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('tbl_teacher.teacher_id')
                ->orderBy(DB::raw("(day1Amount_dec + day2Amount_dec + day3Amount_dec + day4Amount_dec + day5Amount_dec + day6Amount_dec + day7Amount_dec)"), 'DESC')
                ->get();
            // dd($calenderList);
            return view("web.school.school_calendar", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'schoolDetail' => $schoolDetail, 'school_id' => $id, 'weekStartDate' => $weekStartDate, 'calenderList' => $calenderList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolHeaderFabAdd(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->school_id;
            $fabExit = DB::table('tbl_userFavourite')
                ->where('link_id', $school_id)
                ->where('type_int', 2)
                ->first();
            if ($fabExit) {
                DB::table('tbl_userFavourite')
                    ->where('favourite_id', $fabExit->favourite_id)
                    ->delete();
            } else {
                DB::table('tbl_userFavourite')
                    ->insert([
                        'user_id' => $user_id,
                        'link_id' => $school_id,
                        'type_int' => 2
                    ]);
            }
            return true;
        } else {
            return false;
        }
    }

    public function addAsnCandRate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $schoolId = $request->schoolId;
            $selectedRateInt = $request->selectedRateInt;
            $selectedRateValue = $request->selectedRateValue;
            $rateExist = DB::table('tbl_asnRatesSchool')
                ->where('school_id', $schoolId)
                ->where('teacherType_int', $selectedRateInt)
                ->first();
            if ($rateExist) {
                DB::table('tbl_asnRatesSchool')
                    ->where('asnRateSchool_id', '=', $rateExist->asnRateSchool_id)
                    ->update([
                        'asnRate_dec' => $selectedRateValue
                    ]);
            } else {
                DB::table('tbl_asnRatesSchool')
                    ->insert([
                        'school_id' => $schoolId,
                        'teacherType_int' => $selectedRateInt,
                        'asnRate_dec' => $selectedRateValue
                    ]);
            }
            return true;
        } else {
            return false;
        }
    }

    public function addAllCandRate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->school_id;

            foreach ($request->rateDescInt as $key => $value) {
                $rateExist = DB::table('tbl_asnRatesSchool')
                    ->where('school_id', $school_id)
                    ->where('teacherType_int', $value)
                    ->first();
                if ($rateExist) {
                    DB::table('tbl_asnRatesSchool')
                        ->where('asnRateSchool_id', '=', $rateExist->asnRateSchool_id)
                        ->update([
                            'asnRate_dec' => $request->rateDescRate[$key]
                        ]);
                } else {
                    DB::table('tbl_asnRatesSchool')
                        ->insert([
                            'school_id' => $school_id,
                            'teacherType_int' => $value,
                            'asnRate_dec' => $request->rateDescRate[$key]
                        ]);
                }
            }

            return redirect()->back()->with('success', "Assignment rate updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    /********* School Portal *********/
    public function schoolSetPassword(Request $request, $id)
    {
        $school_id = base64_decode($id);
        $schoolDetail = DB::table('tbl_school')
            ->select('tbl_school.*')
            ->where('school_id', $school_id)
            ->first();
        $companyDetail = array();
        if ($schoolDetail) {
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $schoolDetail->company_id)
                ->get();
        }

        return view("web.schoolPortal.set_password", ['school_id' => $school_id, 'schoolDetail' => $schoolDetail, 'companyDetail' => $companyDetail]);
    }

    public function schoolPasswordUpdate(Request $request)
    {
        if ($request->password != $request->confirm_password) {
            return redirect()->back()->with('error', "Password and confirm password not match.");
        } else {
            $school_id = $request->school_id;
            DB::table('tbl_school')
                ->where('school_id', '=', $school_id)
                ->update([
                    'password' => Hash::make($request->password),
                    'activeStatus' => 1
                ]);
            return redirect()->intended('/school');
        }
    }

    public function schoolLogin(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            return redirect()->intended('/school/detail');
        } else {
            $title = array('pageTitle' => "School Login");
            return view("web.schoolPortal.school_login", ['title' => $title]);
        }
    }

    public function schoolProcessLogin(Request $request)
    {
        $validator = Validator::make(
            array(
                'user_name'    => $request->user_name,
                'password' => $request->password
            ),
            array(
                'user_name'    => 'required',
                'password' => 'required',
            )
        );
        //check validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user_exist = DB::table('tbl_school')
                ->LeftJoin('company', 'company.company_id', '=', 'tbl_school.company_id')
                ->select('tbl_school.*', 'company.company_name', 'company.company_logo')
                ->where('tbl_school.login_mail', $request->user_name)
                ->get();
            if (count($user_exist) > 0) {
                if (!Hash::check($request->password, $user_exist[0]->password)) {
                    return redirect()->back()->withInput()->with('loginError', "Wrong password.");
                } else {
                    if ($user_exist[0]->activeStatus != 1) {
                        return redirect()->back()->withInput()->with('loginError', "You are not an active user.");
                    } else {
                        Session::put('schoolLoginData', $user_exist[0]);
                        return redirect()->intended('/school/finance?include=&method=');
                    }
                }
            } else {
                return redirect()->back()->withInput()->with('loginError', "Wrong user name.");
            }
        }
    }

    public function schoolLogout()
    {
        Session::forget('schoolLoginData');
        return redirect('/school');
    }

    public function logSchoolDetail(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $title = array('pageTitle' => "School Detail");
            $headerTitle = "Schools";
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $school_id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                // ->take(1)
                ->first();
            // dd($schoolDetail);
            $schoolContacts = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_description as JobRole', function ($join) {
                    $join->on('JobRole.description_int', '=', 'tbl_schoolContact.jobRole_int')
                        ->where(function ($query) {
                            $query->where('JobRole.descriptionGroup_int', '=', 11);
                        });
                })
                ->LeftJoin('tbl_description as TitleTbl', function ($join) {
                    $join->on('TitleTbl.description_int', '=', 'tbl_schoolContact.title_int')
                        ->where(function ($query) {
                            $query->where('TitleTbl.descriptionGroup_int', '=', 1);
                        });
                })
                ->select('tbl_schoolContact.*', 'JobRole.description_txt as jobRole_txt', 'TitleTbl.description_txt as title_txt')
                ->where('tbl_schoolContact.school_id', $school_id)
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->get();

            $contactItems = DB::table('tbl_contactItemSch')
                ->LeftJoin('tbl_schoolContact', 'tbl_contactItemSch.schoolContact_id', '=', 'tbl_schoolContact.contact_id')
                ->LeftJoin('tbl_description as JobRole', function ($join) {
                    $join->on('JobRole.description_int', '=', 'tbl_schoolContact.jobRole_int')
                        ->where(function ($query) {
                            $query->where('JobRole.descriptionGroup_int', '=', 11);
                        });
                })
                ->LeftJoin('tbl_description as ContactType', function ($join) {
                    $join->on('ContactType.description_int', '=', 'tbl_contactItemSch.type_int')
                        ->where(function ($query) {
                            $query->where('ContactType.descriptionGroup_int', '=', 13);
                        });
                })
                ->select('tbl_contactItemSch.*', 'JobRole.description_txt as jobRole_txt', 'ContactType.description_txt as type_txt', 'tbl_schoolContact.title_int', 'tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_schoolContact.jobRole_int', 'tbl_schoolContact.receiveTimesheets_status', 'tbl_schoolContact.receiveInvoice_status', 'tbl_schoolContact.receiveVetting_status', 'tbl_schoolContact.isCurrent_status')
                ->where('tbl_contactItemSch.school_id', $school_id)
                ->where(function ($query) {
                    $query->where('tbl_contactItemSch.schoolContact_id', NULL);
                    // ->orWhere('tbl_schoolContact.isCurrent_status', '=', '-1');
                })
                ->get();

            $titleList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 1)
                ->get();

            $jobRoleList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 11)
                ->get();

            $contactMethodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 13)
                ->get();

            return view("web.schoolPortal.school_detail", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'schoolDetail' => $schoolDetail, 'schoolContacts' => $schoolContacts, 'contactItems' => $contactItems, 'school_id' => $school_id, 'titleList' => $titleList, 'jobRoleList' => $jobRoleList, 'contactMethodList' => $contactMethodList]);
        } else {
            return redirect()->intended('/school');
        }
    }

    public function logSchoolContactInsert(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;
            // $school_id = $request->school_id;
            $receiveVetting_status = 0;
            if ($request->receiveVetting_status) {
                $receiveVetting_status = -1;
            }
            $receiveTimesheets_status = 0;
            if ($request->receiveTimesheets_status) {
                $receiveTimesheets_status = -1;
            }
            DB::table('tbl_schoolContact')
                ->insert([
                    'school_id' => $school_id,
                    'title_int' => $request->title_int,
                    'firstName_txt' => $request->firstName_txt,
                    'surname_txt' => $request->surname_txt,
                    'jobRole_int' => $request->jobRole_int,
                    'receiveTimesheets_status' => $receiveTimesheets_status,
                    'receiveVetting_status' => $receiveVetting_status,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Contact added successfully.");
        } else {
            return redirect()->intended('/school');
        }
    }

    public function logSchoolContactDetail(Request $request)
    {
        $input = $request->all();
        $contact_id = $input['contact_id'];

        $contactDetail = DB::table('tbl_schoolContact')
            ->where('contact_id', "=", $contact_id)
            ->first();
        $titleList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 1)
            ->get();

        $jobRoleList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 11)
            ->get();

        $view = view("web.schoolPortal.contact_edit_view", ['contactDetail' => $contactDetail, 'titleList' => $titleList, 'jobRoleList' => $jobRoleList])->render();
        return response()->json(['html' => $view]);
    }

    public function logSchoolContactUpdate(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;
            $contact_id = $request->editContactId;
            // $school_id = $request->school_id;
            $editData = array();
            $receiveVetting_status = 0;
            if ($request->receiveVetting_status) {
                $receiveVetting_status = -1;
            }
            $receiveTimesheets_status = 0;
            if ($request->receiveTimesheets_status) {
                $receiveTimesheets_status = -1;
            }
            $editData['title_int'] = $request->title_int;
            $editData['firstName_txt'] = $request->firstName_txt;
            $editData['surname_txt'] = $request->surname_txt;
            $editData['jobRole_int'] = $request->jobRole_int;
            $editData['receiveTimesheets_status'] = $receiveTimesheets_status;
            $editData['receiveVetting_status'] = $receiveVetting_status;
            $editData['title_int'] = $request->title_int;

            if (count($editData) > 0) {
                $editData['timestamp_ts'] = date('Y-m-d H:i:s');
                DB::table('tbl_schoolContact')->where('contact_id', '=', $contact_id)
                    ->update($editData);
            }

            return redirect()->back()->with('success', "Contact updated successfully.");
        } else {
            return redirect()->intended('/school');
        }
    }

    public function logSchoolContactDelete(Request $request)
    {
        $contact_id = $request->contact_id;
        $Detail = DB::table('tbl_schoolContact')
            ->where('contact_id', '=', $contact_id)
            ->first();

        DB::table('tbl_contactItemSch')
            ->where('schoolContact_id', '=', $contact_id)
            ->delete();

        DB::table('tbl_schoolContactLog')
            ->where('spokeTo_id', '=', $contact_id)
            ->delete();

        DB::table('tbl_schoolContact')
            ->where('contact_id', '=', $contact_id)
            ->delete();

        if ($Detail) {
            $userExist = DB::table('tbl_school')
                ->where('tbl_school.school_id', $Detail->school_id)
                ->where('tbl_school.logContId', $contact_id)
                ->first();
            if ($userExist) {
                DB::table('tbl_school')
                    ->where('school_id', '=', $Detail->school_id)
                    ->update([
                        'login_mail' => null,
                        'logContId' => null,
                        'logContItemId' => null,
                        'password' => null
                    ]);
            }
        }

        return 1;
    }

    public function logSchoolContactItemInsert(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;
            // $school_id = $request->school_id;
            $receiveInvoices_status = 0;
            if ($request->receiveInvoices_status) {
                $receiveInvoices_status = -1;
            }
            $schoolContact_id = null;
            if ($request->schoolContact_id) {
                $schoolContact_id = $request->schoolContact_id;
            }
            if ($request->schoolMainId) {
                $schoolContact_id = null;
            }
            DB::table('tbl_contactItemSch')
                ->insert([
                    'school_id' => $school_id,
                    'schoolContact_id' => $schoolContact_id,
                    'type_int' => $request->type_int,
                    'contactItem_txt' => $request->contactItem_txt,
                    'receiveInvoices_status' => $receiveInvoices_status,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Contact item added successfully.");
        } else {
            return redirect()->intended('/school');
        }
    }

    public function logSchoolContactItemDetail(Request $request)
    {
        $input = $request->all();
        $contactItemSch_id = $input['editContactItemId'];
        $school_id = $input['contactItemSchoolId'];

        $contactItemDetail = DB::table('tbl_contactItemSch')
            ->where('contactItemSch_id', "=", $contactItemSch_id)
            ->first();

        $contactMethodList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 13)
            ->get();

        $schoolContacts = DB::table('tbl_schoolContact')
            ->LeftJoin('tbl_description as JobRole', function ($join) {
                $join->on('JobRole.description_int', '=', 'tbl_schoolContact.jobRole_int')
                    ->where(function ($query) {
                        $query->where('JobRole.descriptionGroup_int', '=', 11);
                    });
            })
            ->LeftJoin('tbl_description as TitleTbl', function ($join) {
                $join->on('TitleTbl.description_int', '=', 'tbl_schoolContact.title_int')
                    ->where(function ($query) {
                        $query->where('TitleTbl.descriptionGroup_int', '=', 1);
                    });
            })
            ->select('tbl_schoolContact.*', 'JobRole.description_txt as jobRole_txt', 'TitleTbl.description_txt as title_txt')
            ->where('tbl_schoolContact.school_id', $school_id)
            ->where('tbl_schoolContact.isCurrent_status', '-1')
            ->get();

        $view = view("web.schoolPortal.contact_item_edit_view", ['contactItemDetail' => $contactItemDetail, 'contactMethodList' => $contactMethodList, 'schoolContacts' => $schoolContacts])->render();
        return response()->json(['html' => $view]);
    }

    public function logSchoolContactItemUpdate(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;
            $contactItemSch_id = $request->editContactItemId;
            // $school_id = $request->school_id;
            $receiveInvoices_status = 0;
            if ($request->receiveInvoices_status) {
                $receiveInvoices_status = -1;
            }
            $schoolContact_id = null;
            if ($request->schoolContact_id) {
                $schoolContact_id = $request->schoolContact_id;
            }
            if ($request->schoolMainId) {
                $schoolContact_id = null;
            }
            DB::table('tbl_contactItemSch')
                ->where('contactItemSch_id', '=', $contactItemSch_id)
                ->update([
                    'schoolContact_id' => $schoolContact_id,
                    'type_int' => $request->type_int,
                    'contactItem_txt' => $request->contactItem_txt,
                    'receiveInvoices_status' => $receiveInvoices_status,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Contact item updated successfully.");
        } else {
            return redirect()->intended('/school');
        }
    }

    public function logSchoolContactItemDelete(Request $request)
    {
        $contactItemSch_id = $request->editContactItemId;
        $Detail = DB::table('tbl_contactItemSch')
            ->where('contactItemSch_id', '=', $contactItemSch_id)
            ->first();

        DB::table('tbl_contactItemSch')
            ->where('contactItemSch_id', '=', $contactItemSch_id)
            ->delete();

        if ($Detail) {
            $userExist = DB::table('tbl_school')
                ->where('tbl_school.school_id', $Detail->school_id)
                ->where('tbl_school.logContItemId', $contactItemSch_id)
                ->first();
            if ($userExist) {
                DB::table('tbl_school')
                    ->where('school_id', '=', $Detail->school_id)
                    ->update([
                        'login_mail' => null,
                        'logContId' => null,
                        'logContItemId' => null,
                        'password' => null
                    ]);
            }
        }

        return 1;
    }

    public function logSchoolFinance(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $title = array('pageTitle' => "School Finance");
            $headerTitle = "Schools";
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;
            $contId = $schoolLoginData->logContId;
            $canUpTimesheet = 0;
            if ($contId) {
                $contDet = DB::table('tbl_schoolContact')
                    ->where('contact_id', $contId)
                    ->first();
                if ($contDet && $contDet->receiveTimesheets_status == -1) {
                    $canUpTimesheet = 1;
                }
            }

            if ($request->date) {
                $weekStartDate = $request->date;
            } else {
                $now = Carbon::now();
                $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            }
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
            $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
            $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
            $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekEndDate = Carbon::parse($weekStartDate)->endOfWeek()->format('Y-m-d');

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $school_id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                ->first();

            $Invoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_description as SchoolPaymentMethod', function ($join) {
                    $join->on('SchoolPaymentMethod.description_int', '=', 'tbl_invoice.school_paid_method')
                        ->where(function ($query) {
                            $query->where('SchoolPaymentMethod.descriptionGroup_int', '=', 42);
                        });
                })
                ->select('tbl_invoice.*', 'SchoolPaymentMethod.description_txt as paymentMethod_txt', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.school_id', $school_id);
            if ($request->include == '') {
                $Invoices->where('tbl_invoice.paidOn_dte', NULL)
                    ->where('tbl_invoice.school_paid_dte', NULL);
            }
            if ($request->method) {
                $Invoices->where('tbl_invoice.paymentMethod_int', $request->method);
            }
            $schoolInvoices = $Invoices->groupBy('tbl_invoice.invoice_id')
                ->get();

            $schoolPaidInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_description as SchoolPaymentMethod', function ($join) {
                    $join->on('SchoolPaymentMethod.description_int', '=', 'tbl_invoice.school_paid_method')
                        ->where(function ($query) {
                            $query->where('SchoolPaymentMethod.descriptionGroup_int', '=', 42);
                        });
                })
                ->select('tbl_invoice.*', 'SchoolPaymentMethod.description_txt as paymentMethod_txt', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.school_id', $school_id)
                ->where('tbl_invoice.school_paid_dte', '!=', NULL)
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->groupBy('tbl_invoice.invoice_id')
                ->get();

            $documentList = DB::table('teacher_timesheet')
                ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('pdf', 'teacher_timesheet.pdf_id', '=', 'pdf.pdf_id')
                ->select('teacher_timesheet.*', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'pdf.pdf_name', 'pdf.pdf_path')
                ->where('teacher_timesheet.timesheet_status', 0)
                ->where('teacher_timesheet.submit_status', 1)
                ->where('teacher_timesheet.reject_status', 0)
                ->where('teacher_timesheet.approve_by_school', '=', 1)
                ->where('teacher_timesheet.school_id', '=', $school_id)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('teacher_timesheet.teacher_timesheet_id')
                ->orderBy('teacher_timesheet.start_date', 'ASC')
                ->get();

            $paymentMethodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 42)
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
                ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), DB::raw("0 AS reject_status"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem1.start_tm AS start_tm1', 'tbl_asnItem1.end_tm AS end_tm1', 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem2.start_tm AS start_tm2', 'tbl_asnItem2.end_tm AS end_tm2', 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem3.start_tm AS start_tm3', 'tbl_asnItem3.end_tm AS end_tm3', 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem4.start_tm AS start_tm4', 'tbl_asnItem4.end_tm AS end_tm4', 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"), 'tbl_asnItem5.start_tm AS start_tm5', 'tbl_asnItem5.end_tm AS end_tm5')
                ->whereIn('tbl_asn.asn_id', function ($query) use ($weekStartDate, $weekEndDate, $company_id, $school_id) {
                    $query->select('tbl_asn.asn_id')
                        ->from('tbl_asn')
                        ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->where('timesheet_id', NULL)
                        ->where('status_int', 3)
                        ->whereDate('asnDate_dte', '>=', $weekStartDate)
                        ->whereDate('asnDate_dte', '<=', $weekEndDate)
                        ->where('company_id', $company_id)
                        ->where('admin_approve', 1)
                        ->where('send_to_school', 1)
                        ->where('tbl_asn.school_id', $school_id)
                        ->groupBy('tbl_asn.asn_id')
                        ->get();
                })
                ->where('tbl_asn.school_id', $school_id)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();

            $teacherList = DB::table('teacher_timesheet')
                ->join('teacher_timesheet_item', 'teacher_timesheet.teacher_timesheet_id', '=', 'teacher_timesheet_item.teacher_timesheet_id')
                ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('teacher_timesheet.*', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'teacher_timesheet_item.start_tm as t_start_tm', 'teacher_timesheet_item.end_tm as t_end_tm', 'teacher_timesheet_item.timesheet_item_id', 'teacher_timesheet_item.asn_id as t_asn_id', 'teacher_timesheet_item.asnItem_id as t_asnItem_id', 'teacher_timesheet_item.school_id as t_school_id', 'teacher_timesheet_item.teacher_id as t_teacher_id', 'teacher_timesheet_item.admin_approve as t_admin_approve', 'teacher_timesheet_item.send_to_school as t_send_to_school', 'teacher_timesheet_item.rejected_by_type as t_rejected_by_type', 'teacher_timesheet_item.rejected_by as t_rejected_by', 'teacher_timesheet_item.rejected_text as t_rejected_text')
                ->where('teacher_timesheet_item.school_id', $school_id)
                ->where('teacher_timesheet_item.send_to_school', 1)
                ->where('teacher_timesheet_item.admin_approve', '!=', 1)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('teacher_timesheet.teacher_id', 'teacher_timesheet_item.asnDate_dte')
                ->orderBy('teacher_timesheet.teacher_id', 'ASC')
                ->orderBy('teacher_timesheet_item.asnDate_dte', 'DESC')
                ->get();

            $thresholdDate = Carbon::now()->subDays(30);
            $invoiceCal = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select(DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"))
                ->where('tbl_invoice.school_id', $school_id)
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->first();

            $invoiceOverdueCal = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select(DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"))
                ->where('tbl_invoice.school_id', $school_id)
                ->where('tbl_invoice.paidOn_dte', NULL)
                ->where('tbl_invoice.invoiceDate_dte', '<', $thresholdDate)
                ->first();

            return view("web.schoolPortal.school_finance", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'school_id' => $school_id, 'schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'paymentMethodList' => $paymentMethodList, 'documentList' => $documentList, 'weekStartDate' => $weekStartDate, 'plusFiveDate' => $plusFiveDate, 'calenderList' => $calenderList, 'schoolPaidInvoices' => $schoolPaidInvoices, 'teacherList' => $teacherList, 'canUpTimesheet' => $canUpTimesheet, 'invoiceCal' => $invoiceCal, 'invoiceOverdueCal' => $invoiceOverdueCal]);
        } else {
            return redirect()->intended('/school');
        }
    }

    public function logSchfetchTeacherSheetById(Request $request)
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
            ->select('teacher_timesheet.*', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'teacher_timesheet_item.start_tm as t_start_tm', 'teacher_timesheet_item.end_tm as t_end_tm', 'teacher_timesheet_item.timesheet_item_id', 'teacher_timesheet_item.asn_id as t_asn_id', 'teacher_timesheet_item.asnItem_id as t_asnItem_id', 'teacher_timesheet_item.school_id as t_school_id', 'teacher_timesheet_item.teacher_id as t_teacher_id', 'teacher_timesheet_item.admin_approve as t_admin_approve', 'teacher_timesheet_item.send_to_school as t_send_to_school', 'teacher_timesheet_item.rejected_by_type as t_rejected_by_type', 'teacher_timesheet_item.rejected_by as t_rejected_by', 'teacher_timesheet_item.rejected_text as t_rejected_text')
            // ->whereDate('teacher_timesheet_item.asnDate_dte', '<=', $max_date)
            ->where('teacher_timesheet_item.school_id', $school_id)
            ->where('teacher_timesheet_item.send_to_school', 1)
            ->where('teacher_timesheet_item.admin_approve', '!=', 1)
            // ->where('tbl_teacher.is_delete', 0)
            ->groupBy('teacher_timesheet.teacher_id', 'teacher_timesheet_item.asnDate_dte')
            ->orderBy('teacher_timesheet.teacher_id', 'ASC')
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

                $startTime = '';
                if ($teacher->t_start_tm) {
                    $startTime = date("h:i a", strtotime($teacher->t_start_tm));
                }
                $endTime = '';
                if ($teacher->t_end_tm) {
                    $endTime = date("h:i a", strtotime($teacher->t_end_tm));
                }
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

                $html .= "<tr class='school-detail-table-data selectLogTeacherRow' id='selectLogTeacherRow$teacher->timesheet_item_id' teacher-id='$teacher->t_teacher_id' asn-id='$teacher->t_asn_id' timesheet-item-id='$teacher->timesheet_item_id' school-id='$teacher->t_school_id'>
                    <td>$name</td>
                    <td>$teacher->asnDate_dte</td>
                    <td>$teacher->datePart_txt</td>
                    <td>$startTime</td>
                    <td>$endTime</td>
                    <td>$tStatus</td>
                </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function logSchteacherItemSheetReject(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;
            $input = $request->all();
            $asnId = $input['asnItemIds'];
            $asnIdsArr = explode(",", $asnId);

            DB::table('teacher_timesheet_item')
                ->whereIn('timesheet_item_id', $asnIdsArr)
                ->update([
                    'admin_approve' => 2,
                    'rejected_by_type' => 'School',
                    'rejected_by' => $school_id,
                    'rejected_text' => $request->remark
                ]);

            // send mail to admin
            $schoolDet = DB::table('tbl_school')
                ->select('tbl_school.*')
                ->where('school_id', $school_id)
                ->first();
            if ($schoolDet && count($asnIdsArr) > 0) {
                $teacherList = DB::table('teacher_timesheet')
                    ->join('teacher_timesheet_item', 'teacher_timesheet.teacher_timesheet_id', '=', 'teacher_timesheet_item.teacher_timesheet_id')
                    ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
                    ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
                    ->select('teacher_timesheet.*', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'teacher_timesheet_item.start_tm as t_start_tm', 'teacher_timesheet_item.end_tm as t_end_tm', 'teacher_timesheet_item.timesheet_item_id', 'teacher_timesheet_item.asn_id as t_asn_id', 'teacher_timesheet_item.asnItem_id as t_asnItem_id', 'teacher_timesheet_item.school_id as t_school_id', 'teacher_timesheet_item.teacher_id as t_teacher_id', 'teacher_timesheet_item.admin_approve as t_admin_approve', 'teacher_timesheet_item.send_to_school as t_send_to_school', 'teacher_timesheet_item.rejected_by_type as t_rejected_by_type', 'teacher_timesheet_item.rejected_by as t_rejected_by', 'teacher_timesheet_item.rejected_text as t_rejected_text')
                    ->where('teacher_timesheet_item.school_id', $school_id)
                    ->where('teacher_timesheet_item.send_to_school', 1)
                    ->where('teacher_timesheet_item.admin_approve', '!=', 1)
                    ->whereIn('timesheet_item_id', $asnIdsArr)
                    ->groupBy('teacher_timesheet.teacher_id', 'teacher_timesheet_item.asnDate_dte')
                    ->orderBy('teacher_timesheet.teacher_id', 'ASC')
                    ->orderBy('teacher_timesheet_item.asnDate_dte', 'DESC')
                    ->get();

                $companyDetail = DB::table('company')
                    ->select('company.*')
                    ->where('company.company_id', $schoolDet->company_id)
                    ->first();
                $contactDetNew = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $school_id)
                    ->first();
                $adminDet = DB::table('tbl_user')
                    ->select('tbl_user.*')
                    ->where('tbl_user.company_id', $schoolDet->company_id)
                    ->where('tbl_user.admin_type', 1)
                    ->where('tbl_user.is_delete', 0)
                    ->where('tbl_user.isCurrent_status', '=', -1)
                    ->get();
                foreach ($adminDet as $key => $value) {
                    if ($value->user_name) {
                        $email = $value->user_name;
                        $name = $value->firstName_txt . ' ' . $value->surname_txt;

                        $mailData['companyDetail'] = $companyDetail;
                        $mailData['name'] = $name;
                        $mailData['mail'] = $email;
                        $mailData['schoolDet'] = $schoolDet;
                        $mailData['teacherList'] = $teacherList;
                        $mailData['remark'] = $request->remark;
                        $mailData['contactDetNew'] = $contactDetNew;
                        $mailData['date'] = date("d-m-Y H:i");
                        $myVar = new AlertController();
                        $myVar->mailAdminLogSchTchrItemAfterReject($mailData);
                    }
                }
            }

            return true;
        }
        return true;
    }

    public function logSchTeacherItemSheetApprove(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        $result['add'] = 'No';
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            $asnItemIds = $request->asnItemIds;
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
                            'approve_by' => $school_id,
                            'approve_by_type' => 'School',
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
                ->where('school_id', $school_id)
                ->first();

            if (count($idsArr) > 0) {
                $itemList = DB::table('tbl_asnItem')
                    ->LeftJoin('tbl_asn', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                    ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                    ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                    ->select('tbl_asnItem.asnItem_id', 'tbl_asnItem.asn_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm')
                    // ->where('tbl_teacher.is_delete', 0)
                    ->whereIn('tbl_asnItem.asnItem_id', $idsArr)
                    ->groupBy('tbl_asnItem.asnItem_id')
                    ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                    ->get();

                $timesheet_id = DB::table('tbl_timesheet')
                    ->insertGetId([
                        'school_id' => $school_id,
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

                // send mail to admin
                $contactDetNew = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $school_id)
                    ->first();

                $adminDet = DB::table('tbl_user')
                    ->select('tbl_user.*')
                    ->where('tbl_user.company_id', $company_id)
                    ->where('tbl_user.admin_type', 1)
                    ->where('tbl_user.isCurrent_status', '=', -1)
                    ->get();
                foreach ($adminDet as $key => $value) {
                    if ($value->user_name) {
                        $email = $value->user_name;
                        $name = $value->firstName_txt . ' ' . $value->surname_txt;

                        $mailData['companyDetail'] = $companyDetail;
                        $mailData['name'] = $name;
                        $mailData['mail'] = $email;
                        $mailData['schoolDet'] = $schoolDet;
                        $mailData['timesheet_id'] = $timesheet_id;
                        $mailData['contactDetNew'] = $contactDetNew;
                        $mailData['date'] = date("d-m-Y H:i");
                        $myVar = new AlertController();
                        $myVar->mailAdminAfterApproval($mailData);
                    }
                }

                $result['add'] = 'Yes';
                $result['timesheet_id'] = $timesheet_id;
                $result['schoolName'] = $schoolDet ? $schoolDet->name_txt : '';
                return $result;
            }
        }

        return $result;
    }

    public function logSchoolInvoicePdf(Request $request, $id, $invoice_id)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                ->first();

            $schoolInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
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

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
            $comFooterLogos = DB::table('company_logo')
                ->where('company_logo.company_id', $company_id)
                ->orderBy('company_logo.image_id', 'DESC')
                ->get();

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

            $pdf = PDF::loadView('web.school.school_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail, 'contactDet' => $contactDet, 'comFooterLogos' => $comFooterLogos]);
            $pdfName = 'invoice-' . $id . '.pdf';
            // return $pdf->download('test.pdf');
            return $pdf->stream($pdfName);
        } else {
            return redirect()->intended('/school');
        }
    }

    public function logSchoolTeacherSheet(Request $request)
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
            // ->where('tbl_teacher.is_delete', 0)
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

    public function approveTeacherSheet(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;
            $input = $request->all();
            $teacher_timesheet_id = $input['teacher_timesheet_id'];
            $status = $input['status'];

            DB::table('teacher_timesheet')
                ->where('teacher_timesheet_id', '=', $teacher_timesheet_id)
                ->update([
                    'approve_by_school' => $status,
                    'approveBy' => $school_id
                ]);

            return true;
        }
        return true;
    }

    public function logSchoolPassword(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $title = array('pageTitle' => "School Change Password");
            $headerTitle = "Schools";
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;

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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_school.school_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 2);
                        });
                })
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp', 'tbl_userFavourite.favourite_id')
                ->where('tbl_school.school_id', $school_id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                // ->take(1)
                ->first();

            return view("web.schoolPortal.school_password", ['pagetitle' => $title, 'headerTitle' => $headerTitle, 'schoolDetail' => $schoolDetail, 'school_id' => $school_id]);
        } else {
            return redirect()->intended('/school');
        }
    }

    public function LogSchoolPasswordUpdate(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;

            if ($request->password != $request->confirm_password) {
                return redirect()->back()->with('error', "Password and confirm password not match.");
            } else {
                DB::table('tbl_school')
                    ->where('school_id', '=', $school_id)
                    ->update([
                        'password' => Hash::make($request->password)
                    ]);
                return redirect()->back()->with('success', "Password updated successfully.");
            }
        } else {
            return redirect()->intended('/school');
        }
    }

    public function logSchoolProfilePicAdd(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;

            $schoolDet = DB::table('tbl_school')
                ->where('school_id', $school_id)
                ->first();

            $fPath = '';
            $fType = '';
            $allowed_types = array('jpg', 'png', 'jpeg');
            if ($image = $request->file('file')) {
                $extension = $image->getClientOriginalExtension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "." . $extension;
                    if ($image->move(public_path('images/school'), $name)) {
                        $fPath = 'images/school/' . $name;
                        $fType = $extension;
                    }
                } else {
                    return redirect()->back()->with('error', "Please upload valid file.");
                }
            } else {
                return redirect()->back()->with('error', "Please upload valid file.");
            }

            if ($fPath) {
                DB::table('tbl_school')
                    ->where('school_id', '=', $school_id)
                    ->update([
                        'profile_pic' => $fPath
                    ]);

                if ($schoolDet) {
                    if (file_exists($schoolDet->profile_pic)) {
                        unlink($schoolDet->profile_pic);
                    }
                }
            }

            return redirect()->back()->with('success', "Profile image added successfully.");
        } else {
            return redirect()->intended('/school');
        }
    }

    public function logSchoolProfilePicDelete(Request $request)
    {
        if ($request->school_id) {
            $school_id = $request->school_id;

            $schoolDet = DB::table('tbl_school')
                ->where('school_id', $school_id)
                ->first();

            DB::table('tbl_school')
                ->where('school_id', '=', $school_id)
                ->update([
                    'profile_pic' => NULL
                ]);

            if ($schoolDet) {
                if (file_exists($schoolDet->profile_pic)) {
                    unlink($schoolDet->profile_pic);
                }
            }
        }
        return true;
    }

    public function logSchoolTimesheetLog(Request $request)
    {
        $result['add'] = 'No';
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;
            $asnId = $request->approveAsnId;
            $weekStartDate = $request->weekStartDate;
            $weekEndDate = $request->weekEndDate;

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

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
                ->where('tbl_asn.school_id', $school_id)
                ->where('admin_approve', 1)
                ->where('send_to_school', 1)
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
                    // ->where('tbl_teacher.is_delete', 0)
                    ->groupBy('tbl_asnItem.asnItem_id')
                    ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                    ->get();

                $timesheet_id = DB::table('tbl_timesheet')
                    ->insertGetId([
                        'school_id' => $schoolDet->school_id,
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

                // send mail to admin
                $contactDetNew = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $school_id)
                    ->first();

                $adminDet = DB::table('tbl_user')
                    ->select('tbl_user.*')
                    ->where('tbl_user.company_id', $company_id)
                    ->where('tbl_user.admin_type', 1)
                    ->where('tbl_user.isCurrent_status', '=', -1)
                    ->get();
                foreach ($adminDet as $key => $value) {
                    if ($value->user_name) {
                        $email = $value->user_name;
                        $name = $value->firstName_txt . ' ' . $value->surname_txt;

                        $mailData['companyDetail'] = $companyDetail;
                        $mailData['name'] = $name;
                        $mailData['mail'] = $email;
                        $mailData['schoolDet'] = $schoolDet;
                        $mailData['timesheet_id'] = $timesheet_id;
                        $mailData['contactDetNew'] = $contactDetNew;
                        $mailData['date'] = date("d-m-Y H:i");
                        $myVar = new AlertController();
                        $myVar->mailAdminAfterApproval($mailData);
                    }
                }

                $result['add'] = 'Yes';
                $result['timesheet_id'] = $timesheet_id;
                $result['schoolName'] = $schoolDet ? $schoolDet->name_txt : '';
                return $result;
            }
        }
        return $result;
    }

    public function logSchoolTimesheetReject(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;
            $input = $request->all();
            $asnId = $input['asnId'];
            $weekStartDate = $input['weekStartDate'];
            $weekEndDate = $input['weekEndDate'];
            $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
            $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
            $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
            $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));

            $idsArr = DB::table('tbl_asn')
                ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('timesheet_id', NULL)
                ->where('status_int', 3)
                ->whereDate('asnDate_dte', '>=', $weekStartDate)
                ->whereDate('asnDate_dte', '<=', $weekEndDate)
                ->where('tbl_asn.asn_id', $asnId)
                ->where('company_id', $company_id)
                ->where('tbl_asn.school_id', $school_id)
                ->where('admin_approve', 1)
                ->where('send_to_school', 1)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->pluck('tbl_asnItem.asnItem_id')
                ->toArray();

            DB::table('tbl_asnItem')
                ->whereIn('asnItem_id', $idsArr)
                ->update([
                    'send_to_school' => 0,
                    'admin_approve' => 2,
                    'rejected_by_type' => 'School',
                    'rejected_by' => $school_id,
                    'rejected_text' => $request->remark
                ]);

            // send mail to admin
            $schoolDet = DB::table('tbl_school')
                ->select('tbl_school.*')
                ->where('school_id', $school_id)
                ->first();
            if ($schoolDet && count($idsArr) > 0) {
                $itemList = DB::table('tbl_asn')
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
                    ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), DB::raw("0 AS reject_status"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem1.start_tm AS start_tm1', 'tbl_asnItem1.end_tm AS end_tm1', 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem2.start_tm AS start_tm2', 'tbl_asnItem2.end_tm AS end_tm2', 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem3.start_tm AS start_tm3', 'tbl_asnItem3.end_tm AS end_tm3', 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem4.start_tm AS start_tm4', 'tbl_asnItem4.end_tm AS end_tm4', 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"), 'tbl_asnItem5.start_tm AS start_tm5', 'tbl_asnItem5.end_tm AS end_tm5')
                    ->whereIn('tbl_asn.asn_id', function ($query) use ($weekStartDate, $weekEndDate, $company_id, $school_id) {
                        $query->select('tbl_asn.asn_id')
                            ->from('tbl_asn')
                            ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                            ->where('timesheet_id', NULL)
                            ->where('status_int', 3)
                            ->whereDate('asnDate_dte', '>=', $weekStartDate)
                            ->whereDate('asnDate_dte', '<=', $weekEndDate)
                            ->where('company_id', $company_id)
                            ->where('admin_approve', 1)
                            ->where('send_to_school', 1)
                            ->where('tbl_asn.school_id', $school_id)
                            ->groupBy('tbl_asn.asn_id')
                            ->get();
                    })
                    ->where('tbl_asn.school_id', $school_id)
                    ->groupBy('tbl_asn.asn_id')
                    ->orderBy('tbl_school.name_txt', 'ASC')
                    ->get();

                $companyDetail = DB::table('company')
                    ->select('company.*')
                    ->where('company.company_id', $schoolDet->company_id)
                    ->first();
                $contactDetNew = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $school_id)
                    ->first();
                $adminDet = DB::table('tbl_user')
                    ->select('tbl_user.*')
                    ->where('tbl_user.company_id', $schoolDet->company_id)
                    ->where('tbl_user.admin_type', 1)
                    ->where('tbl_user.is_delete', 0)
                    ->where('tbl_user.isCurrent_status', '=', -1)
                    ->get();
                foreach ($adminDet as $key => $value) {
                    if ($value->user_name) {
                        $email = $value->user_name;
                        $name = $value->firstName_txt . ' ' . $value->surname_txt;

                        $mailData['companyDetail'] = $companyDetail;
                        $mailData['name'] = $name;
                        $mailData['mail'] = $email;
                        $mailData['schoolDet'] = $schoolDet;
                        $mailData['itemList'] = $itemList;
                        $mailData['remark'] = $request->remark;
                        $mailData['weekStartDate'] = $weekStartDate;
                        $mailData['contactDetNew'] = $contactDetNew;
                        $mailData['date'] = date("d-m-Y H:i");
                        $myVar = new AlertController();
                        $myVar->mailAdminLogSchAfterReject($mailData);
                    }
                }
            }

            return true;
        }
        return true;
    }

    public function logSchTimesheetDir(Request $request, $asn_id, $school_id, $start, $end)
    {
        $asnId = base64_decode($asn_id);
        $startDate = base64_decode($start);
        $endDate = base64_decode($end);
        $schoolId = base64_decode($school_id);

        $title = array('pageTitle' => "School Timesheet");
        $headerTitle = "Schools";

        $schoolDet = DB::table('tbl_school')
            ->select('tbl_school.*')
            ->where('school_id', $schoolId)
            ->first();
        if ($schoolDet) {
            $company_id = $schoolDet->company_id;
            $weekStartDate = $startDate;
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
            $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
            $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
            $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekEndDate = $endDate;

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
                ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), DB::raw("0 AS reject_status"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"))
                ->whereIn('tbl_asn.asn_id', function ($query) use ($weekStartDate, $weekEndDate, $company_id, $schoolId) {
                    $query->select('tbl_asn.asn_id')
                        ->from('tbl_asn')
                        ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->where('timesheet_id', NULL)
                        ->where('status_int', 3)
                        ->whereDate('asnDate_dte', '>=', $weekStartDate)
                        ->whereDate('asnDate_dte', '<=', $weekEndDate)
                        ->where('company_id', $company_id)
                        ->where('admin_approve', 1)
                        ->where('send_to_school', 1)
                        ->where('tbl_asn.school_id', $schoolId)
                        ->groupBy('tbl_asn.asn_id')
                        ->get();
                })
                ->where('tbl_asn.school_id', $schoolId)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();

            return view("web.schoolPortal.school_timesheet_dir", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $schoolId, 'schoolDetail' => $schoolDet, 'weekStartDate' => $weekStartDate, 'plusFiveDate' => $plusFiveDate, 'calenderList' => $calenderList, 'asnId' => $asnId]);
        }
    }

    public function logSchoolTimesheetRejectDir(Request $request)
    {
        $input = $request->all();
        $school_id = $input['school_id'];
        $asnId = $input['asnId'];
        $weekStartDate = $input['weekStartDate'];
        $weekEndDate = $input['weekEndDate'];
        $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
        $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
        $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
        $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));

        $idsArr = DB::table('tbl_asn')
            ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->where('timesheet_id', NULL)
            ->where('status_int', 3)
            ->whereDate('asnDate_dte', '>=', $weekStartDate)
            ->whereDate('asnDate_dte', '<=', $weekEndDate)
            ->where('tbl_asn.asn_id', $asnId)
            ->where('tbl_asn.school_id', $school_id)
            ->where('admin_approve', 1)
            ->where('send_to_school', 1)
            ->groupBy('tbl_asnItem.asnItem_id')
            ->pluck('tbl_asnItem.asnItem_id')
            ->toArray();

        DB::table('tbl_asnItem')
            ->whereIn('asnItem_id', $idsArr)
            ->update([
                'send_to_school' => 0,
                'admin_approve' => 2,
                'rejected_by_type' => 'School',
                'rejected_by' => $school_id,
                'rejected_text' => $request->remark
            ]);

        // send mail to admin
        $schoolDet = DB::table('tbl_school')
            ->select('tbl_school.*')
            ->where('school_id', $school_id)
            ->first();
        if ($schoolDet && count($idsArr) > 0) {
            $itemList = DB::table('tbl_asn')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('tbl_asnItem as tbl_asnItem1', function ($join) use ($weekStartDate, $idsArr) {
                    $join->on('tbl_asnItem1.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate, $idsArr) {
                            $query->where('tbl_asnItem1.timesheet_id', NULL)
                                ->where('tbl_asnItem1.asnDate_dte', '=', $weekStartDate);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem2', function ($join) use ($weekStartDate2, $idsArr) {
                    $join->on('tbl_asnItem2.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate2, $idsArr) {
                            $query->where('tbl_asnItem2.timesheet_id', NULL)
                                ->where('tbl_asnItem2.asnDate_dte', '=', $weekStartDate2);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem3', function ($join) use ($weekStartDate3, $idsArr) {
                    $join->on('tbl_asnItem3.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate3, $idsArr) {
                            $query->where('tbl_asnItem3.timesheet_id', NULL)
                                ->where('tbl_asnItem3.asnDate_dte', '=', $weekStartDate3);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem4', function ($join) use ($weekStartDate4, $idsArr) {
                    $join->on('tbl_asnItem4.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate4, $idsArr) {
                            $query->where('tbl_asnItem4.timesheet_id', NULL)
                                ->where('tbl_asnItem4.asnDate_dte', '=', $weekStartDate4);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem5', function ($join) use ($weekStartDate5, $idsArr) {
                    $join->on('tbl_asnItem5.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate5, $idsArr) {
                            $query->where('tbl_asnItem5.timesheet_id', NULL)
                                ->where('tbl_asnItem5.asnDate_dte', '=', $weekStartDate5);
                        });
                })
                ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), DB::raw("0 AS reject_status"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem1.start_tm AS start_tm1', 'tbl_asnItem1.end_tm AS end_tm1', 'tbl_asnItem1.lunch_time AS lunch_time1', 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem2.start_tm AS start_tm2', 'tbl_asnItem2.end_tm AS end_tm2', 'tbl_asnItem2.lunch_time AS lunch_time2', 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem3.start_tm AS start_tm3', 'tbl_asnItem3.end_tm AS end_tm3', 'tbl_asnItem3.lunch_time AS lunch_time3', 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem4.start_tm AS start_tm4', 'tbl_asnItem4.end_tm AS end_tm4', 'tbl_asnItem4.lunch_time AS lunch_time4', 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"), 'tbl_asnItem5.start_tm AS start_tm5', 'tbl_asnItem5.end_tm AS end_tm5', 'tbl_asnItem5.lunch_time AS lunch_time5')
                ->whereIn('tbl_asn.asn_id', function ($query) use ($idsArr) {
                    $query->select('tbl_asn.asn_id')
                        ->from('tbl_asn')
                        ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->whereIn('tbl_asnItem.asnItem_id', $idsArr)
                        ->groupBy('tbl_asn.asn_id')
                        ->get();
                })
                ->groupBy('tbl_asn.asn_id')
                ->get();

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $schoolDet->company_id)
                ->first();
            $contactDetNew = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $school_id)
                ->first();
            $adminDet = DB::table('tbl_user')
                ->select('tbl_user.*')
                ->where('tbl_user.company_id', $schoolDet->company_id)
                ->where('tbl_user.admin_type', 1)
                ->where('tbl_user.is_delete', 0)
                ->where('tbl_user.isCurrent_status', '=', -1)
                ->get();
            foreach ($adminDet as $key => $value) {
                if ($value->user_name) {
                    $email = $value->user_name;
                    $name = $value->firstName_txt . ' ' . $value->surname_txt;

                    $mailData['companyDetail'] = $companyDetail;
                    $mailData['name'] = $name;
                    $mailData['mail'] = $email;
                    $mailData['schoolDet'] = $schoolDet;
                    $mailData['itemList'] = $itemList;
                    $mailData['rejected_text'] = $request->remark;
                    $mailData['weekStartDate'] = $weekStartDate;
                    $mailData['contactDetNew'] = $contactDetNew;
                    $mailData['date'] = date("d-m-Y H:i");
                    $myVar = new AlertController();
                    $myVar->mailAdminAfterReject($mailData);
                }
            }
        }

        if (count($idsArr) > 0) {
            $result['add'] = 'Yes';
        } else {
            $result['add'] = 'No';
        }

        return $result;
    }

    public function logSchoolTimesheetLogDir(Request $request)
    {
        $result['add'] = 'No';
        $school_id = $request->school_id;
        $asnId = $request->approveAsnId;
        $weekStartDate = $request->weekStartDate;
        $weekEndDate = $request->weekEndDate;

        // $schoolLoginData = Session::get('schoolLoginData');
        // $companyDetail = array();
        // if ($schoolLoginData) {
        //     $company_id = $schoolLoginData->company_id;
        //     $companyDetail = DB::table('company')
        //         ->select('company.*')
        //         ->where('company.company_id', $company_id)
        //         ->first();
        // }

        // $schoolDet = DB::table('tbl_asn')
        //     ->select('tbl_asn.school_id', 'tbl_school.name_txt')
        //     ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
        //     ->where('tbl_asn.asn_id', $asnId)
        //     ->first();
        $schoolDet = DB::table('tbl_school')
            ->where('school_id', $school_id)
            ->first();
        $companyDetail = array();
        $company_id = '';
        if ($schoolDet) {
            $company_id = $schoolDet->company_id;
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
        }

        $idsArr = DB::table('tbl_asn')
            ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->where('timesheet_id', NULL)
            ->where('status_int', 3)
            ->whereDate('asnDate_dte', '>=', $weekStartDate)
            ->whereDate('asnDate_dte', '<=', $weekEndDate)
            ->where('tbl_asn.asn_id', $asnId)
            // ->where('company_id', $company_id)
            ->where('tbl_asn.school_id', $school_id)
            ->where('admin_approve', 1)
            ->where('send_to_school', 1)
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
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                ->get();

            $timesheet_id = DB::table('tbl_timesheet')
                ->insertGetId([
                    'school_id' => $schoolDet->school_id,
                    'timestamp_ts' => date('Y-m-d H:i:s'),
                    'log_by_type' => 'School',
                    'log_by' => $school_id
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
                        'timesheet_id' => $timesheet_id
                    ]);

                DB::table('teacher_timesheet_item')
                    ->where('asnItem_id', $id)
                    ->update([
                        'admin_approve' => 1,
                        'approve_by' => $school_id,
                        'approve_by_type' => 'School',
                        'approve_by_dte' => date('Y-m-d H:i:s'),
                    ]);
            }

            // send mail to admin
            $contactDetNew = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $school_id)
                ->first();

            $adminDet = DB::table('tbl_user')
                ->select('tbl_user.*')
                ->where('tbl_user.company_id', $company_id)
                ->where('tbl_user.admin_type', 1)
                ->where('tbl_user.isCurrent_status', '=', -1)
                ->get();
            foreach ($adminDet as $key => $value) {
                if ($value->user_name) {
                    $email = $value->user_name;
                    $name = $value->firstName_txt . ' ' . $value->surname_txt;

                    $mailData['companyDetail'] = $companyDetail;
                    $mailData['name'] = $name;
                    $mailData['mail'] = $email;
                    $mailData['schoolDet'] = $schoolDet;
                    $mailData['timesheet_id'] = $timesheet_id;
                    $mailData['contactDetNew'] = $contactDetNew;
                    $mailData['date'] = date("d-m-Y H:i");
                    $myVar = new AlertController();
                    $myVar->mailAdminAfterApproval($mailData);
                }
            }

            $result['add'] = 'Yes';
            $result['timesheet_id'] = $timesheet_id;
            $result['schoolName'] = $schoolDet ? $schoolDet->name_txt : '';
            return $result;
        }
        return $result;
    }

    /*********/
    public function logSchTimesheetDirAll(Request $request, $asn_id, $school_id, $start, $end)
    {
        $asnId = base64_decode($asn_id);
        $startDate = base64_decode($start);
        $endDate = base64_decode($end);
        $schoolId = base64_decode($school_id);

        $title = array('pageTitle' => "School Timesheet");
        $headerTitle = "Schools";

        $schoolDet = DB::table('tbl_school')
            ->select('tbl_school.*')
            ->where('school_id', $schoolId)
            ->first();
        if ($schoolDet) {
            $company_id = $schoolDet->company_id;
            $weekStartDate = $startDate;
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
            $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
            $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
            $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekEndDate = $endDate;

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
                ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), DB::raw("0 AS reject_status"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"))
                ->whereIn('tbl_asn.asn_id', function ($query) use ($weekStartDate, $weekEndDate, $company_id, $schoolId) {
                    $query->select('tbl_asn.asn_id')
                        ->from('tbl_asn')
                        ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->where('timesheet_id', NULL)
                        ->where('status_int', 3)
                        ->whereDate('asnDate_dte', '>=', $weekStartDate)
                        ->whereDate('asnDate_dte', '<=', $weekEndDate)
                        ->where('company_id', $company_id)
                        ->where('admin_approve', 1)
                        ->where('send_to_school', 1)
                        ->where('tbl_asn.school_id', $schoolId)
                        ->groupBy('tbl_asn.asn_id')
                        ->get();
                })
                ->where('tbl_asn.school_id', $schoolId)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();

            return view("web.schoolPortal.school_timesheet_dir_all", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $schoolId, 'schoolDetail' => $schoolDet, 'weekStartDate' => $weekStartDate, 'plusFiveDate' => $plusFiveDate, 'calenderList' => $calenderList, 'asnId' => $asnId]);
        }
    }

    public function logSchoolTimesheetRejectDirAll(Request $request)
    {
        $input = $request->all();
        $school_id = $input['school_id'];
        $asnId = $input['asnId'];
        $asnIdsArr = explode(",", $asnId);
        $weekStartDate = $input['weekStartDate'];
        $weekEndDate = $input['weekEndDate'];
        $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
        $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
        $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
        $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));

        $idsArr = DB::table('tbl_asn')
            ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->where('timesheet_id', NULL)
            ->where('status_int', 3)
            ->whereDate('asnDate_dte', '>=', $weekStartDate)
            ->whereDate('asnDate_dte', '<=', $weekEndDate)
            ->whereIn('tbl_asn.asn_id', $asnIdsArr)
            ->where('tbl_asn.school_id', $school_id)
            ->where('admin_approve', 1)
            ->where('send_to_school', 1)
            ->groupBy('tbl_asnItem.asnItem_id')
            ->pluck('tbl_asnItem.asnItem_id')
            ->toArray();

        DB::table('tbl_asnItem')
            ->whereIn('asnItem_id', $idsArr)
            ->update([
                'send_to_school' => 0,
                'admin_approve' => 2,
                'rejected_by_type' => 'School',
                'rejected_by' => $school_id,
                'rejected_text' => $request->remark
            ]);

        // send mail to admin
        $schoolDet = DB::table('tbl_school')
            ->select('tbl_school.*')
            ->where('school_id', $school_id)
            ->first();
        if ($schoolDet && count($idsArr) > 0) {
            $itemList = DB::table('tbl_asn')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('tbl_asnItem as tbl_asnItem1', function ($join) use ($weekStartDate, $idsArr) {
                    $join->on('tbl_asnItem1.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate, $idsArr) {
                            $query->where('tbl_asnItem1.timesheet_id', NULL)
                                ->where('tbl_asnItem1.asnDate_dte', '=', $weekStartDate);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem2', function ($join) use ($weekStartDate2, $idsArr) {
                    $join->on('tbl_asnItem2.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate2, $idsArr) {
                            $query->where('tbl_asnItem2.timesheet_id', NULL)
                                ->where('tbl_asnItem2.asnDate_dte', '=', $weekStartDate2);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem3', function ($join) use ($weekStartDate3, $idsArr) {
                    $join->on('tbl_asnItem3.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate3, $idsArr) {
                            $query->where('tbl_asnItem3.timesheet_id', NULL)
                                ->where('tbl_asnItem3.asnDate_dte', '=', $weekStartDate3);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem4', function ($join) use ($weekStartDate4, $idsArr) {
                    $join->on('tbl_asnItem4.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate4, $idsArr) {
                            $query->where('tbl_asnItem4.timesheet_id', NULL)
                                ->where('tbl_asnItem4.asnDate_dte', '=', $weekStartDate4);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem5', function ($join) use ($weekStartDate5, $idsArr) {
                    $join->on('tbl_asnItem5.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate5, $idsArr) {
                            $query->where('tbl_asnItem5.timesheet_id', NULL)
                                ->where('tbl_asnItem5.asnDate_dte', '=', $weekStartDate5);
                        });
                })
                ->select('tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), DB::raw("0 AS reject_status"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem1.start_tm AS start_tm1', 'tbl_asnItem1.end_tm AS end_tm1', 'tbl_asnItem1.lunch_time AS lunch_time1', 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem2.start_tm AS start_tm2', 'tbl_asnItem2.end_tm AS end_tm2', 'tbl_asnItem2.lunch_time AS lunch_time2', 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem3.start_tm AS start_tm3', 'tbl_asnItem3.end_tm AS end_tm3', 'tbl_asnItem3.lunch_time AS lunch_time3', 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem4.start_tm AS start_tm4', 'tbl_asnItem4.end_tm AS end_tm4', 'tbl_asnItem4.lunch_time AS lunch_time4', 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"), 'tbl_asnItem5.start_tm AS start_tm5', 'tbl_asnItem5.end_tm AS end_tm5', 'tbl_asnItem5.lunch_time AS lunch_time5')
                ->whereIn('tbl_asn.asn_id', function ($query) use ($idsArr) {
                    $query->select('tbl_asn.asn_id')
                        ->from('tbl_asn')
                        ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->whereIn('tbl_asnItem.asnItem_id', $idsArr)
                        ->groupBy('tbl_asn.asn_id')
                        ->get();
                })
                ->groupBy('tbl_asn.asn_id')
                ->get();

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $schoolDet->company_id)
                ->first();
            $contactDetNew = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $school_id)
                ->first();
            $adminDet = DB::table('tbl_user')
                ->select('tbl_user.*')
                ->where('tbl_user.company_id', $schoolDet->company_id)
                ->where('tbl_user.admin_type', 1)
                ->where('tbl_user.is_delete', 0)
                ->where('tbl_user.isCurrent_status', '=', -1)
                ->get();
            foreach ($adminDet as $key => $value) {
                if ($value->user_name) {
                    $email = $value->user_name;
                    $name = $value->firstName_txt . ' ' . $value->surname_txt;

                    $mailData['companyDetail'] = $companyDetail;
                    $mailData['name'] = $name;
                    $mailData['mail'] = $email;
                    $mailData['schoolDet'] = $schoolDet;
                    $mailData['itemList'] = $itemList;
                    $mailData['rejected_text'] = $request->remark;
                    $mailData['weekStartDate'] = $weekStartDate;
                    $mailData['contactDetNew'] = $contactDetNew;
                    $mailData['date'] = date("d-m-Y H:i");
                    $myVar = new AlertController();
                    $myVar->mailAdminAfterReject($mailData);
                }
            }
        }

        if (count($idsArr) > 0) {
            $result['add'] = 'Yes';
        } else {
            $result['add'] = 'No';
        }

        return $result;
    }

    public function logSchoolTimesheetLogDirAll(Request $request)
    {
        $result['add'] = 'No';
        $school_id = $request->school_id;
        $asnId = $request->approveAsnId;
        $asnIdsArr = explode(",", $asnId);
        $weekStartDate = $request->weekStartDate;
        $weekEndDate = $request->weekEndDate;

        // $schoolLoginData = Session::get('schoolLoginData');
        // $companyDetail = array();
        // if ($schoolLoginData) {
        //     $company_id = $schoolLoginData->company_id;
        //     $companyDetail = DB::table('company')
        //         ->select('company.*')
        //         ->where('company.company_id', $company_id)
        //         ->first();
        // }

        // $schoolDet = DB::table('tbl_asn')
        //     ->select('tbl_asn.school_id', 'tbl_school.name_txt')
        //     ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
        //     ->whereIn('tbl_asn.asn_id', $asnIdsArr)
        //     ->first();
        $schoolDet = DB::table('tbl_school')
            ->where('school_id', $school_id)
            ->first();
        $companyDetail = array();
        $company_id = '';
        if ($schoolDet) {
            $company_id = $schoolDet->company_id;
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
        }

        $idsArr = DB::table('tbl_asn')
            ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->where('timesheet_id', NULL)
            ->where('status_int', 3)
            ->whereDate('asnDate_dte', '>=', $weekStartDate)
            ->whereDate('asnDate_dte', '<=', $weekEndDate)
            ->whereIn('tbl_asn.asn_id', $asnIdsArr)
            // ->where('company_id', $company_id)
            ->where('tbl_asn.school_id', $school_id)
            ->where('admin_approve', 1)
            ->where('send_to_school', 1)
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
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                ->get();

            $timesheet_id = DB::table('tbl_timesheet')
                ->insertGetId([
                    'school_id' => $schoolDet->school_id,
                    'timestamp_ts' => date('Y-m-d H:i:s'),
                    'log_by_type' => 'School',
                    'log_by' => $school_id
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
                        'timesheet_id' => $timesheet_id
                    ]);

                DB::table('teacher_timesheet_item')
                    ->where('asnItem_id', $id)
                    ->update([
                        'admin_approve' => 1,
                        'approve_by' => $school_id,
                        'approve_by_type' => 'School',
                        'approve_by_dte' => date('Y-m-d H:i:s'),
                    ]);
            }

            // send mail to admin
            $contactDetNew = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $school_id)
                ->first();

            $adminDet = DB::table('tbl_user')
                ->select('tbl_user.*')
                ->where('tbl_user.company_id', $company_id)
                ->where('tbl_user.admin_type', 1)
                ->where('tbl_user.isCurrent_status', '=', -1)
                ->get();
            foreach ($adminDet as $key => $value) {
                if ($value->user_name) {
                    $email = $value->user_name;
                    $name = $value->firstName_txt . ' ' . $value->surname_txt;

                    $mailData['companyDetail'] = $companyDetail;
                    $mailData['name'] = $name;
                    $mailData['mail'] = $email;
                    $mailData['schoolDet'] = $schoolDet;
                    $mailData['timesheet_id'] = $timesheet_id;
                    $mailData['contactDetNew'] = $contactDetNew;
                    $mailData['date'] = date("d-m-Y H:i");
                    $myVar = new AlertController();
                    $myVar->mailAdminAfterApproval($mailData);
                }
            }

            $result['add'] = 'Yes';
            $result['timesheet_id'] = $timesheet_id;
            $result['schoolName'] = $schoolDet ? $schoolDet->name_txt : '';
            return $result;
        }
        return $result;
    }
    /*********/

    /********/
    public function logSchTeacherItemSheetDirAll(Request $request, $asn_id, $school_id)
    {
        $asnId = base64_decode($asn_id);
        $schoolId = base64_decode($school_id);
        $asnIdsArr = explode(",", $asnId);

        $title = array('pageTitle' => "School Timesheet");
        $headerTitle = "Schools";

        $schoolDet = DB::table('tbl_school')
            ->select('tbl_school.*')
            ->where('school_id', $schoolId)
            ->first();
        if ($schoolDet) {
            $company_id = $schoolDet->company_id;
            $teacherList = DB::table('teacher_timesheet')
                ->join('teacher_timesheet_item', 'teacher_timesheet.teacher_timesheet_id', '=', 'teacher_timesheet_item.teacher_timesheet_id')
                ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('teacher_timesheet.*', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'teacher_timesheet_item.start_tm as t_start_tm', 'teacher_timesheet_item.end_tm as t_end_tm', 'teacher_timesheet_item.timesheet_item_id', 'teacher_timesheet_item.asn_id as t_asn_id', 'teacher_timesheet_item.asnItem_id as t_asnItem_id', 'teacher_timesheet_item.school_id as t_school_id', 'teacher_timesheet_item.teacher_id as t_teacher_id', 'teacher_timesheet_item.admin_approve as t_admin_approve', 'teacher_timesheet_item.send_to_school as t_send_to_school', 'teacher_timesheet_item.rejected_by_type as t_rejected_by_type', 'teacher_timesheet_item.rejected_by as t_rejected_by', 'teacher_timesheet_item.rejected_text as t_rejected_text')
                ->whereIn('teacher_timesheet_item.timesheet_item_id', $asnIdsArr)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('teacher_timesheet.teacher_id', 'teacher_timesheet_item.asnDate_dte')
                ->orderBy('teacher_timesheet.teacher_id', 'ASC')
                ->orderBy('teacher_timesheet_item.asnDate_dte', 'DESC')
                ->get();

            return view("web.schoolPortal.school_teacheritemsheet_dir_all", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $schoolId, 'schoolDetail' => $schoolDet, 'teacherList' => $teacherList, 'asnId' => $asnId]);
        }
    }

    public function logTeacherItemSheetApproveDir(Request $request)
    {
        $result['add'] = 'No';
        $school_id = $request->school_id;
        $asnId = $request->approveAsnId;
        $itemIdsArr = explode(",", $asnId);
        $idsArr = array();
        $companyDetail = array();

        foreach ($itemIdsArr as $key => $value) {
            $tDet = DB::table('teacher_timesheet_item')
                ->where('timesheet_item_id', $value)
                ->where('admin_approve', '!=', 1)
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
                        'approve_by' => $school_id,
                        'approve_by_type' => 'School',
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
            ->where('school_id', $school_id)
            ->first();

        if (count($idsArr) > 0 && $schoolDet) {
            $company_id = $schoolDet->company_id;
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            $itemList = DB::table('tbl_asnItem')
                ->LeftJoin('tbl_asn', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('tbl_asnItem.asnItem_id', 'tbl_asnItem.asn_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm')
                ->whereIn('tbl_asnItem.asnItem_id', $idsArr)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                ->get();

            $timesheet_id = DB::table('tbl_timesheet')
                ->insertGetId([
                    'school_id' => $schoolDet->school_id,
                    'timestamp_ts' => date('Y-m-d H:i:s'),
                    'log_by_type' => 'School',
                    'log_by' => $school_id
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
                        'timesheet_id' => $timesheet_id
                    ]);

                DB::table('teacher_timesheet_item')
                    ->where('asnItem_id', $id)
                    ->update([
                        'admin_approve' => 1,
                        'approve_by' => $school_id,
                        'approve_by_type' => 'School',
                        'approve_by_dte' => date('Y-m-d H:i:s'),
                    ]);
            }

            // send mail to admin
            $contactDetNew = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $school_id)
                ->first();

            $adminDet = DB::table('tbl_user')
                ->select('tbl_user.*')
                ->where('tbl_user.company_id', $company_id)
                ->where('tbl_user.admin_type', 1)
                ->where('tbl_user.isCurrent_status', '=', -1)
                ->get();
            foreach ($adminDet as $key => $value) {
                if ($value->user_name) {
                    $email = $value->user_name;
                    $name = $value->firstName_txt . ' ' . $value->surname_txt;

                    $mailData['companyDetail'] = $companyDetail;
                    $mailData['name'] = $name;
                    $mailData['mail'] = $email;
                    $mailData['schoolDet'] = $schoolDet;
                    $mailData['timesheet_id'] = $timesheet_id;
                    $mailData['contactDetNew'] = $contactDetNew;
                    $mailData['date'] = date("d-m-Y H:i");
                    $myVar = new AlertController();
                    $myVar->mailAdminAfterApproval($mailData);
                }
            }

            $result['add'] = 'Yes';
            $result['timesheet_id'] = $timesheet_id;
            $result['schoolName'] = $schoolDet ? $schoolDet->name_txt : '';
            return $result;
        }
        return $result;
    }

    public function logTeacherItemSheetRejectDir(Request $request)
    {
        $input = $request->all();
        $school_id = $input['school_id'];
        $asnId = $input['asnId'];
        $asnIdsArr = explode(",", $asnId);

        $tDet = DB::table('teacher_timesheet_item')
            ->whereIn('timesheet_item_id', $asnIdsArr)
            ->where('admin_approve', '=', 1)
            ->get();

        if (count($tDet) > 0) {
            $result['add'] = 'No';
        } else {
            DB::table('teacher_timesheet_item')
                ->whereIn('timesheet_item_id', $asnIdsArr)
                ->update([
                    'admin_approve' => 2,
                    'rejected_by_type' => 'School',
                    'rejected_by' => $school_id,
                    'rejected_text' => $request->remark
                ]);

            // send mail to admin
            $schoolDet = DB::table('tbl_school')
                ->where('school_id', $school_id)
                ->first();

            if (count($asnIdsArr) > 0 && $schoolDet) {
                $company_id = $schoolDet->company_id;
                $companyDetail = DB::table('company')
                    ->select('company.*')
                    ->where('company.company_id', $company_id)
                    ->first();

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

                $contactDetNew = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $school_id)
                    ->first();

                $adminDet = DB::table('tbl_user')
                    ->select('tbl_user.*')
                    ->where('tbl_user.company_id', $company_id)
                    ->where('tbl_user.admin_type', 1)
                    ->where('tbl_user.isCurrent_status', '=', -1)
                    ->get();
                foreach ($adminDet as $key => $value) {
                    if ($value->user_name) {
                        $email = $value->user_name;
                        $name = $value->firstName_txt . ' ' . $value->surname_txt;

                        $mailData['companyDetail'] = $companyDetail;
                        $mailData['name'] = $name;
                        $mailData['mail'] = $email;
                        $mailData['schoolDet'] = $schoolDet;
                        $mailData['teacherList'] = $teacherList;
                        $mailData['remark'] = $request->remark;
                        $mailData['contactDetNew'] = $contactDetNew;
                        $mailData['date'] = date("d-m-Y H:i");
                        $myVar = new AlertController();
                        $myVar->mailAdminAfterTeacherItemReject($mailData);
                    }
                }
            }

            $result['add'] = 'Yes';
        }

        return $result;
    }
    /********/

    /********/
    public function teacherTimeSheetDirAll(Request $request, $asn_id, $school_id)
    {
        $asnId = base64_decode($asn_id);
        $schoolId = base64_decode($school_id);
        $asnIdsArr = explode(",", $asnId);

        $title = array('pageTitle' => "School Timesheet");
        $headerTitle = "Schools";

        $schoolDet = DB::table('tbl_school')
            ->select('tbl_school.*')
            ->where('school_id', $schoolId)
            ->first();
        if ($schoolDet) {
            $company_id = $schoolDet->company_id;
            $teacherList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('tbl_student', 'tbl_asn.student_id', '=', 'tbl_student.student_id')
                ->select('asnItem_id', 'tbl_asn.teacher_id', 'tbl_asn.asn_id', 'tbl_asn.school_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), DB::raw("IF(tbl_asn.student_id IS NOT NULL, CONCAT(tbl_student.firstname_txt, ' ', tbl_student.surname_txt), '') AS studentName_txt"), 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm', 'tbl_asnItem.admin_approve', 'tbl_asnItem.send_to_school', 'tbl_asnItem.rejected_text')
                ->whereIn('tbl_asnItem.asnItem_id', $asnIdsArr)
                ->groupBy('tbl_asn.teacher_id', 'asnItem_id', 'asnDate_dte')
                ->orderBy('tbl_asn.teacher_id', 'ASC')
                ->orderBy('tbl_asnItem.asnDate_dte', 'DESC')
                ->get();

            return view("web.schoolPortal.teacher_timesheet_dir_all", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $schoolId, 'schoolDetail' => $schoolDet, 'teacherList' => $teacherList, 'asnId' => $asnId]);
        }
    }

    public function teacherTimeSheetApproveDir(Request $request)
    {
        $result['add'] = 'No';
        $school_id = $request->school_id;
        $asnId = $request->approveAsnId;
        $itemIdsArr = explode(",", $asnId);
        $companyDetail = array();

        DB::table('tbl_asnItem')
            ->whereIn('asnItem_id', $itemIdsArr)
            ->update([
                'admin_approve' => 1
            ]);

        $result['add'] = 'No';
        $schoolDet = DB::table('tbl_school')
            ->where('school_id', $school_id)
            ->first();

        if (count($itemIdsArr) > 0 && $schoolDet) {
            $company_id = $schoolDet->company_id;
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();
            $itemList = DB::table('tbl_asnItem')
                ->LeftJoin('tbl_asn', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('tbl_asnItem.asnItem_id', 'tbl_asnItem.asn_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"), 'tbl_asn.school_id', 'tbl_asn.teacher_id', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_asnItem.start_tm', 'tbl_asnItem.end_tm')
                ->whereIn('tbl_asnItem.asnItem_id', $itemIdsArr)
                // ->where('tbl_teacher.is_delete', 0)
                ->groupBy('tbl_asnItem.asnItem_id')
                ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                ->get();

            $timesheet_id = DB::table('tbl_timesheet')
                ->insertGetId([
                    'school_id' => $schoolDet->school_id,
                    'timestamp_ts' => date('Y-m-d H:i:s'),
                    'log_by_type' => 'School',
                    'log_by' => $school_id
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

            foreach ($itemIdsArr as $key => $id) {
                DB::table('tbl_asnItem')
                    ->where('asnItem_id', $id)
                    ->update([
                        'timesheet_id' => $timesheet_id
                    ]);

                DB::table('teacher_timesheet_item')
                    ->where('asnItem_id', $id)
                    ->update([
                        'admin_approve' => 1,
                        'approve_by' => $school_id,
                        'approve_by_type' => 'School',
                        'approve_by_dte' => date('Y-m-d H:i:s'),
                    ]);
            }

            // send mail to admin
            $contactDetNew = DB::table('tbl_schoolContact')
                ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                ->where('tbl_schoolContact.isCurrent_status', '-1')
                ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                ->where('tbl_contactItemSch.type_int', 1)
                ->where('tbl_schoolContact.school_id', $school_id)
                ->first();

            $adminDet = DB::table('tbl_user')
                ->select('tbl_user.*')
                ->where('tbl_user.company_id', $company_id)
                ->where('tbl_user.admin_type', 1)
                ->where('tbl_user.isCurrent_status', '=', -1)
                ->get();
            foreach ($adminDet as $key => $value) {
                if ($value->user_name) {
                    $email = $value->user_name;
                    $name = $value->firstName_txt . ' ' . $value->surname_txt;

                    $mailData['companyDetail'] = $companyDetail;
                    $mailData['name'] = $name;
                    $mailData['mail'] = $email;
                    $mailData['schoolDet'] = $schoolDet;
                    $mailData['timesheet_id'] = $timesheet_id;
                    $mailData['contactDetNew'] = $contactDetNew;
                    $mailData['date'] = date("d-m-Y H:i");
                    $myVar = new AlertController();
                    $myVar->mailAdminAfterApproval($mailData);
                }
            }

            $result['add'] = 'Yes';
            $result['timesheet_id'] = $timesheet_id;
            $result['schoolName'] = $schoolDet ? $schoolDet->name_txt : '';
            return $result;
        }
        return $result;
    }

    public function teacherTimeSheetRejectDir(Request $request)
    {
        $input = $request->all();
        $school_id = $input['school_id'];
        $asnId = $input['asnId'];
        $asnIdsArr = explode(",", $asnId);

        $tDet = DB::table('tbl_asnItem')
            ->whereIn('asnItem_id', $asnIdsArr)
            ->where('admin_approve', '=', 1)
            ->get();

        if (count($tDet) > 0) {
            $result['add'] = 'No';
        } else {
            DB::table('tbl_asnItem')
                ->whereIn('asnItem_id', $asnIdsArr)
                ->update([
                    'send_to_school' => 0,
                    'admin_approve' => 2,
                    'rejected_by_type' => 'School',
                    'rejected_by' => $school_id,
                    'rejected_text' => $request->remark
                ]);

            // send mail to admin
            $schoolDet = DB::table('tbl_school')
                ->where('school_id', $school_id)
                ->first();

            if (count($asnIdsArr) > 0 && $schoolDet) {
                $company_id = $schoolDet->company_id;
                $companyDetail = DB::table('company')
                    ->select('company.*')
                    ->where('company.company_id', $company_id)
                    ->first();

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

                $contactDetNew = DB::table('tbl_schoolContact')
                    ->LeftJoin('tbl_contactItemSch', 'tbl_schoolContact.contact_id', '=', 'tbl_contactItemSch.schoolContact_id')
                    ->select('tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_contactItemSch.contactItem_txt')
                    ->where('tbl_schoolContact.isCurrent_status', '-1')
                    ->where('tbl_schoolContact.receiveTimesheets_status', '-1')
                    // ->where('tbl_contactItemSch.receiveInvoices_status', '-1')
                    ->where('tbl_contactItemSch.type_int', 1)
                    ->where('tbl_schoolContact.school_id', $school_id)
                    ->first();

                $adminDet = DB::table('tbl_user')
                    ->select('tbl_user.*')
                    ->where('tbl_user.company_id', $company_id)
                    ->where('tbl_user.admin_type', 1)
                    ->where('tbl_user.isCurrent_status', '=', -1)
                    ->get();
                foreach ($adminDet as $key => $value) {
                    if ($value->user_name) {
                        $email = $value->user_name;
                        $name = $value->firstName_txt . ' ' . $value->surname_txt;

                        $mailData['companyDetail'] = $companyDetail;
                        $mailData['name'] = $name;
                        $mailData['mail'] = $email;
                        $mailData['schoolDet'] = $schoolDet;
                        $mailData['teacherList'] = $teacherList;
                        $mailData['remark'] = $request->remark;
                        $mailData['contactDetNew'] = $contactDetNew;
                        $mailData['date'] = date("d-m-Y H:i");
                        $myVar = new AlertController();
                        $myVar->mailAdminAfterItemReject($mailData);
                    }
                }
            }

            $result['add'] = 'Yes';
        }

        return $result;
    }
    /********/

    public function logSchoolInvoicePayMethod(Request $request)
    {
        $input = $request->all();
        $editInvoiceId = $input['editInvoiceId'];

        $invoiceDetail = DB::table('tbl_invoice')
            ->where('invoice_id', "=", $editInvoiceId)
            ->first();

        $paymentMethodList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 42)
            ->get();

        $view = view("web.schoolPortal.invoice_pay_method", ['invoiceDetail' => $invoiceDetail, 'paymentMethodList' => $paymentMethodList])->render();
        return response()->json(['html' => $view]);
    }

    public function logSchoolInvoicePayMethodEdit(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        if ($schoolLoginData) {
            $company_id = $schoolLoginData->company_id;
            $school_id = $schoolLoginData->school_id;

            DB::table('tbl_invoice')
                ->where('invoice_id', '=', $request->invoice_id)
                ->update([
                    'school_paid_dte' => date("Y-m-d", strtotime(str_replace('/', '-', $request->school_paid_dte))),
                    'school_paid_method' => $request->school_paid_method,
                    'school_paid_by' => $school_id
                ]);
            return redirect()->back()->with('success', "Record updated successfully.");
        } else {
            return redirect()->intended('/school');
        }
    }

    /******* common login *******/
    public function schoolCommonLogin(Request $request)
    {
        $schoolLoginData = Session::get('schoolLoginData');
        $commonLoginSchoolData = Session::get('commonLoginSchoolData');
        if ($schoolLoginData && $commonLoginSchoolData) {
            return redirect()->intended('/school/detail');
        } else {
            $title = array('pageTitle' => "School Login");
            return view("web.schoolPortal.school_common_login", ['title' => $title]);
        }
    }

    public function schoolProcessCommonLogin(Request $request)
    {
        $validator = Validator::make(
            array(
                'selected_school'    => $request->selected_school,
                'user_name'    => $request->user_name,
                'password' => $request->password
            ),
            array(
                'selected_school'    => 'required',
                'user_name'    => 'required',
                'password' => 'required',
            )
        );
        //check validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (Auth::guard('subadmin')->attempt(['user_name' => $request->user_name, 'password' => $request->password, 'admin_type' => 2], $request->get('remember'))) {
                $admin = Auth::guard('subadmin')->user();

                if ($admin) {
                    $administrators = DB::table('tbl_user')
                        ->LeftJoin('company', 'company.company_id', '=', 'tbl_user.company_id')
                        ->select('tbl_user.*', 'company.company_name', 'company.company_logo')
                        ->where('tbl_user.user_id', $admin->user_id)
                        ->get();

                    $user_exist = DB::table('tbl_school')
                        ->LeftJoin('company', 'company.company_id', '=', 'tbl_school.company_id')
                        ->select('tbl_school.*', 'company.company_name', 'company.company_logo')
                        ->where('tbl_school.school_id', $request->selected_school)
                        ->get();

                    if (count($user_exist) > 0) {
                        // if ($user_exist[0]->activeStatus != 1) {
                        //     return redirect()->back()->withInput()->with('loginError', "This is not a active school.");
                        // } else {
                        Session::put('commonLoginSchoolData', $administrators[0]);
                        Session::put('schoolLoginData', $user_exist[0]);
                        return redirect()->intended('/school/detail');
                        // }
                    } else {
                        return redirect()->back()->withInput()->with('loginError', "This school is not in records.");
                    }
                } else {
                    return back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Username or password is incorrect");
                }
            } else {
                return back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Username or password is incorrect");
            }
        }
    }

    public function fetchSchoolAjax(Request $request)
    {
        $querySch = $request->get('q');

        $schoolQry = DB::table('tbl_school')
            ->LeftJoin('company', 'company.company_id', '=', 'tbl_school.company_id')
            ->select('tbl_school.*', 'company.company_name', 'company.company_logo');
        if ($querySch) {
            $search_input = str_replace(" ", "", $querySch);
            $schoolQry->where(function ($query) use ($search_input) {
                $query->where(DB::raw("REPLACE(name_txt, ' ', '')"), 'LIKE', "%" . $search_input . "%");
            });
        }
        $data = $schoolQry->limit(15)
            ->get();

        return response()->json($data);
    }

    public function commonSchoolLogout()
    {
        Session::forget('commonLoginSchoolData');
        Session::forget('schoolLoginData');
        return redirect('/school/supervisor');
    }
    /******* common login *******/

    /********* School Portal *********/

    public function testSchoolFileUpload(Request $request)
    {
        $user_id = '1002';
        $school_id = '124423';

        $fPath = '';
        $fType = '';
        $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'txt');
        if ($image = $request->file('file')) {
            $extension = $image->getClientOriginalExtension();
            $file_name = $image->getClientOriginalName();
            if (in_array(strtolower($extension), $allowed_types)) {
                $rand = mt_rand(100000, 999999);
                $name = time() . "_" . $rand . "_" . $file_name;
                $image->move(public_path('images/school'), $name);
                $fPath = 'images/school/' . $name;
                $fType = $extension;
            } else {
                return redirect('/school-document/' . $school_id)->with('error', "Please upload valid file.");
            }
        } else {
            return redirect('/school-document/' . $school_id)->with('error', "Please upload valid file.");
        }

        DB::table('tbl_schooldocument')
            ->insert([
                'school_id' => $school_id,
                'file_location' => $fPath,
                'file_name' => $request->file_name ? $request->file_name : $request->file_name_hidden,
                'documentType' => $request->documentType,
                'othersText' => $request->othersText,
                'file_type' => $fType,
                'uploadOn_dtm' => date('Y-m-d H:i:s'),
                'loggedBy_id' => $user_id,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        return "Document added successfully.";
    }
}
