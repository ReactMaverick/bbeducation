<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
            $NQTCompleted_dte = null;
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

            return view("web.teacher.teacher_detail", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'contactItemList' => $contactItemList]);
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

            return view("web.teacher.teacher_profession", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail]);
        } else {
            return redirect()->intended('/');
        }
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

            return view("web.teacher.references", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail]);
        } else {
            return redirect()->intended('/');
        }
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

            return view("web.teacher.teacher_documents", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail]);
        } else {
            return redirect()->intended('/');
        }
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

            return view("web.teacher.teacher_contact_log", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail]);
        } else {
            return redirect()->intended('/');
        }
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

            return view("web.teacher.teacher_payroll", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail]);
        } else {
            return redirect()->intended('/');
        }
    }
}
