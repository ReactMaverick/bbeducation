<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

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
                ->where('tbl_teacher.company_id', $company_id)
                ->get();
            // dd($fabTeacherList);
            $titleList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 1)
                ->get();

            $nationalityList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 8)
                ->orderBy('tbl_description.description_txt', 'ASC')
                ->get();

            $candidateList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 7)
                ->get();

            $specialismList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 5)
                ->get();

            return view("web.teacher.index", ['title' => $title, 'headerTitle' => $headerTitle, 'fabTeacherList' => $fabTeacherList, 'titleList' => $titleList, 'nationalityList' => $nationalityList, 'candidateList' => $candidateList, 'specialismList' => $specialismList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function newTeacherInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $lat_txt = 0;
            if ($request->lat_txt) {
                $lat_txt = $request->lat_txt;
            }
            $lon_txt = 0;
            if ($request->lon_txt) {
                $lon_txt = $request->lon_txt;
            }
            $NQTRequired_status = 0;
            if ($request->NQTRequired_status) {
                $NQTRequired_status = -1;
            }
            $NQTCompleted_dte = NULL;
            if ($request->NQTCompleted_dte != '') {
                $NQTCompleted_dte = date("Y-m-d", strtotime($request->NQTCompleted_dte));
            }

            DB::table('tbl_teacher')
                ->insert([
                    'company_id' => $company_id,
                    'title_int' => $request->title_int,
                    'firstName_txt' => $request->firstName_txt,
                    'surname_txt' => $request->surname_txt,
                    'knownAs_txt' => $request->knownAs_txt,
                    'maidenPreviousNames_txt' => $request->maidenPreviousNames_txt,
                    'middleNames_txt' => $request->middleNames_txt,
                    'address1_txt' => $request->address1_txt,
                    'address2_txt' => $request->address2_txt,
                    'address3_txt' => $request->address3_txt,
                    'address4_txt' => $request->address4_txt,
                    'postcode_txt' => $request->postcode_txt,
                    'nationality_int' => $request->nationality_int,
                    'DOB_dte' => date("Y-m-d", strtotime($request->DOB_dte)),
                    'professionalType_int' => $request->professionalType_int,
                    'ageRangeSpecialism_int' => $request->ageRangeSpecialism_int,
                    'NQTRequired_status' => $NQTRequired_status,
                    'NQTCompleted_dte' => $NQTCompleted_dte,
                    'lat_txt' => $lat_txt,
                    'lon_txt' => $lon_txt,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Teacher added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherSearch(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Search");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $ageRangeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 5)
                ->get();

            $genderList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 41)
                ->get();

            $professionList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 7)
                ->get();

            $applicationList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->get();

            $teacherList = array();
            $srchCnt = 0;
            if ($request->search) {
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
                    ->where('tbl_teacher.isCurrent_status', '<>', 0);

                if ($request->search_input) {
                    $srchCnt = 1;
                    $search_input = str_replace(" ", "", $request->search_input);
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

                if ($request->ageRangeId) {
                    $srchCnt = 1;
                    $teacherQry->where('tbl_teacher.ageRangeSpecialism_int', $request->ageRangeId);
                }

                if ($request->gender) {
                    $srchCnt = 1;
                    // $teacherQry->where('tbl_teacher.ageRangeSpecialism_int', $request->gender);
                }

                if ($request->profession) {
                    $srchCnt = 1;
                    $teacherQry->where('tbl_teacher.professionalType_int', $request->profession);
                }

                if ($request->application) {
                    $srchCnt = 1;
                    $teacherQry->where('tbl_teacher.applicationStatus_int', $request->application);
                }

                if ($request->lastContactRadio && $request->lasContactDate) {
                    if ($request->lastContactRadio == 'Before') {
                        $srchCnt = 1;
                        $teacherQry->whereDate('tbl_teacherContactLog.contactOn_dtm', '<', $request->lasContactDate);
                    }
                    if ($request->lastContactRadio == 'After') {
                        $srchCnt = 1;
                        $teacherQry->whereDate('tbl_teacherContactLog.contactOn_dtm', '>', $request->lasContactDate);
                    }
                }

                if ($request->daysWorked && $request->worked_day) {
                    if ($request->daysWorked == 'More') {
                        $srchCnt = 1;
                        $teacherQry->where(DB::raw("(SELECT SUM(dayPercent_dec) FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 AND tbl_asn.teacher_id = tbl_teacher.teacher_id GROUP BY tbl_asn.teacher_id)"), '>', $request->worked_day);
                    }
                    if ($request->daysWorked == 'Less') {
                        $srchCnt = 1;
                        $teacherQry->where(DB::raw("(SELECT SUM(dayPercent_dec) FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 AND tbl_asn.teacher_id = tbl_teacher.teacher_id GROUP BY tbl_asn.teacher_id)"), '<', $request->worked_day);
                    }
                }

                if ($request->date_from) {
                    $srchCnt = 1;
                    $teacherQry->whereDate('tbl_teacher.timestamp_ts', '>=', $request->date_from);
                }

                if ($request->date_to) {
                    $srchCnt = 1;
                    $teacherQry->whereDate('tbl_teacher.timestamp_ts', '<=', $request->date_to);
                }

                if ($srchCnt != 1) {
                    $teacherQry->groupBy('tbl_teacher.teacher_id')
                        ->limit(50);
                } else {
                    $teacherQry->groupBy('tbl_teacher.teacher_id');
                }

                $teacherList = $teacherQry->get();
            }

            return view("web.teacher.teacher_search", ['title' => $title, 'headerTitle' => $headerTitle, 'ageRangeList' => $ageRangeList, 'genderList' => $genderList, 'professionList' => $professionList, 'applicationList' => $applicationList, 'teacherList' => $teacherList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherPendingReference(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Reference");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.teacher.teacher_pending_reference", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherCalendar(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Calendar");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.teacher.teacher_calendar", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherDetail(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Detail");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $teacherDetail = DB::table('tbl_teacher')
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
                ->LeftJoin('tbl_description as nationalityTbl', function ($join) {
                    $join->on('nationalityTbl.description_int', '=', 'tbl_teacher.nationality_int')
                        ->where(function ($query) {
                            $query->where('nationalityTbl.descriptionGroup_int', '=', 8);
                        });
                })
                ->LeftJoin('tbl_description as emergencyContactRelation', function ($join) {
                    $join->on('emergencyContactRelation.description_int', '=', 'tbl_teacher.emergencyContactRelation_int')
                        ->where(function ($query) {
                            $query->where('emergencyContactRelation.descriptionGroup_int', '=', 10);
                        });
                })
                ->LeftJoin('tbl_description as bankTbl', function ($join) {
                    $join->on('bankTbl.description_int', '=', 'tbl_teacher.bank_int')
                        ->where(function ($query) {
                            $query->where('bankTbl.descriptionGroup_int', '=', 36);
                        });
                })
                ->LeftJoin('tbl_description as interviewQuality', function ($join) {
                    $join->on('interviewQuality.description_int', '=', 'tbl_teacher.interviewQuality_int')
                        ->where(function ($query) {
                            $query->where('interviewQuality.descriptionGroup_int', '=', 22);
                        });
                })
                ->LeftJoin('tbl_description as interviewLanguageSkills', function ($join) {
                    $join->on('interviewLanguageSkills.description_int', '=', 'tbl_teacher.interviewLanguageSkills_int')
                        ->where(function ($query) {
                            $query->where('interviewLanguageSkills.descriptionGroup_int', '=', 23);
                        });
                })
                ->LeftJoin('tbl_description as rightToWork', function ($join) {
                    $join->on('rightToWork.description_int', '=', 'tbl_teacher.rightToWork_int')
                        ->where(function ($query) {
                            $query->where('rightToWork.descriptionGroup_int', '=', 39);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $contactItemList = DB::table('tbl_contactItemTch')
                ->LeftJoin('tbl_description', function ($join) {
                    $join->on('tbl_description.description_int', '=', 'tbl_contactItemTch.type_int')
                        ->where(function ($query) {
                            $query->where('tbl_description.descriptionGroup_int', '=', 9);
                        });
                })
                ->select('tbl_contactItemTch.*', 'tbl_description.description_txt as type_txt')
                ->where('tbl_contactItemTch.teacher_id', $id)
                ->orderBy('tbl_contactItemTch.type_int')
                ->get();

            $titleList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 1)
                ->get();

            $nationalityList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 8)
                ->orderBy('tbl_description.description_txt', 'ASC')
                ->get();

            $ralationshipList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 10)
                ->get();

            $contactTypeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 9)
                ->get();

            return view("web.teacher.teacher_detail", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'contactItemList' => $contactItemList, 'titleList' => $titleList, 'nationalityList' => $nationalityList, 'ralationshipList' => $ralationshipList, 'contactTypeList' => $contactTypeList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherDetailUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;

            $validator = Validator::make($request->all(), [
                'firstName_txt' => 'required',
                'surname_txt' => 'required',
                'DOB_dte' => 'required',
                'nationality_int' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'title_int' => $request->title_int,
                    'firstName_txt' => $request->firstName_txt,
                    'surname_txt' => $request->surname_txt,
                    'knownAs_txt' => $request->knownAs_txt,
                    'maidenPreviousNames_txt' => $request->maidenPreviousNames_txt,
                    'middleNames_txt' => $request->middleNames_txt,
                    'nationality_int' => $request->nationality_int,
                    'DOB_dte' => date("Y-m-d", strtotime($request->DOB_dte))
                ]);

            return redirect()->back()->with('success', "Details updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherAddressUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;

            $validator = Validator::make($request->all(), [
                'postcode_txt' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'address1_txt' => $request->address1_txt,
                    'address2_txt' => $request->address2_txt,
                    'address3_txt' => $request->address3_txt,
                    'address4_txt' => $request->address4_txt,
                    'postcode_txt' => $request->postcode_txt
                ]);

            return redirect()->back()->with('success', "Address updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherEmergencyContactUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'emergencyContactName_txt' => $request->emergencyContactName_txt,
                    'emergencyContactNum1_txt' => $request->emergencyContactNum1_txt,
                    'emergencyContactNum2_txt' => $request->emergencyContactNum2_txt,
                    'emergencyContactRelation_int' => $request->emergencyContactRelation_int
                ]);

            return redirect()->back()->with('success', "Emergency contact updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherContactItemInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;

            $validator = Validator::make($request->all(), [
                'type_int' => 'required',
                'contactItem_txt' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }

            DB::table('tbl_contactItemTch')
                ->insert([
                    'teacher_id' => $teacher_id,
                    'type_int' => $request->type_int,
                    'contactItem_txt' => $request->contactItem_txt,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Contact item added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherContactItemEdit(Request $request)
    {
        $input = $request->all();
        $teacherContactItemId = $input['teacherContactItemId'];

        $Detail = DB::table('tbl_contactItemTch')
            ->where('contactItemTch_id', "=", $teacherContactItemId)
            ->first();
        $contactTypeList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 9)
            ->get();

        $view = view("web.teacher.edit_contact_item_view", ['Detail' => $Detail, 'contactTypeList' => $contactTypeList])->render();
        return response()->json(['html' => $view]);
    }

    public function teacherContactItemUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $contactItemTch_id = $request->contactItemTch_id;

            $validator = Validator::make($request->all(), [
                'type_int' => 'required',
                'contactItem_txt' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }

            DB::table('tbl_contactItemTch')
                ->where('contactItemTch_id', $contactItemTch_id)
                ->update([
                    'type_int' => $request->type_int,
                    'contactItem_txt' => $request->contactItem_txt
                ]);

            return redirect()->back()->with('success', "Contact item updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherProfession(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Profession");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $teacherDetail = DB::table('tbl_teacher')
                ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                ->LeftJoin('tbl_user as interviewer', 'interviewer.user_id', '=', 'tbl_teacher.interviewBy_id')
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
                ->LeftJoin('tbl_description as nationalityTbl', function ($join) {
                    $join->on('nationalityTbl.description_int', '=', 'tbl_teacher.nationality_int')
                        ->where(function ($query) {
                            $query->where('nationalityTbl.descriptionGroup_int', '=', 8);
                        });
                })
                ->LeftJoin('tbl_description as emergencyContactRelation', function ($join) {
                    $join->on('emergencyContactRelation.description_int', '=', 'tbl_teacher.emergencyContactRelation_int')
                        ->where(function ($query) {
                            $query->where('emergencyContactRelation.descriptionGroup_int', '=', 10);
                        });
                })
                ->LeftJoin('tbl_description as bankTbl', function ($join) {
                    $join->on('bankTbl.description_int', '=', 'tbl_teacher.bank_int')
                        ->where(function ($query) {
                            $query->where('bankTbl.descriptionGroup_int', '=', 36);
                        });
                })
                ->LeftJoin('tbl_description as interviewQuality', function ($join) {
                    $join->on('interviewQuality.description_int', '=', 'tbl_teacher.interviewQuality_int')
                        ->where(function ($query) {
                            $query->where('interviewQuality.descriptionGroup_int', '=', 22);
                        });
                })
                ->LeftJoin('tbl_description as interviewLanguageSkills', function ($join) {
                    $join->on('interviewLanguageSkills.description_int', '=', 'tbl_teacher.interviewLanguageSkills_int')
                        ->where(function ($query) {
                            $query->where('interviewLanguageSkills.descriptionGroup_int', '=', 23);
                        });
                })
                ->LeftJoin('tbl_description as rightToWork', function ($join) {
                    $join->on('rightToWork.description_int', '=', 'tbl_teacher.rightToWork_int')
                        ->where(function ($query) {
                            $query->where('rightToWork.descriptionGroup_int', '=', 39);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'interviewer.firstName_txt as int_firstName_txt', 'interviewer.surname_txt as int_surname_txt')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $teacherSubjects = DB::table('tbl_teacherSubject')
                ->LeftJoin('tbl_description as subject', function ($join) {
                    $join->on('subject.description_int', '=', 'tbl_teacherSubject.subject_id')
                        ->where(function ($query) {
                            $query->where('subject.descriptionGroup_int', '=', 6);
                        });
                })
                ->select('tbl_teacherSubject.*', 'subject.description_txt as subject_txt')
                ->where('tbl_teacherSubject.teacher_id', $id)
                ->orderBy('tbl_teacherSubject.isMain_status', 'ASC')
                ->orderBy('subject_txt', 'ASC')
                ->get();

            $teacherQualifications = DB::table('tbl_teacherQualification')
                ->LeftJoin('tbl_description as subjectType', function ($join) {
                    $join->on('subjectType.description_int', '=', 'tbl_teacherQualification.subType_int')
                        ->where(function ($query) {
                            $query->where('subjectType.descriptionGroup_int', '=', 15);
                        });
                })
                ->select('tbl_teacherQualification.*', 'subjectType.description_txt as subType_txt')
                ->where('tbl_teacherQualification.teacher_id', $id)
                ->orderBy('tbl_teacherQualification.givesQTS_status', 'ASC')
                ->orderBy('tbl_teacherQualification.type_int', 'ASC')
                ->orderBy('tbl_teacherQualification.qualified_dte', 'ASC')
                ->get();

            $candidateList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 7)
                ->get();

            $agerangeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 5)
                ->get();

            $interviewQualityList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 22)
                ->get();

            $languageSkillList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 23)
                ->get();

            $subjectList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 6)
                ->get();

            $typeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 14)
                ->get();

            $subTypeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 15)
                ->get();

            return view("web.teacher.teacher_profession", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'teacherSubjects' => $teacherSubjects, 'teacherQualifications' => $teacherQualifications, 'candidateList' => $candidateList, 'agerangeList' => $agerangeList, 'interviewQualityList' => $interviewQualityList, 'languageSkillList' => $languageSkillList, 'subjectList' => $subjectList, 'typeList' => $typeList, 'subTypeList' => $subTypeList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherProfessionUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $NQTRequired_status = 0;
            if ($request->NQTRequired_status) {
                $NQTRequired_status = -1;
            }
            $NQTCompleted_dte = NULL;
            if ($request->NQTCompleted_dte != '') {
                $NQTCompleted_dte = date("Y-m-d", strtotime($request->NQTCompleted_dte));
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'professionalType_int' => $request->professionalType_int,
                    'ageRangeSpecialism_int' => $request->ageRangeSpecialism_int,
                    'NQTRequired_status' => $NQTRequired_status,
                    'NQTCompleted_dte' => $NQTCompleted_dte,
                    'profTRN_txt' => $request->profTRN_txt
                ]);

            return redirect()->back()->with('success', "Professional details updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherInterviewUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $interviewCompletedOn_dtm = NULL;
            if ($request->interviewCompletedOn_dtm != '') {
                $interviewCompletedOn_dtm = date("Y-m-d H:i:s", strtotime($request->interviewCompletedOn_dtm));
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'interviewQuality_int' => $request->interviewQuality_int,
                    'interviewLanguageSkills_int' => $request->interviewLanguageSkills_int,
                    'interviewCompletedOn_dtm' => $interviewCompletedOn_dtm,
                    'interviewNotes_txt' => $request->interviewNotes_txt,
                    'interviewBy_id' => $user_id
                ]);

            return redirect()->back()->with('success', "Interview details updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teachingSubjectInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;

            $validator = Validator::make($request->all(), [
                'subject_id' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }
            $isMain_status = 0;
            if ($request->isMain_status) {
                $isMain_status = -1;
            }

            DB::table('tbl_teacherSubject')
                ->insert([
                    'teacher_id' => $teacher_id,
                    'subject_id' => $request->subject_id,
                    'isMain_status' => $isMain_status,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Teaching subject added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teachingSubjectEdit(Request $request)
    {
        $input = $request->all();
        $teacherSubjectId = $input['teacherSubjectId'];

        $Detail = DB::table('tbl_teacherSubject')
            ->where('teacherSubject_id', "=", $teacherSubjectId)
            ->first();
        $subjectList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 6)
            ->get();

        $view = view("web.teacher.edit_teacher_subject_view", ['Detail' => $Detail, 'subjectList' => $subjectList])->render();
        return response()->json(['html' => $view]);
    }

    public function teachingSubjectUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $teacherSubject_id = $request->teacherSubjectIdEdit;

            $validator = Validator::make($request->all(), [
                'subject_id' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }
            $isMain_status = 0;
            if ($request->isMain_status) {
                $isMain_status = -1;
            }

            DB::table('tbl_teacherSubject')
                ->where('teacherSubject_id', $teacherSubject_id)
                ->update([
                    'subject_id' => $request->subject_id,
                    'isMain_status' => $isMain_status,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Teaching subject updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherQualificationInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;

            $validator = Validator::make($request->all(), [
                'type_int' => 'required',
                'subType_int' => 'required',
                'title_txt' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }
            $givesQTS_status = 0;
            if ($request->givesQTS_status) {
                $givesQTS_status = -1;
            }
            $qualified_dte = NULL;
            if ($request->qualified_dte != '') {
                $qualified_dte = date("Y-m-d", strtotime($request->qualified_dte));
            }

            DB::table('tbl_teacherQualification')
                ->insert([
                    'teacher_id' => $teacher_id,
                    'type_int' => $request->type_int,
                    'subType_int' => $request->subType_int,
                    'title_txt' => $request->title_txt,
                    'givesQTS_status' => $givesQTS_status,
                    'awardingBody_txt' => $request->awardingBody_txt,
                    'qualified_dte' => $qualified_dte,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Qualification added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherQualificationEdit(Request $request)
    {
        $input = $request->all();
        $teacherQualificationId = $input['teacherQualificationId'];

        $Detail = DB::table('tbl_teacherQualification')
            ->where('qualification_id', "=", $teacherQualificationId)
            ->first();
        $typeList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 14)
            ->get();

        $subTypeList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 15)
            ->get();

        $view = view("web.teacher.edit_teacher_qualification_view", ['Detail' => $Detail, 'typeList' => $typeList, 'subTypeList' => $subTypeList])->render();
        return response()->json(['html' => $view]);
    }

    public function teacherQualificationUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $qualification_id = $request->qualification_id;

            $validator = Validator::make($request->all(), [
                'type_int' => 'required',
                'subType_int' => 'required',
                'title_txt' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }
            $givesQTS_status = 0;
            if ($request->givesQTS_status) {
                $givesQTS_status = -1;
            }
            $qualified_dte = NULL;
            if ($request->qualified_dte != '') {
                $qualified_dte = date("Y-m-d", strtotime($request->qualified_dte));
            }

            DB::table('tbl_teacherQualification')
                ->where('qualification_id', $qualification_id)
                ->update([
                    'type_int' => $request->type_int,
                    'subType_int' => $request->subType_int,
                    'title_txt' => $request->title_txt,
                    'givesQTS_status' => $givesQTS_status,
                    'awardingBody_txt' => $request->awardingBody_txt,
                    'qualified_dte' => $qualified_dte
                ]);

            return redirect()->back()->with('success', "Qualification updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherQualificationDelete(Request $request)
    {
        $qualification_id = $request->teacherQualificationId;
        DB::table('tbl_teacherQualification')
            ->where('qualification_id', $qualification_id)
            ->delete();

        return 1;
    }

    public function teacherHealth(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Health");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $teacherDetail = DB::table('tbl_teacher')
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
                ->LeftJoin('tbl_description as nationalityTbl', function ($join) {
                    $join->on('nationalityTbl.description_int', '=', 'tbl_teacher.nationality_int')
                        ->where(function ($query) {
                            $query->where('nationalityTbl.descriptionGroup_int', '=', 8);
                        });
                })
                ->LeftJoin('tbl_description as emergencyContactRelation', function ($join) {
                    $join->on('emergencyContactRelation.description_int', '=', 'tbl_teacher.emergencyContactRelation_int')
                        ->where(function ($query) {
                            $query->where('emergencyContactRelation.descriptionGroup_int', '=', 10);
                        });
                })
                ->LeftJoin('tbl_description as bankTbl', function ($join) {
                    $join->on('bankTbl.description_int', '=', 'tbl_teacher.bank_int')
                        ->where(function ($query) {
                            $query->where('bankTbl.descriptionGroup_int', '=', 36);
                        });
                })
                ->LeftJoin('tbl_description as interviewQuality', function ($join) {
                    $join->on('interviewQuality.description_int', '=', 'tbl_teacher.interviewQuality_int')
                        ->where(function ($query) {
                            $query->where('interviewQuality.descriptionGroup_int', '=', 22);
                        });
                })
                ->LeftJoin('tbl_description as interviewLanguageSkills', function ($join) {
                    $join->on('interviewLanguageSkills.description_int', '=', 'tbl_teacher.interviewLanguageSkills_int')
                        ->where(function ($query) {
                            $query->where('interviewLanguageSkills.descriptionGroup_int', '=', 23);
                        });
                })
                ->LeftJoin('tbl_description as rightToWork', function ($join) {
                    $join->on('rightToWork.description_int', '=', 'tbl_teacher.rightToWork_int')
                        ->where(function ($query) {
                            $query->where('rightToWork.descriptionGroup_int', '=', 39);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            return view("web.teacher.teacher_health", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherPreferenceUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $prefDrive_status = 0;
            if ($request->prefDrive_status) {
                $prefDrive_status = -1;
            }
            $prefDailySupply_status = 0;
            if ($request->prefDailySupply_status) {
                $prefDailySupply_status = -1;
            }
            $prefLongTerm_status = 0;
            if ($request->prefLongTerm_status) {
                $prefLongTerm_status = -1;
            }
            $prefEarlyMorningCall_status = 0;
            if ($request->prefEarlyMorningCall_status) {
                $prefEarlyMorningCall_status = -1;
            }
            $prefSEN_status = 0;
            if ($request->prefSEN_status) {
                $prefSEN_status = -1;
            }
            $prefSENExperience_status = 0;
            if ($request->prefSENExperience_status) {
                $prefSENExperience_status = -1;
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'prefDrive_status' => $prefDrive_status,
                    'prefDailySupply_status' => $prefDailySupply_status,
                    'prefLongTerm_status' => $prefLongTerm_status,
                    'prefEarlyMorningCall_status' => $prefEarlyMorningCall_status,
                    'prefSEN_status' => $prefSEN_status,
                    'prefSENExperience_status' => $prefSENExperience_status,
                    'prefDistance_int' => $request->prefDistance_int,
                    'prefYearGroup_int' => $request->prefYearGroup_int,
                    'prefIdealJob_txt' => $request->prefIdealJob_txt,
                    'otherAgencies_txt' => $request->otherAgencies_txt,
                    'currentRate_dec' => $request->currentRate_dec,
                    'previousSchools_txt' => $request->previousSchools_txt
                ]);

            return redirect()->back()->with('success', "Preference updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherHealthUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $healthDeclaration_dte = NULL;
            if ($request->healthDeclaration_dte != '') {
                $healthDeclaration_dte = date("Y-m-d", strtotime($request->healthDeclaration_dte));
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'healthDeclaration_dte' => $healthDeclaration_dte,
                    'occupationalHealth_txt' => $request->occupationalHealth_txt,
                    'healthIssues_txt' => $request->healthIssues_txt
                ]);

            return redirect()->back()->with('success', "Health updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherReference(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Reference");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $teacherDetail = DB::table('tbl_teacher')
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
                ->LeftJoin('tbl_description as nationalityTbl', function ($join) {
                    $join->on('nationalityTbl.description_int', '=', 'tbl_teacher.nationality_int')
                        ->where(function ($query) {
                            $query->where('nationalityTbl.descriptionGroup_int', '=', 8);
                        });
                })
                ->LeftJoin('tbl_description as emergencyContactRelation', function ($join) {
                    $join->on('emergencyContactRelation.description_int', '=', 'tbl_teacher.emergencyContactRelation_int')
                        ->where(function ($query) {
                            $query->where('emergencyContactRelation.descriptionGroup_int', '=', 10);
                        });
                })
                ->LeftJoin('tbl_description as bankTbl', function ($join) {
                    $join->on('bankTbl.description_int', '=', 'tbl_teacher.bank_int')
                        ->where(function ($query) {
                            $query->where('bankTbl.descriptionGroup_int', '=', 36);
                        });
                })
                ->LeftJoin('tbl_description as interviewQuality', function ($join) {
                    $join->on('interviewQuality.description_int', '=', 'tbl_teacher.interviewQuality_int')
                        ->where(function ($query) {
                            $query->where('interviewQuality.descriptionGroup_int', '=', 22);
                        });
                })
                ->LeftJoin('tbl_description as interviewLanguageSkills', function ($join) {
                    $join->on('interviewLanguageSkills.description_int', '=', 'tbl_teacher.interviewLanguageSkills_int')
                        ->where(function ($query) {
                            $query->where('interviewLanguageSkills.descriptionGroup_int', '=', 23);
                        });
                })
                ->LeftJoin('tbl_description as rightToWork', function ($join) {
                    $join->on('rightToWork.description_int', '=', 'tbl_teacher.rightToWork_int')
                        ->where(function ($query) {
                            $query->where('rightToWork.descriptionGroup_int', '=', 39);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $referenceList = DB::table('tbl_teacherReference')
                ->leftJoin(
                    DB::raw('(SELECT teacherReference_id, DATE(MAX(sentOn_dtm)) AS lastSent_dte, COUNT(referenceSend_id) AS totalSent_int FROM tbl_teacherReferenceRequest GROUP BY teacherReference_id) AS t_sent'),
                    function ($join) {
                        $join->on('tbl_teacherReference.teacherReference_id', '=', 't_sent.teacherReference_id');
                    }
                )
                ->select('tbl_teacherReference.*', 'lastSent_dte', 'totalSent_int')
                ->where('tbl_teacherReference.teacher_id', $id)
                ->get();

            $referenceTypeList = DB::table('tbl_referenceType')
                ->select('tbl_referenceType.*')
                ->get();

            return view("web.teacher.references", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'referenceList' => $referenceList, 'referenceTypeList' => $referenceTypeList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function newTeacherReferenceInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $validator = Validator::make($request->all(), [
                'referenceType_id' => 'required',
                'employer_txt' => 'required',
                'postcode_txt' => 'required',
                'refereeName_txt' => 'required',
                'refereeEmail_txt' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }
            $employedFrom_dte = NULL;
            if ($request->employedFrom_dte != '') {
                $employedFrom_dte = date("Y-m-d", strtotime($request->employedFrom_dte));
            }
            $employedUntil_dte = NULL;
            if ($request->employedUntil_dte != '') {
                $employedUntil_dte = date("Y-m-d", strtotime($request->employedUntil_dte));
            }

            DB::table('tbl_teacherReference')
                ->insert([
                    'teacher_id' => $teacher_id,
                    'referenceType_id' => $request->referenceType_id,
                    'employer_txt' => $request->employer_txt,
                    'address1_txt' => $request->address1_txt,
                    'address2_txt' => $request->address2_txt,
                    'address3_txt' => $request->address3_txt,
                    'addrress4_txt' => $request->addrress4_txt,
                    'postcode_txt' => $request->postcode_txt,
                    'refereeName_txt' => $request->refereeName_txt,
                    'refereeEmail_txt' => $request->refereeEmail_txt,
                    'employedFrom_dte' => $employedFrom_dte,
                    'employedUntil_dte' => $employedUntil_dte,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Teacher reference added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherReferenceEdit(Request $request)
    {
        $input = $request->all();
        $teacherReferenceId = $input['teacherReferenceId'];

        $Detail = DB::table('tbl_teacherReference')
            ->where('teacherReference_id', "=", $teacherReferenceId)
            ->first();
        $referenceTypeList = DB::table('tbl_referenceType')
            ->select('tbl_referenceType.*')
            ->get();

        $view = view("web.teacher.edit_teacher_reference_view", ['Detail' => $Detail, 'referenceTypeList' => $referenceTypeList])->render();
        return response()->json(['html' => $view]);
    }

    public function newTeacherReferenceUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $teacherReference_id = $request->teacherReference_id;
            $validator = Validator::make($request->all(), [
                'referenceType_id' => 'required',
                'employer_txt' => 'required',
                'postcode_txt' => 'required',
                'refereeName_txt' => 'required',
                'refereeEmail_txt' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }
            $employedFrom_dte = NULL;
            if ($request->employedFrom_dte != '') {
                $employedFrom_dte = date("Y-m-d", strtotime($request->employedFrom_dte));
            }
            $employedUntil_dte = NULL;
            if ($request->employedUntil_dte != '') {
                $employedUntil_dte = date("Y-m-d", strtotime($request->employedUntil_dte));
            }

            DB::table('tbl_teacherReference')
                ->where('teacherReference_id', $teacherReference_id)
                ->update([
                    'referenceType_id' => $request->referenceType_id,
                    'employer_txt' => $request->employer_txt,
                    'address1_txt' => $request->address1_txt,
                    'address2_txt' => $request->address2_txt,
                    'address3_txt' => $request->address3_txt,
                    'addrress4_txt' => $request->addrress4_txt,
                    'postcode_txt' => $request->postcode_txt,
                    'refereeName_txt' => $request->refereeName_txt,
                    'refereeEmail_txt' => $request->refereeEmail_txt,
                    'employedFrom_dte' => $employedFrom_dte,
                    'employedUntil_dte' => $employedUntil_dte,
                    // 'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Teacher reference updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function getTeacherReceiveReference(Request $request)
    {
        $input = $request->all();
        $teacherReferenceId = $input['teacherReferenceId'];

        $Detail = DB::table('tbl_teacherReference')
            ->where('teacherReference_id', "=", $teacherReferenceId)
            ->first();
        $feedbackList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 38)
            ->get();

        $textQnList =  array();
        if ($Detail && $Detail->referenceType_id) {
            $textQnList = DB::table('tbl_referenceTypeQuestion')
                ->join('tbl_referenceQuestion', function ($join) {
                    $join->on('tbl_referenceTypeQuestion.question_id', '=', 'tbl_referenceQuestion.question_id')
                        ->where(function ($query) {
                            $query->where('tbl_referenceQuestion.questionType_int', '=', 1);
                        });
                })
                ->select('tbl_referenceTypeQuestion.*', 'tbl_referenceQuestion.questionType_int', 'tbl_referenceQuestion.question_txt', 'tbl_referenceQuestion.isCurrent_status', 'tbl_referenceQuestion.referenceLookupGroup_id')
                ->where('tbl_referenceTypeQuestion.referenceType_id', $Detail->referenceType_id)
                ->get();
        }

        $view = view("web.teacher.edit_receive_reference_view", ['Detail' => $Detail, 'feedbackList' => $feedbackList, 'textQnList' => $textQnList])->render();
        return response()->json(['html' => $view]);
    }

    public function teacherDocuments(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Documents");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $teacherDetail = DB::table('tbl_teacher')
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
                ->LeftJoin('tbl_description as nationalityTbl', function ($join) {
                    $join->on('nationalityTbl.description_int', '=', 'tbl_teacher.nationality_int')
                        ->where(function ($query) {
                            $query->where('nationalityTbl.descriptionGroup_int', '=', 8);
                        });
                })
                ->LeftJoin('tbl_description as emergencyContactRelation', function ($join) {
                    $join->on('emergencyContactRelation.description_int', '=', 'tbl_teacher.emergencyContactRelation_int')
                        ->where(function ($query) {
                            $query->where('emergencyContactRelation.descriptionGroup_int', '=', 10);
                        });
                })
                ->LeftJoin('tbl_description as bankTbl', function ($join) {
                    $join->on('bankTbl.description_int', '=', 'tbl_teacher.bank_int')
                        ->where(function ($query) {
                            $query->where('bankTbl.descriptionGroup_int', '=', 36);
                        });
                })
                ->LeftJoin('tbl_description as interviewQuality', function ($join) {
                    $join->on('interviewQuality.description_int', '=', 'tbl_teacher.interviewQuality_int')
                        ->where(function ($query) {
                            $query->where('interviewQuality.descriptionGroup_int', '=', 22);
                        });
                })
                ->LeftJoin('tbl_description as interviewLanguageSkills', function ($join) {
                    $join->on('interviewLanguageSkills.description_int', '=', 'tbl_teacher.interviewLanguageSkills_int')
                        ->where(function ($query) {
                            $query->where('interviewLanguageSkills.descriptionGroup_int', '=', 23);
                        });
                })
                ->LeftJoin('tbl_description as rightToWork', function ($join) {
                    $join->on('rightToWork.description_int', '=', 'tbl_teacher.rightToWork_int')
                        ->where(function ($query) {
                            $query->where('rightToWork.descriptionGroup_int', '=', 39);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $RTW_list = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 39)
                ->get();

            $DBS_list = DB::table('tbl_teacherdbs')
                ->select('tbl_teacherdbs.*')
                ->where('tbl_teacherdbs.teacher_id', $id)
                ->get();

            $documentList = DB::table('tbl_teacherDocument')
                ->LeftJoin('tbl_description', function ($join) {
                    $join->on('tbl_description.description_int', '=', 'tbl_teacherDocument.type_int')
                        ->where(function ($query) {
                            $query->where('tbl_description.descriptionGroup_int', '=', 19);
                        });
                })
                ->select('tbl_teacherDocument.*', 'tbl_description.description_txt as doc_type_txt')
                ->where('tbl_teacherDocument.teacher_id', $id)
                ->where('tbl_teacherDocument.uploadOn_dtm', '!=', NULL)
                ->orderBy('tbl_teacherDocument.uploadOn_dtm', 'DESC')
                ->get();

            $typeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 19)
                ->get();

            return view("web.teacher.teacher_documents", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'RTW_list' => $RTW_list, 'DBS_list' => $DBS_list, 'documentList' => $documentList, 'typeList' => $typeList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherDocumentListUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $docPassport_status = 0;
            if ($request->docPassport_status) {
                $docPassport_status = -1;
            }
            $docDriversLicence_status = 0;
            if ($request->docDriversLicence_status) {
                $docDriversLicence_status = -1;
            }
            $docBankStatement_status = 0;
            if ($request->docBankStatement_status) {
                $docBankStatement_status = -1;
            }
            $docDBS_status = 0;
            if ($request->docDBS_status) {
                $docDBS_status = -1;
            }
            $docDisqualForm_status = 0;
            if ($request->docDisqualForm_status) {
                $docDisqualForm_status = -1;
            }
            $docHealthDec_status = 0;
            if ($request->docHealthDec_status) {
                $docHealthDec_status = -1;
            }
            $docEUCard_status = 0;
            if ($request->docEUCard_status) {
                $docEUCard_status = -1;
            }
            $docUtilityBill_status = 0;
            if ($request->docUtilityBill_status) {
                $docUtilityBill_status = -1;
            }
            $docTelephoneBill_status = 0;
            if ($request->docTelephoneBill_status) {
                $docTelephoneBill_status = -1;
            }
            $docBenefitStatement_status = 0;
            if ($request->docBenefitStatement_status) {
                $docBenefitStatement_status = -1;
            }
            $docCreditCardBill_status = 0;
            if ($request->docCreditCardBill_status) {
                $docCreditCardBill_status = -1;
            }
            $docP45P60_status = 0;
            if ($request->docP45P60_status) {
                $docP45P60_status = -1;
            }
            $docCouncilTax_status = 0;
            if ($request->docCouncilTax_status) {
                $docCouncilTax_status = -1;
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'docPassport_status' => $docPassport_status,
                    'docDriversLicence_status' => $docDriversLicence_status,
                    'docBankStatement_status' => $docBankStatement_status,
                    'docDBS_status' => $docDBS_status,
                    'docDisqualForm_status' => $docDisqualForm_status,
                    'docHealthDec_status' => $docHealthDec_status,
                    'docEUCard_status' => $docEUCard_status,
                    'docUtilityBill_status' => $docUtilityBill_status,
                    'docTelephoneBill_status' => $docTelephoneBill_status,
                    'docBenefitStatement_status' => $docBenefitStatement_status,
                    'docCreditCardBill_status' => $docCreditCardBill_status,
                    'docP45P60_status' => $docP45P60_status,
                    'docCouncilTax_status' => $docCouncilTax_status
                ]);

            return redirect()->back()->with('success', "Document updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherVettingUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $vetUpdateService_status = 0;
            $vetUpdateServiceChecked_dte = NULL;
            if ($request->vetUpdateService_status) {
                $vetUpdateService_status = -1;
                $vetUpdateServiceChecked_dte = date("Y-m-d");
            }
            $vetUpdateServiceReg_dte = NULL;
            if ($request->vetUpdateServiceReg_dte != '') {
                $vetUpdateServiceReg_dte = date("Y-m-d", strtotime($request->vetUpdateServiceReg_dte));
            }
            $vetList99Checked_dte = NULL;
            if ($request->vetList99Checked_dte) {
                $vetList99Checked_dte = date("Y-m-d");
            }
            $vetNctlExempt_dte = NULL;
            if ($request->vetNctlExempt_dte) {
                $vetNctlExempt_dte = date("Y-m-d");
            }
            $vetNCTLChecked_dte = NULL;
            if ($request->vetNCTLChecked_dte) {
                $vetNCTLChecked_dte = date("Y-m-d");
            }
            $vetDisqualAssociation_status = 0;
            $vetDisqualAssociation_dte = NULL;
            if ($request->vetDisqualAssociation_status) {
                $vetDisqualAssociation_status = -1;
                $vetDisqualAssociation_dte = date("Y-m-d");
            }
            $safeguardingInduction_status = 0;
            $safeguardingInduction_dte = NULL;
            if ($request->safeguardingInduction_status) {
                $safeguardingInduction_status = -1;
                $safeguardingInduction_dte = date("Y-m-d");
            }
            $vets128_status = 0;
            $vets128_dte = NULL;
            if ($request->vets128_status) {
                $vets128_status = -1;
                $vets128_dte = date("Y-m-d");
            }
            $vetEEARestriction_status = 0;
            $vetEEARestriction_dte = NULL;
            if ($request->vetEEARestriction_status) {
                $vetEEARestriction_status = -1;
                $vetEEARestriction_dte = date("Y-m-d");
            }
            $vetRadical_status = 0;
            $vetRadical_dte = NULL;
            if ($request->vetRadical_status) {
                $vetRadical_status = -1;
                $vetRadical_dte = date("Y-m-d");
            }
            $vetQualification_status = 0;
            $vetQualification_dte = NULL;
            if ($request->vetQualification_status) {
                $vetQualification_status = -1;
                $vetQualification_dte = date("Y-m-d");
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'vetUpdateService_status' => $vetUpdateService_status,
                    'vetUpdateServiceChecked_dte' => $vetUpdateServiceChecked_dte,
                    'vetUpdateServiceReg_dte' => $vetUpdateServiceReg_dte,
                    'vetList99Checked_dte' => $vetList99Checked_dte,
                    'vetNctlExempt_dte' => $vetNctlExempt_dte,
                    'vetNCTLChecked_dte' => $vetNCTLChecked_dte,
                    'vetDisqualAssociation_status' => $vetDisqualAssociation_status,
                    'vetDisqualAssociation_dte' => $vetDisqualAssociation_dte,
                    'safeguardingInduction_status' => $safeguardingInduction_status,
                    'safeguardingInduction_dte' => $safeguardingInduction_dte,
                    'rightToWork_int' => $request->rightToWork_int,
                    'vets128_status' => $vets128_status,
                    'vets128_dte' => $vets128_dte,
                    'vetEEARestriction_status' => $vetEEARestriction_status,
                    'vetEEARestriction_dte' => $vetEEARestriction_dte,
                    'vetRadical_status' => $vetRadical_status,
                    'vetRadical_dte' => $vetRadical_dte,
                    'vetQualification_status' => $vetQualification_status,
                    'vetQualification_dte' => $vetQualification_dte
                ]);

            return redirect()->back()->with('success', "Teacher vetting updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function newTeacherDbsInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $validator = Validator::make($request->all(), [
                'certificateNumber_txt' => 'required',
                'DBSDate_dte' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }
            $DBSDate_dte = NULL;
            if ($request->DBSDate_dte != '') {
                $DBSDate_dte = date("Y-m-d", strtotime($request->DBSDate_dte));
            }
            $dbsWarning_status = 0;
            if ($request->dbsWarning_status) {
                $dbsWarning_status = -1;
            }
            $dbsWarning_txt = NULL;
            if ($request->dbsWarning_txt) {
                $dbsWarning_txt = $request->dbsWarning_txt;
            }
            $lastCheckedOn_dte = date("Y-m-d");
            if ($request->lastCheckedOn) {
                $lastCheckedOn_dte = date("Y-m-d");
            }

            DB::table('tbl_teacherdbs')
                ->insert([
                    'teacher_id' => $teacher_id,
                    'certificateNumber_txt' => $request->certificateNumber_txt,
                    'DBSDate_dte' => $DBSDate_dte,
                    'positionAppliedFor_txt' => $request->positionAppliedFor_txt,
                    'employerName_txt' => $request->employerName_txt,
                    'registeredBody_txt' => $request->registeredBody_txt,
                    'dbsWarning_status' => $dbsWarning_status,
                    'dbsWarning_txt' => $dbsWarning_txt,
                    'lastCheckedOn_dte' => $lastCheckedOn_dte,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "DBS record added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherDbsRecordEdit(Request $request)
    {
        $input = $request->all();
        $DBSId = $input['DBSId'];

        $detail = DB::table('tbl_teacherdbs')
            ->where('DBS_id', "=", $DBSId)
            ->first();

        $view = view("web.teacher.edit_dbs_view", ['detail' => $detail])->render();
        return response()->json(['html' => $view]);
    }

    public function teacherDbsUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $editDBSId = $request->editDBSId;
            $validator = Validator::make($request->all(), [
                'certificateNumber_txt' => 'required',
                'DBSDate_dte' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }
            $DBSDate_dte = NULL;
            if ($request->DBSDate_dte != '') {
                $DBSDate_dte = date("Y-m-d", strtotime($request->DBSDate_dte));
            }
            $dbsWarning_status = 0;
            if ($request->dbsWarning_status) {
                $dbsWarning_status = -1;
            }
            $dbsWarning_txt = NULL;
            if ($request->dbsWarning_txt) {
                $dbsWarning_txt = $request->dbsWarning_txt;
            }
            $lastCheckedOn_dte = $request->lastCheckedOn_dte != null ? $request->lastCheckedOn_dte : date("Y-m-d");
            if ($request->lastCheckedOn) {
                $lastCheckedOn_dte = date("Y-m-d");
            }

            DB::table('tbl_teacherdbs')
                ->where('DBS_id', $editDBSId)
                ->update([
                    'certificateNumber_txt' => $request->certificateNumber_txt,
                    'DBSDate_dte' => $DBSDate_dte,
                    'positionAppliedFor_txt' => $request->positionAppliedFor_txt,
                    'employerName_txt' => $request->employerName_txt,
                    'registeredBody_txt' => $request->registeredBody_txt,
                    'dbsWarning_status' => $dbsWarning_status,
                    'dbsWarning_txt' => $dbsWarning_txt,
                    'lastCheckedOn_dte' => $lastCheckedOn_dte
                ]);

            return redirect()->back()->with('success', "DBS record updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherDbsRecordView(Request $request)
    {
        $input = $request->all();
        $DBSId = $input['DBSId'];

        $detail = DB::table('tbl_teacherdbs')
            ->where('DBS_id', "=", $DBSId)
            ->first();

        $view = view("web.teacher.record_dbs_view", ['detail' => $detail])->render();
        return response()->json(['html' => $view]);
    }

    public function teacherDbsRecordDelete(Request $request)
    {
        $DBSId = $request->DBSId;
        DB::table('tbl_teacherdbs')
            ->where('DBS_id', "=", $DBSId)
            ->delete();
        return 1;
    }

    public function teacherDocumentInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;

            $fPath = '';
            $fType = '';
            $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');
            if ($image = $request->file('file')) {
                $extension = $image->extension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "_" . $file_name;
                    $image->move('images/teacher', $name);
                    $fPath = 'images/teacher/' . $name;
                    $fType = $extension;
                } else {
                    return redirect()->back()->with('error', "Please upload valid file.");
                }
            } else {
                return redirect()->back()->with('error', "Please upload valid file.");
            }

            DB::table('tbl_teacherDocument')
                ->insert([
                    'teacher_id' => $teacher_id,
                    'file_location' => $fPath,
                    'file_name' => $request->file_name,
                    'type_int' => $request->type_int,
                    'file_type' => $fType,
                    'uploadOn_dtm' => date('Y-m-d H:i:s'),
                    'loggedOn_dtm' => date('Y-m-d H:i:s'),
                    'loggedBy_id' => $user_id,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Document added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function getTeacherDocDetail(Request $request)
    {
        $input = $request->all();
        $teacherDocument_id = $input['DocumentId'];

        $docDetail = DB::table('tbl_teacherDocument')
            ->where('teacherDocument_id', "=", $teacherDocument_id)
            ->first();
        $typeList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 19)
            ->get();

        $view = view("web.teacher.document_edit_view", ['docDetail' => $docDetail, 'typeList' => $typeList])->render();
        return response()->json(['html' => $view]);
    }

    public function teacherDocumentUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
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
                    $image->move('images/teacher', $name);
                    $fPath = 'images/teacher/' . $name;
                    $fType = $extension;
                    if (file_exists($file_location)) {
                        unlink($file_location);
                    }
                } else {
                    return redirect()->back()->with('error', "Please upload valid file.");
                }
            } else {
                return redirect()->back()->with('error', "Please upload valid file.");
            }

            DB::table('tbl_teacherDocument')
                ->where('teacherDocument_id', '=', $editDocumentId)
                ->update([
                    'file_location' => $fPath,
                    'file_name' => $request->file_name,
                    'type_int' => $request->type_int,
                    'file_type' => $fType,
                    'uploadOn_dtm' => date('Y-m-d H:i:s'),
                    'loggedOn_dtm' => date('Y-m-d H:i:s'),
                    'loggedBy_id' => $user_id
                ]);

            return redirect()->back()->with('success', "Document updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherDocumentDelete(Request $request)
    {
        $DocumentId = $request->DocumentId;
        $docDetail = DB::table('tbl_teacherDocument')
            ->where('teacherDocument_id', "=", $DocumentId)
            ->first();
        if ($docDetail) {
            DB::table('tbl_teacherDocument')
                ->where('teacherDocument_id', "=", $DocumentId)
                ->delete();

            if (file_exists($docDetail->file_location)) {
                unlink($docDetail->file_location);
            }
        }
        return 1;
    }

    public function teacherContactLog(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Contact Log");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $teacherDetail = DB::table('tbl_teacher')
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
                ->LeftJoin('tbl_description as nationalityTbl', function ($join) {
                    $join->on('nationalityTbl.description_int', '=', 'tbl_teacher.nationality_int')
                        ->where(function ($query) {
                            $query->where('nationalityTbl.descriptionGroup_int', '=', 8);
                        });
                })
                ->LeftJoin('tbl_description as emergencyContactRelation', function ($join) {
                    $join->on('emergencyContactRelation.description_int', '=', 'tbl_teacher.emergencyContactRelation_int')
                        ->where(function ($query) {
                            $query->where('emergencyContactRelation.descriptionGroup_int', '=', 10);
                        });
                })
                ->LeftJoin('tbl_description as bankTbl', function ($join) {
                    $join->on('bankTbl.description_int', '=', 'tbl_teacher.bank_int')
                        ->where(function ($query) {
                            $query->where('bankTbl.descriptionGroup_int', '=', 36);
                        });
                })
                ->LeftJoin('tbl_description as interviewQuality', function ($join) {
                    $join->on('interviewQuality.description_int', '=', 'tbl_teacher.interviewQuality_int')
                        ->where(function ($query) {
                            $query->where('interviewQuality.descriptionGroup_int', '=', 22);
                        });
                })
                ->LeftJoin('tbl_description as interviewLanguageSkills', function ($join) {
                    $join->on('interviewLanguageSkills.description_int', '=', 'tbl_teacher.interviewLanguageSkills_int')
                        ->where(function ($query) {
                            $query->where('interviewLanguageSkills.descriptionGroup_int', '=', 23);
                        });
                })
                ->LeftJoin('tbl_description as rightToWork', function ($join) {
                    $join->on('rightToWork.description_int', '=', 'tbl_teacher.rightToWork_int')
                        ->where(function ($query) {
                            $query->where('rightToWork.descriptionGroup_int', '=', 39);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $teacherContactLogs = DB::table('tbl_teacherContactLog')
                ->LeftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_teacherContactLog.contactBy_id')
                ->LeftJoin('tbl_description', function ($join) {
                    $join->on('tbl_description.description_int', '=', 'tbl_teacherContactLog.method_int')
                        ->where(function ($query) {
                            $query->where('tbl_description.descriptionGroup_int', '=', 17);
                        });
                })
                ->select('tbl_teacherContactLog.*', 'tbl_description.description_txt as method_txt', 'tbl_user.firstName_txt', 'tbl_user.surname_txt')
                ->where('tbl_teacherContactLog.teacher_id', $id)
                ->orderBy('tbl_teacherContactLog.contactOn_dtm', 'DESC')
                ->get();

            $methodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 17)
                ->get();

            $quickSettingList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 18)
                ->get();

            return view("web.teacher.teacher_contact_log", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'teacherContactLogs' => $teacherContactLogs, 'methodList' => $methodList, 'quickSettingList' => $quickSettingList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherContactLogInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $callbackOn_dtm = null;
            if ($request->callBackCheck && $request->quick_setting_date && $request->quick_setting_time) {
                $d = date("Y-m-d", strtotime($request->quick_setting_date));
                $callbackOn_dtm = $d . ' ' . $request->quick_setting_time . ':00';
            }

            DB::table('tbl_teacherContactLog')
                ->insert([
                    'teacher_id' => $teacher_id,
                    'method_int' => $request->method_int,
                    'notes_txt' => $request->notes_txt,
                    'contactOn_dtm' => date('Y-m-d H:i:s'),
                    'contactBy_id' => $user_id,
                    'callbackOn_dtm' => $callbackOn_dtm,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Teacher contact log added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherContactLogEdit(Request $request)
    {
        $input = $request->all();
        $teacherContactLog_id = $input['contactLogId'];

        $contactDetail = DB::table('tbl_teacherContactLog')
            ->where('teacherContactLog_id', "=", $teacherContactLog_id)
            ->first();

        $methodList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 17)
            ->get();

        $quickSettingList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 18)
            ->get();

        $view = view("web.teacher.contact_log_edit_view", ['contactDetail' => $contactDetail, 'quickSettingList' => $quickSettingList, 'methodList' => $methodList])->render();
        return response()->json(['html' => $view]);
    }

    public function teacherContactLogUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacherContactLog_id = $request->editContactLogId;
            $callbackOn_dtm = null;
            if ($request->callBackCheck && $request->quick_setting_date && $request->quick_setting_time) {
                $d = date("Y-m-d", strtotime($request->quick_setting_date));
                $callbackOn_dtm = $d . ' ' . $request->quick_setting_time . ':00';
            }

            DB::table('tbl_teacherContactLog')
                ->where('teacherContactLog_id', $teacherContactLog_id)
                ->update([
                    'method_int' => $request->method_int,
                    'notes_txt' => $request->notes_txt,
                    'contactOn_dtm' => date('Y-m-d H:i:s'),
                    'contactBy_id' => $user_id,
                    'callbackOn_dtm' => $callbackOn_dtm,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Teacher contact log updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherContactLogDelete(Request $request)
    {
        $teacherContactLog_id = $request->contactLogId;
        DB::table('tbl_teacherContactLog')
            ->where('teacherContactLog_id', $teacherContactLog_id)
            ->delete();
        return 1;
    }

    public function teacherPayroll(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Payroll");
            $headerTitle = "Teachers";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $teacherDetail = DB::table('tbl_teacher')
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
                ->LeftJoin('tbl_description as nationalityTbl', function ($join) {
                    $join->on('nationalityTbl.description_int', '=', 'tbl_teacher.nationality_int')
                        ->where(function ($query) {
                            $query->where('nationalityTbl.descriptionGroup_int', '=', 8);
                        });
                })
                ->LeftJoin('tbl_description as emergencyContactRelation', function ($join) {
                    $join->on('emergencyContactRelation.description_int', '=', 'tbl_teacher.emergencyContactRelation_int')
                        ->where(function ($query) {
                            $query->where('emergencyContactRelation.descriptionGroup_int', '=', 10);
                        });
                })
                ->LeftJoin('tbl_description as bankTbl', function ($join) {
                    $join->on('bankTbl.description_int', '=', 'tbl_teacher.bank_int')
                        ->where(function ($query) {
                            $query->where('bankTbl.descriptionGroup_int', '=', 36);
                        });
                })
                ->LeftJoin('tbl_description as interviewQuality', function ($join) {
                    $join->on('interviewQuality.description_int', '=', 'tbl_teacher.interviewQuality_int')
                        ->where(function ($query) {
                            $query->where('interviewQuality.descriptionGroup_int', '=', 22);
                        });
                })
                ->LeftJoin('tbl_description as interviewLanguageSkills', function ($join) {
                    $join->on('interviewLanguageSkills.description_int', '=', 'tbl_teacher.interviewLanguageSkills_int')
                        ->where(function ($query) {
                            $query->where('interviewLanguageSkills.descriptionGroup_int', '=', 23);
                        });
                })
                ->LeftJoin('tbl_description as rightToWork', function ($join) {
                    $join->on('rightToWork.description_int', '=', 'tbl_teacher.rightToWork_int')
                        ->where(function ($query) {
                            $query->where('rightToWork.descriptionGroup_int', '=', 39);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $bankList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 36)
                ->get();

            return view("web.teacher.teacher_payroll", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'bankList' => $bankList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherPayrollUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $basePayRate_dec = 0;
            if ($request->basePayRate_dec != '') {
                $basePayRate_dec = $request->basePayRate_dec;
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'NINumber_txt' => $request->NINumber_txt,
                    'bank_int' => $request->bank_int,
                    'sortCode_int' => $request->sortCode_int,
                    'accountNumber_txt' => $request->accountNumber_txt,
                    'basePayRate_dec' => $basePayRate_dec,
                    'RACSnumber_txt' => $request->RACSnumber_txt
                ]);

            return redirect()->back()->with('success', "Bank/Payroll updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }
}
