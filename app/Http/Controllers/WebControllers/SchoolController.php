<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
            DB::table('tbl_school')
                ->insert([
                    'company_id' => $company_id,
                    'name_txt' => $request->name_txt,
                    'address1_txt' => $request->address1_txt,
                    'address2_txt' => $request->address2_txt,
                    'address3_txt' => $request->address3_txt,
                    'address4_txt' => $request->address4_txt,
                    'postcode_txt' => $request->postcode_txt,
                    'lat_txt' => $lat_txt,
                    'lon_txt' => $lon_txt,
                    'la_id' => $request->la_id,
                    'ageRange_int' => $request->ageRange_int,
                    'type_int' => $request->type_int,
                    'religion_int' => $request->religion_int,
                    'website_txt' => $request->website_txt,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect('/schools')->with('success', "School added successfully.");
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
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp')
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
                ->select('tbl_contactItemSch.*', 'JobRole.description_txt as jobRole_txt', 'ContactType.description_txt as type_txt', 'tbl_schoolContact.title_int', 'tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_schoolContact.jobRole_int', 'tbl_schoolContact.receiveTimesheets_status', 'tbl_schoolContact.receiveVetting_status', 'tbl_schoolContact.isCurrent_status')
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

            return view("web.school.school_detail", ['title' => $title, 'headerTitle' => $headerTitle, 'schoolDetail' => $schoolDetail, 'schoolContacts' => $schoolContacts, 'contactItems' => $contactItems, 'school_id' => $id, 'titleList' => $titleList, 'jobRoleList' => $jobRoleList, 'contactMethodList' => $contactMethodList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function schoolAddressUpdate(Request $request)
    {
        $school_id = $request->school_id;
        DB::table('tbl_school')->where('school_id', '=', $school_id)
            ->update([
                'address1_txt' =>    $request->address1_txt,
                'address2_txt' =>    $request->address2_txt,
                'address3_txt' =>    $request->address3_txt,
                'address4_txt' =>    $request->address4_txt,
                'postcode_txt' =>    $request->postcode_txt,
                'baseRate_dec' =>    $request->baseRate_dec,
                'website_txt' =>    $request->website_txt
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

        return redirect('/school-detail/' . $school_id)->with('success', "Contact added successfully.");
    }

    public function getSchoolContactDetail(Request $request)
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

        $view = view("web.school.contact_edit_view", ['contactDetail' => $contactDetail, 'titleList' => $titleList, 'jobRoleList' => $jobRoleList])->render();
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

        return redirect('/school-detail/' . $school_id)->with('success', "Contact updated successfully.");
    }

    public function schoolContactDelete(Request $request)
    {
        $contact_id = $request->contact_id;
        DB::table('tbl_schoolContact')->where('contact_id', '=', $contact_id)
            ->delete();

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
            ->select('tbl_contactItemSch.*', 'JobRole.description_txt as jobRole_txt', 'ContactType.description_txt as type_txt', 'tbl_schoolContact.title_int', 'tbl_schoolContact.firstName_txt', 'tbl_schoolContact.surname_txt', 'tbl_schoolContact.jobRole_int', 'tbl_schoolContact.receiveTimesheets_status', 'tbl_schoolContact.receiveVetting_status', 'tbl_schoolContact.isCurrent_status')
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
        DB::table('tbl_contactItemSch')
            ->where('contactItemSch_id', '=', $contactItemSch_id)
            ->delete();

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
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp')
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

            return view("web.school.school_contact", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'ContactHistory' => $ContactHistory, 'schoolContacts' => $schoolContacts, 'quickSettingList' => $quickSettingList, 'methodList' => $methodList, 'reasonList' => $reasonList, 'outcomeList' => $outcomeList]);
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
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                // ->take(1)
                ->first();

            $assignment = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_student', 'tbl_student.student_id', '=', 'tbl_asn.student_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
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
                ->select('tbl_asn.*', 'yearGroupType.description_txt as yearGroupTxt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'assType.description_txt as assignmentType', 'subjectType.description_txt as subjectTxt', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), 'teacherProff.description_txt as teacherProfession', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', DB::raw('MIN(asnDate_dte) AS firstDate_dte'), 'tbl_student.firstName_txt as studentfirstName', 'tbl_student.surname_txt as studentsurname_txt')
                ->where('tbl_asn.school_id', $id);
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

            return view("web.school.school_assignment", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'assignmentList' => $assignmentList, 'statusList' => $statusList, 'completeCount' => $completeCount]);
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
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp')
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
                ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.school_id', $id);
            if ($request->include != 1 && $request->method) {
                $Invoices->where('tbl_invoice.paymentMethod_int', $request->method);
            }
            $schoolInvoices = $Invoices->groupBy('tbl_invoice.invoice_id')
                ->get();

            $schoolTimesheet = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->select('tbl_asn.*', DB::raw('COUNT(asnItem_id) AS items_int'), 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt')
                ->where('tbl_asn.school_id', $id)
                ->whereDate('tbl_asnItem.asnDate_dte', '<', date('Y-m-d'))
                ->where('tbl_asn.status_int', 3)
                ->where('timesheet_id', null)
                ->groupBy('tbl_asn.teacher_id')
                ->orderBy(DB::raw('COUNT(asnItem_id)'), 'DESC')
                ->get();

            $paymentMethodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 42)
                ->get();

            return view("web.school.school_finance", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'schoolTimesheet' => $schoolTimesheet, 'paymentMethodList' => $paymentMethodList]);
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
                'paymentLoggedBy_id' => $user_id,
                'sentOn_dte' => date('Y-m-d'),
                'sentBy_int' => $user_id,
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
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp')
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

            return view("web.school.school_invoice_edit", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'invoice_id' => $invoice_id, 'include' => $include, 'method' => $method, 'schoolDetail' => $schoolDetail, 'paymentMethodList' => $paymentMethodList, 'invoiceDetail' => $invoiceDetail, 'invoiceItemList' => $invoiceItemList]);
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
                'dateFor_dte' => date("Y-m-d", strtotime($request->dateFor_dte)),
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
                'dateFor_dte' => date("Y-m-d", strtotime($request->dateFor_dte)),
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
            $editData['paymentLoggedBy_id'] = $webUserLoginData->user_id;
            $editData['sentBy_int'] = $webUserLoginData->user_id;
        }
        if ($request->factored_status) {
            $editData['factored_status'] = -1;
        }
        if ($request->creditNote_status) {
            $editData['creditNote_status'] = -1;
        }
        if ($request->invoiceDate_dte != 0) {
            $editData['invoiceDate_dte'] = date("Y-m-d", strtotime($request->invoiceDate_dte));
        }
        if ($request->paidOn_dte != 0) {
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
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp')
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

            return view("web.school.school_teacher", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'teacherList' => $teacherList, 'tStatus' => $tStatus]);
        } else {
            return redirect()->intended('/');
        }
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
                ->select('tbl_school.*', 'AgeRange.description_txt as ageRange_txt', 'religion.description_txt as religion_txt', 'SchoolType.description_txt as type_txt', 'tbl_localAuthority.laName_txt', 'contactUser.firstName_txt', 'contactUser.surname_txt', 'tbl_schoolContactLog.schoolContactLog_id', 'tbl_schoolContactLog.spokeTo_id', 'tbl_schoolContactLog.spokeTo_txt', 'tbl_schoolContactLog.contactAbout_int', 'tbl_schoolContactLog.contactOn_dtm', 'tbl_schoolContactLog.contactBy_id', 'tbl_schoolContactLog.notes_txt', 'tbl_schoolContactLog.method_int', 'tbl_schoolContactLog.outcome_int', 'tbl_schoolContactLog.callbackOn_dtm', 'tbl_schoolContactLog.timestamp_ts as contactTimestamp')
                ->where('tbl_school.school_id', $id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                ->first();

            $documentList = DB::table('tbl_schooldocument')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_schooldocument.school_id')
                ->select('tbl_schooldocument.*', 'tbl_school.name_txt')
                ->where('tbl_schooldocument.school_id', $id)
                ->orderBy('tbl_schooldocument.uploadOn_dtm', 'DESC')
                ->get();

            return view("web.school.school_document", ['title' => $title, 'headerTitle' => $headerTitle, 'school_id' => $id, 'schoolDetail' => $schoolDetail, 'documentList' => $documentList]);
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
            $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');
            if ($image = $request->file('file')) {
                $extension = $image->extension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "_" . $file_name;
                    $image->move('images/school', $name);
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
                    'file_name' => $request->file_name,
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

        $view = view("web.school.document_edit_view", ['docDetail' => $docDetail])->render();
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

            $fPath = '';
            $fType = '';
            $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');
            if ($image = $request->file('file')) {
                $extension = $image->extension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "_" . $file_name;
                    $image->move('images/school', $name);
                    $fPath = 'images/school/' . $name;
                    $fType = $extension;
                    if (file_exists($file_location)) {
                        unlink($file_location);
                    }
                } else {
                    return redirect('/school-document/' . $school_id)->with('error', "Please upload valid file.");
                }
            } else {
                return redirect('/school-document/' . $school_id)->with('error', "Please upload valid file.");
            }

            DB::table('tbl_schooldocument')
                ->where('schoolDocument_id', '=', $editDocumentId)
                ->update([
                    'file_location' => $fPath,
                    'file_name' => $request->file_name,
                    'file_type' => $fType,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

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
}
