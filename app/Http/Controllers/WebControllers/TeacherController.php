<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Carbon\CarbonPeriod;
use App\Http\Controllers\WebControllers\AlertController;
use Hash;
use PDF;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Response;

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

    public function checkTeacherMailExist(Request $request)
    {
        $loginMail = $request->loginMail;
        $teacherDet = DB::table('tbl_teacher')
            ->select('tbl_teacher.*')
            ->where('login_mail', $loginMail)
            ->get();
        if (count($teacherDet) > 0) {
            return "Yes";
        } else {
            return "No";
        }
    }

    public function getGridReference(Request $request)
    {
        $postcodeTxt = $request->postcodeTxt;
        $api_key = env('MAP_QUEST_KEY', 'b7h48hPFtiu4ntA2y1jNb7giRZo04E1j');
        $result['lat'] = '';
        $result['long'] = '';

        if (!empty($postcodeTxt)) {
            try {
                // $URL = "https://www.mapquestapi.com/geocoding/v1/address?key=" . $api_key . "&postalCode=" . $postcodeTxt . "";
                $url = "http://www.mapquestapi.com/geocoding/v1/address?key=$api_key&postalCode=$postcodeTxt";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                // Parse the JSON response and extract the latitude and longitude
                $data = json_decode($response, true);
                $lat = $data['results'][0]['locations'][0]['latLng']['lat'];
                $lng = $data['results'][0]['locations'][0]['latLng']['lng'];

                $result['lat'] = $lat;
                $result['long'] = $lng;
            } catch (\Exception $e) {
                //echo $e;exit;
            }
        }

        return response()->json($result);
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
                $NQTCompleted_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->NQTCompleted_dte)));
            }
            $activeStatus = 0;
            if ($request->activeStatus) {
                $activeStatus = 1;
            }

            $teacher_id = DB::table('tbl_teacher')
                ->insertGetId([
                    'company_id' => $company_id,
                    'title_int' => $request->title_int,
                    'firstName_txt' => $request->firstName_txt,
                    'surname_txt' => $request->surname_txt,
                    'knownAs_txt' => $request->knownAs_txt,
                    'maidenPreviousNames_txt' => $request->maidenPreviousNames_txt,
                    'middleNames_txt' => $request->middleNames_txt,
                    'login_mail' => $request->login_mail,
                    'address1_txt' => $request->address1_txt,
                    'address2_txt' => $request->address2_txt,
                    'address3_txt' => $request->address3_txt,
                    'address4_txt' => $request->address4_txt,
                    'postcode_txt' => $request->postcode_txt,
                    'nationality_int' => $request->nationality_int,
                    'DOB_dte' => date("Y-m-d", strtotime(str_replace('/', '-', $request->DOB_dte))),
                    'professionalType_int' => $request->professionalType_int,
                    'ageRangeSpecialism_int' => $request->ageRangeSpecialism_int,
                    'NQTRequired_status' => $NQTRequired_status,
                    'NQTCompleted_dte' => $NQTCompleted_dte,
                    'lat_txt' => $lat_txt,
                    'lon_txt' => $lon_txt,
                    'activeStatus' => $activeStatus,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            if ($request->passwordReset && $request->login_mail) {
                // $mail = 'sudip.websadroit@gmail.com';
                $uID = base64_encode($teacher_id);
                $mailData['firstName_txt'] = $request->firstName_txt;
                $mailData['surname_txt'] = $request->surname_txt;
                $mailData['mail'] = $request->login_mail;
                $mailData['rUrl'] = url('/teacher/set-password') . '/' . $uID;
                $myVar = new AlertController();
                $myVar->reset_password($mailData);
            }

            return redirect('/teacher-detail/'.$teacher_id)->with('success', "Teacher added successfully.");
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
            $v_overdueDays = 7;

            $pendingRefList = DB::table('tbl_teacher')
                ->LeftJoin('tbl_teacherReference', 'tbl_teacher.teacher_id', '=', 'tbl_teacherReference.teacher_id')
                ->leftJoin(
                    DB::raw("(SELECT teacherReference_id, DATE(MAX(sentOn_dtm)) AS lastSent_dte, COUNT(referenceSend_id) AS totalSent_int FROM tbl_teacherReferenceRequest GROUP BY teacherReference_id) AS t_sent"),
                    function ($join) {
                        $join->on('tbl_teacherReference.teacherReference_id', '=', 't_sent.teacherReference_id');
                    }
                )
                ->select('tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_teacherReference.teacherReference_id', DB::raw("IF(tbl_teacherReference.teacherReference_id IS NULL, 'No References Listed', employer_txt) AS employer_txt"), 'tbl_teacherReference.employedFrom_dte', 'tbl_teacherReference.employedUntil_dte', DB::raw("IF(lastSent_dte IS NULL, 'Not Sent', lastSent_dte) AS lastSent_txt"), DB::raw("IF(totalSent_int IS NULL, 0, totalSent_int) AS totalSent_int"), DB::raw("IF(lastSent_dte IS NULL, '', IF(DATEDIFF(CURDATE(), lastSent_dte) < '$v_overdueDays', '', DATEDIFF(CURDATE(), lastSent_dte) -'$v_overdueDays')) AS overDueDays_int"))
                ->whereIn('applicationStatus_int', array(1, 2, 7))
                ->where('receivedOn_dtm', NULL)
                ->groupBy('tbl_teacherReference.teacherReference_id')
                ->orderBy('lastSent_dte', 'ASC')
                ->get();

            return view("web.teacher.teacher_pending_reference", ['title' => $title, 'headerTitle' => $headerTitle, 'pendingRefList' => $pendingRefList]);
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

            $calenderList = DB::table('tbl_teacher')
                ->LeftJoin('tbl_teacherDocument', function ($join) {
                    $join->on('tbl_teacherDocument.teacher_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_teacherDocument.type_int', '=', 1)
                                ->where('tbl_teacherDocument.isCurrent_status', '<>', 0);
                        });
                })
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, CONCAT(tbl_school.name_txt, ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int))) AS day1Avail_txt, tbl_asn.asn_id AS day1Link_id, dayPart_int AS day1LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day1Amount_dec, tbl_asn.school_id AS day1School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id LEFT JOIN tbl_school ON tbl_asn.school_id = tbl_school.school_id WHERE asnDate_dte = '$weekStartDate' AND status_int = 3 GROUP BY teacher_id) AS t_day1"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day1.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, CONCAT(tbl_school.name_txt, ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int))) AS day2Avail_txt, tbl_asn.asn_id AS day2Link_id, dayPart_int AS day2LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day2Amount_dec, tbl_asn.school_id AS day2School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id LEFT JOIN tbl_school ON tbl_asn.school_id = tbl_school.school_id WHERE asnDate_dte = '$weekStartDate2' AND status_int = 3 GROUP BY teacher_id) AS t_day2"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day2.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, CONCAT(tbl_school.name_txt, ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int))) AS day3Avail_txt, tbl_asn.asn_id AS day3Link_id, dayPart_int AS day3LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day3Amount_dec, tbl_asn.school_id AS day3School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id LEFT JOIN tbl_school ON tbl_asn.school_id = tbl_school.school_id WHERE asnDate_dte = '$weekStartDate3' AND status_int = 3 GROUP BY teacher_id) AS t_day3"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day3.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, CONCAT(tbl_school.name_txt, ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int))) AS day4Avail_txt, tbl_asn.asn_id AS day4Link_id, dayPart_int AS day4LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day4Amount_dec, tbl_asn.school_id AS day4School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id LEFT JOIN tbl_school ON tbl_asn.school_id = tbl_school.school_id WHERE asnDate_dte = '$weekStartDate4' AND status_int = 3 GROUP BY teacher_id) AS t_day4"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day4.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacher_id, CONCAT(tbl_school.name_txt, ': ', IF(dayPart_int = 4, CONCAT(dayPercent_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int))) AS day5Avail_txt, tbl_asn.asn_id AS day5Link_id, dayPart_int AS day5LinkType_int, IFNULL(SUM(dayPercent_dec), 0) AS day5Amount_dec, tbl_asn.school_id AS day5School_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id LEFT JOIN tbl_school ON tbl_asn.school_id = tbl_school.school_id WHERE asnDate_dte = '$weekStartDate5' AND status_int = 3 GROUP BY teacher_id) AS t_day5"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_day5.teacher_id');
                    }
                )
                ->select('tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_teacherDocument.file_location', 'day1Avail_txt', 'day1Link_id', 'day1LinkType_int', 'day1School_id', 'day1Amount_dec', 'day2Avail_txt', 'day2Link_id', 'day2LinkType_int', 'day2School_id', 'day2Amount_dec', 'day3Avail_txt', 'day3Link_id', 'day3LinkType_int', 'day3School_id', 'day3Amount_dec', 'day4Avail_txt', 'day4Link_id', 'day4LinkType_int', 'day4School_id', 'day4Amount_dec', 'day5Avail_txt', 'day5Link_id', 'day5LinkType_int', 'day5School_id', 'day5Amount_dec', DB::raw("CAST((IFNULL(day1Amount_dec, 0) + IFNULL(day2Amount_dec, 0) + IFNULL(day3Amount_dec, 0) + IFNULL(day4Amount_dec, 0) + IFNULL(day5Amount_dec, 0)) AS DECIMAL(3, 1)) AS totalDays"))
                ->whereRaw("(t_day1.teacher_id IS NOT NULL OR t_day2.teacher_id IS NOT NULL OR t_day3.teacher_id IS NOT NULL OR t_day4.teacher_id IS NOT NULL OR t_day5.teacher_id IS NOT NULL)")
                ->where('tbl_teacher.company_id', $company_id)
                ->groupBy('tbl_teacher.teacher_id')
                ->orderBy(DB::raw("IF(knownAs_txt IS NULL OR knownAs_txt = '', CONCAT(firstName_txt, ' ',  IFNULL(surname_txt, '')), CONCAT(firstName_txt, ' (', knownAs_txt, ') ',  IFNULL(surname_txt, '')))"), 'ASC')
                ->orderBy(DB::raw("(day1Amount_dec + day2Amount_dec + day3Amount_dec + day4Amount_dec + day5Amount_dec)"), 'DESC')
                ->get();

            // echo "<pre>";
            // print_r($calenderList);
            // exit;
            return view("web.teacher.teacher_calendar", ['title' => $title, 'headerTitle' => $headerTitle, 'weekStartDate' => $weekStartDate, 'calenderList' => $calenderList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherCalendarList(Request $request)
    {
        $tId = $request->teacher_id;

        $quickList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 4)
            ->where('tbl_description.description_int', '!=', 6)
            ->orderBy('tbl_description.description_int', 'ASC')
            ->get();

        $view = view("web.teacher.view_teacher_calendar", ['teacher_id' => $tId, 'quickList' => $quickList])->render();
        return response()->json(['html' => $view]);
    }

    public function calendarListByTeacher(Request $request, $id)
    {
        if ($request->ajax()) {
            $startDate = $request->start;
            $endDate = $request->end;
            $calEventItem1 = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->leftJoin(
                    DB::raw("(SELECT tbl_teacherCalendar.calendarItem_id, tbl_teacherCalendar.date_dte, tbl_teacherCalendar.part_int, tbl_teacherCalendar.start_tm as tc_start_tm, tbl_teacherCalendar.end_tm as tc_end_tm, tbl_teacherCalendar.reason_int, tbl_teacherCalendar.notes_txt as tc_notes_txt FROM tbl_teacherCalendar WHERE teacher_id = '$id') AS t_tchDates"),
                    function ($join) {
                        $join->on('tbl_asnItem.asnDate_dte', '=', 't_tchDates.date_dte');
                    }
                )
                ->select('tbl_asnItem.asnItem_id', 'calendarItem_id', 'tbl_asnItem.asnDate_dte as start', 'reason_int', DB::raw('IF(reason_int IS NULL, IF((CONCAT("Work: ", tbl_school.name_txt)) IS NULL, "", CONCAT("Work: ", tbl_school.name_txt)), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 4 AND description_int = reason_int)) AS title'), DB::raw('IF(tbl_asn.asn_id IS NULL, 0, 1) AS linkType_int'), DB::raw('IF(tbl_asn.asn_id IS NULL, 0, tbl_asn.asn_id) AS link_id'), 'tc_start_tm', 'tc_end_tm', 'tc_notes_txt')
                ->where('tbl_asn.teacher_id', $id)
                ->where('tbl_asn.status_int', 3)
                ->whereDate('tbl_asnItem.asnDate_dte', '>=', $startDate)
                ->whereDate('tbl_asnItem.asnDate_dte', '<=', $endDate)
                ->groupBy('tbl_asnItem.asnDate_dte')
                ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                ->get()
                ->toArray();

            $calEventItem2 = DB::table('tbl_teacherCalendar')
                ->leftJoin(
                    DB::raw("(SELECT tbl_asn.asn_id, asnDate_dte, CONCAT('Work: ', tbl_school.name_txt) AS reason_txt, tbl_asnItem.asnItem_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id LEFT JOIN tbl_school ON tbl_asn.school_id = tbl_school.school_id WHERE status_int = 3 AND teacher_id = '$id') AS t_tchAsn"),
                    function ($join) {
                        $join->on('tbl_teacherCalendar.date_dte', '=', 't_tchAsn.asnDate_dte');
                    }
                )
                ->select('asnItem_id', 'tbl_teacherCalendar.calendarItem_id', 'date_dte as start', 'reason_int', DB::raw('IF(reason_int IS NULL, IF(reason_txt IS NULL, "", reason_txt), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 4 AND description_int = reason_int)) AS title'), DB::raw('IF(asn_id IS NULL, 0, 1) AS linkType_int'), DB::raw('IF(asn_id IS NULL, 0, asn_id) AS link_id'), 'tbl_teacherCalendar.start_tm as tc_start_tm', 'tbl_teacherCalendar.end_tm as tc_end_tm', 'tbl_teacherCalendar.notes_txt as tc_notes_txt')
                ->where('tbl_teacherCalendar.teacher_id', $id)
                ->whereBetween('tbl_teacherCalendar.date_dte', [$startDate, $endDate])
                ->whereNotIn('tbl_teacherCalendar.date_dte', function ($query) use ($id) {
                    $query->select('asnDate_dte')
                        ->from('tbl_asn')
                        ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->where('status_int', 3)
                        ->where('teacher_id', $id)
                        ->get();
                })
                ->groupBy('tbl_teacherCalendar.date_dte')
                ->orderBy('tbl_teacherCalendar.date_dte', 'ASC')
                ->get()
                ->toArray();
            $calEventItem = array_merge($calEventItem1, $calEventItem2);

            return response()->json($calEventItem);
        }
    }

    public function teacherEventExist(Request $request)
    {
        $startDate = $request->event_start;
        $id = $request->teacher_id;
        $calEventItem = DB::table('tbl_asn')
            ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
            ->leftJoin(
                DB::raw("(SELECT tbl_teacherCalendar.calendarItem_id, tbl_teacherCalendar.date_dte, tbl_teacherCalendar.part_int, tbl_teacherCalendar.start_tm as tc_start_tm, tbl_teacherCalendar.end_tm as tc_end_tm, tbl_teacherCalendar.reason_int, tbl_teacherCalendar.notes_txt as tc_notes_txt FROM tbl_teacherCalendar WHERE teacher_id = '$id') AS t_tchDates"),
                function ($join) {
                    $join->on('tbl_asnItem.asnDate_dte', '=', 't_tchDates.date_dte');
                }
            )
            ->select('tbl_asnItem.asnItem_id', 'calendarItem_id', 'tbl_asnItem.asnDate_dte as start', 'reason_int', DB::raw('IF(reason_int IS NULL, IF((CONCAT("Work: ", tbl_school.name_txt)) IS NULL, "", CONCAT("Work: ", tbl_school.name_txt)), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 4 AND description_int = reason_int)) AS title'), DB::raw('IF(tbl_asn.asn_id IS NULL, 0, 1) AS linkType_int'), DB::raw('IF(tbl_asn.asn_id IS NULL, 0, tbl_asn.asn_id) AS link_id'), 'tc_start_tm', 'tc_end_tm', 'tc_notes_txt')
            ->where('tbl_asn.teacher_id', $id)
            ->where('tbl_asn.status_int', 3)
            ->whereDate('tbl_asnItem.asnDate_dte', '=', $startDate)
            ->groupBy('tbl_asnItem.asnDate_dte')
            ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
            ->first();
        $result['status'] = false;
        $result['date'] = date("D d M Y", strtotime($startDate));
        if ($calEventItem) {
            $result['status'] = true;
            $result['calEventItem'] = $calEventItem;
        } else {
            $calEventItem2 = DB::table('tbl_teacherCalendar')
                ->leftJoin(
                    DB::raw("(SELECT tbl_asn.asn_id, asnDate_dte, CONCAT('Work: ', tbl_school.name_txt) AS reason_txt, tbl_asnItem.asnItem_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id LEFT JOIN tbl_school ON tbl_asn.school_id = tbl_school.school_id WHERE status_int = 3 AND teacher_id = '$id') AS t_tchAsn"),
                    function ($join) {
                        $join->on('tbl_teacherCalendar.date_dte', '=', 't_tchAsn.asnDate_dte');
                    }
                )
                ->select('asnItem_id', 'tbl_teacherCalendar.calendarItem_id', 'date_dte as start', 'reason_int', DB::raw('IF(reason_int IS NULL, IF(reason_txt IS NULL, "", reason_txt), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 4 AND description_int = reason_int)) AS title'), DB::raw('IF(asn_id IS NULL, 0, 1) AS linkType_int'), DB::raw('IF(asn_id IS NULL, 0, asn_id) AS link_id'), 'tbl_teacherCalendar.start_tm as tc_start_tm', 'tbl_teacherCalendar.end_tm as tc_end_tm', 'tbl_teacherCalendar.notes_txt as tc_notes_txt')
                ->where('tbl_teacherCalendar.teacher_id', $id)
                ->whereDate('tbl_teacherCalendar.date_dte', $startDate)
                ->whereNotIn('tbl_teacherCalendar.date_dte', function ($query) use ($id) {
                    $query->select('asnDate_dte')
                        ->from('tbl_asn')
                        ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->where('status_int', 3)
                        ->where('teacher_id', $id)
                        ->get();
                })
                ->groupBy('tbl_teacherCalendar.date_dte')
                ->orderBy('tbl_teacherCalendar.date_dte', 'ASC')
                ->first();
            if ($calEventItem2) {
                $result['status'] = true;
                $result['calEventItem'] = $calEventItem2;
            }
        }
        return response()->json($result);
    }

    public function teacherCalEventAdd(Request $request)
    {
        $startDate = $request->event_start;
        $id = $request->teacher_id;
        $asnItem_id = $request->asnItem_id;
        $calendarItem_id = $request->calendarItem_id;

        if ($calendarItem_id) {
            $calDetails = DB::table('tbl_teacherCalendar')
                ->where('tbl_teacherCalendar.calendarItem_id', $calendarItem_id)
                ->first();
            if ($request->calQuickSet) {
                DB::table('tbl_teacherCalendar')
                    ->where('calendarItem_id', '=', $calendarItem_id)
                    ->delete();
            } else {
                $quickList = DB::table('tbl_description')
                    ->select('tbl_description.*')
                    ->where('tbl_description.descriptionGroup_int', 4)
                    ->where('tbl_description.description_int', '!=', 6)
                    ->orderBy('tbl_description.description_int', 'ASC')
                    ->get();
                $keyNo = 0;
                foreach ($quickList as $key => $value) {
                    if ($calDetails->reason_int == $value->description_int) {
                        $keyNo = $key;
                    }
                }
                $keyInc = $keyNo + 1;
                if (isset($quickList[$keyInc])) {
                    DB::table('tbl_teacherCalendar')
                        ->where('calendarItem_id', '=', $calendarItem_id)
                        ->update([
                            'reason_int' => $quickList[$keyInc]->description_int
                        ]);
                } else {
                    DB::table('tbl_teacherCalendar')
                        ->where('calendarItem_id', '=', $calendarItem_id)
                        ->delete();
                }
            }
        } else {
            $reason_int = 1;
            if ($request->calQuickSet) {
                $reason_int = $request->calQuickSet;
            }
            DB::table('tbl_teacherCalendar')
                ->insertGetId([
                    'teacher_id' => $id,
                    'date_dte' => $startDate,
                    'part_int' => 1,
                    'reason_int' => $reason_int,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);
        }

        return 1;
    }

    public function teacherEventEdit(Request $request)
    {
        $calendarItem_id = $request->calendarItem_id;

        $eventCalDetails = DB::table('tbl_teacherCalendar')
            ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_teacherCalendar.teacher_id')
            ->select('tbl_teacherCalendar.*', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt')
            ->where('tbl_teacherCalendar.calendarItem_id', $calendarItem_id)
            ->first();
        $reasonList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 4)
            ->orderBy('tbl_description.description_int', 'ASC')
            ->get();

        $dayPartList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 20)
            ->get();

        $view = view("web.teacher.edit_teacher_event_view", ['eventCalDetails' => $eventCalDetails, 'reasonList' => $reasonList, 'dayPartList' => $dayPartList])->render();
        return response()->json(['html' => $view]);
    }

    public function teacherEventUpdate(Request $request)
    {
        $calendarItem_id = $request->calendarItem_id;
        $date_dte = $request->date_dte;
        $teacher_id = $request->teacher_id;
        $start_tm = NULL;
        if ($request->start_tm) {
            $start_tm = $request->start_tm;
        }
        $end_tm = NULL;
        if ($request->end_tm) {
            $end_tm = $request->end_tm;
        }

        DB::table('tbl_teacherCalendar')
            ->where('calendarItem_id', '=', $calendarItem_id)
            ->update([
                'part_int' => $request->part_int,
                'start_tm' => $start_tm,
                'end_tm' => $end_tm,
                'reason_int' => $request->reason_int,
                'notes_txt' => $request->notes_txt
            ]);

        if ($request->block_booking && $request->block_booking_dte) {
            $wkArr = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
            if ($request->exclude_weekend) {
                $wkArr = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri');
            }
            $blockStartDate = date("Y-m-d", strtotime($date_dte . ' +1 days'));
            $blockEndDate = date("Y-m-d", strtotime($request->block_booking_dte));

            $period = CarbonPeriod::create($blockStartDate, $blockEndDate);
            foreach ($period as $date) {
                $day = date('D', strtotime($date->format('Y-m-d')));
                if (in_array($day, $wkArr)) {
                    $eventExist = DB::table('tbl_teacherCalendar')
                        ->where('teacher_id', $teacher_id)
                        ->whereDate('date_dte', $date->format('Y-m-d'))
                        ->first();

                    if (!$eventExist) {
                        DB::table('tbl_teacherCalendar')
                            ->insertGetId([
                                'teacher_id' => $teacher_id,
                                'date_dte' => $date->format('Y-m-d'),
                                'part_int' => $request->part_int,
                                'start_tm' => $start_tm,
                                'end_tm' => $end_tm,
                                'reason_int' => $request->reason_int,
                                'notes_txt' => $request->notes_txt,
                                'timestamp_ts' => date('Y-m-d H:i:s')
                            ]);
                    }
                }
            }
        }

        return true;
    }

    public function teacherEventDelete(Request $request)
    {
        $calendarItem_id = $request->calendarItem_id;
        if ($calendarItem_id) {
            DB::table('tbl_teacherCalendar')
                ->where('calendarItem_id', '=', $calendarItem_id)
                ->delete();
        }

        return true;
    }

    public function teacherCalendarById(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Teacher Calendar List");
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
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            if ($request->ajax()) {
                $startDate = $request->start;
                $endDate = $request->end;
                $calEventItem1 = DB::table('tbl_asn')
                    ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                    ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                    ->leftJoin(
                        DB::raw("(SELECT tbl_teacherCalendar.calendarItem_id, tbl_teacherCalendar.date_dte, tbl_teacherCalendar.part_int, tbl_teacherCalendar.start_tm as tc_start_tm, tbl_teacherCalendar.end_tm as tc_end_tm, tbl_teacherCalendar.reason_int, tbl_teacherCalendar.notes_txt as tc_notes_txt FROM tbl_teacherCalendar WHERE teacher_id = '$id') AS t_tchDates"),
                        function ($join) {
                            $join->on('tbl_asnItem.asnDate_dte', '=', 't_tchDates.date_dte');
                        }
                    )
                    ->select('tbl_asnItem.asnItem_id', 'calendarItem_id', 'tbl_asnItem.asnDate_dte as start', 'reason_int', DB::raw('IF(reason_int IS NULL, IF((CONCAT("Work: ", tbl_school.name_txt)) IS NULL, "", CONCAT("Work: ", tbl_school.name_txt)), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 4 AND description_int = reason_int)) AS title'), DB::raw('IF(tbl_asn.asn_id IS NULL, 0, 1) AS linkType_int'), DB::raw('IF(tbl_asn.asn_id IS NULL, 0, tbl_asn.asn_id) AS link_id'), 'tc_start_tm', 'tc_end_tm', 'tc_notes_txt')
                    ->where('tbl_asn.teacher_id', $id)
                    ->where('tbl_asn.status_int', 3)
                    ->whereDate('tbl_asnItem.asnDate_dte', '>=', $startDate)
                    ->whereDate('tbl_asnItem.asnDate_dte', '<=', $endDate)
                    ->groupBy('tbl_asnItem.asnDate_dte')
                    ->orderBy('tbl_asnItem.asnDate_dte', 'ASC')
                    ->get()
                    ->toArray();

                $calEventItem2 = DB::table('tbl_teacherCalendar')
                    ->leftJoin(
                        DB::raw("(SELECT tbl_asn.asn_id, asnDate_dte, CONCAT('Work: ', tbl_school.name_txt) AS reason_txt, tbl_asnItem.asnItem_id FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id LEFT JOIN tbl_school ON tbl_asn.school_id = tbl_school.school_id WHERE status_int = 3 AND teacher_id = '$id') AS t_tchAsn"),
                        function ($join) {
                            $join->on('tbl_teacherCalendar.date_dte', '=', 't_tchAsn.asnDate_dte');
                        }
                    )
                    ->select('asnItem_id', 'tbl_teacherCalendar.calendarItem_id', 'date_dte as start', 'reason_int', DB::raw('IF(reason_int IS NULL, IF(reason_txt IS NULL, "", reason_txt), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 4 AND description_int = reason_int)) AS title'), DB::raw('IF(asn_id IS NULL, 0, 1) AS linkType_int'), DB::raw('IF(asn_id IS NULL, 0, asn_id) AS link_id'), 'tbl_teacherCalendar.start_tm as tc_start_tm', 'tbl_teacherCalendar.end_tm as tc_end_tm', 'tbl_teacherCalendar.notes_txt as tc_notes_txt')
                    ->where('tbl_teacherCalendar.teacher_id', $id)
                    ->whereBetween('tbl_teacherCalendar.date_dte', [$startDate, $endDate])
                    ->whereNotIn('tbl_teacherCalendar.date_dte', function ($query) use ($id) {
                        $query->select('asnDate_dte')
                            ->from('tbl_asn')
                            ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                            ->where('status_int', 3)
                            ->where('teacher_id', $id)
                            ->get();
                    })
                    ->groupBy('tbl_teacherCalendar.date_dte')
                    ->orderBy('tbl_teacherCalendar.date_dte', 'ASC')
                    ->get()
                    ->toArray();
                $calEventItem = array_merge($calEventItem1, $calEventItem2);

                return response()->json($calEventItem);
            }

            $quickList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 4)
                ->where('tbl_description.description_int', '!=', 6)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacher.calendar_by_id", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'quickList' => $quickList, 'teacher_id' => $id, 'headerStatusList' => $headerStatusList]);
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
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
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

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacher.teacher_detail", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'contactItemList' => $contactItemList, 'titleList' => $titleList, 'nationalityList' => $nationalityList, 'ralationshipList' => $ralationshipList, 'contactTypeList' => $contactTypeList, 'headerStatusList' => $headerStatusList]);
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
                    'DOB_dte' => date("Y-m-d", strtotime(str_replace('/', '-', $request->DOB_dte)))
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

            $lat_txt = 0;
            if ($request->lat_txt) {
                $lat_txt = $request->lat_txt;
            }
            $lon_txt = 0;
            if ($request->lon_txt) {
                $lon_txt = $request->lon_txt;
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'address1_txt' => $request->address1_txt,
                    'address2_txt' => $request->address2_txt,
                    'address3_txt' => $request->address3_txt,
                    'address4_txt' => $request->address4_txt,
                    'postcode_txt' => $request->postcode_txt,
                    'lat_txt' => $lat_txt,
                    'lon_txt' => $lon_txt
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
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'interviewer.firstName_txt as int_firstName_txt', 'interviewer.surname_txt as int_surname_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
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

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacher.teacher_profession", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'teacherSubjects' => $teacherSubjects, 'teacherQualifications' => $teacherQualifications, 'candidateList' => $candidateList, 'agerangeList' => $agerangeList, 'interviewQualityList' => $interviewQualityList, 'languageSkillList' => $languageSkillList, 'subjectList' => $subjectList, 'typeList' => $typeList, 'subTypeList' => $subTypeList, 'headerStatusList' => $headerStatusList]);
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
                $NQTCompleted_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->NQTCompleted_dte)));
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
                $interviewCompletedOn_dtm = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $request->interviewCompletedOn_dtm)));
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
                $qualified_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->qualified_dte)));
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
                $qualified_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->qualified_dte)));
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
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacher.teacher_health", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'headerStatusList' => $headerStatusList]);
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
                $healthDeclaration_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->healthDeclaration_dte)));
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
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
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

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacher.references", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'referenceList' => $referenceList, 'referenceTypeList' => $referenceTypeList, 'headerStatusList' => $headerStatusList]);
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
                $employedFrom_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->employedFrom_dte)));
            }
            $employedUntil_dte = NULL;
            if ($request->employedUntil_dte != '') {
                $employedUntil_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->employedUntil_dte)));
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
                $employedFrom_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->employedFrom_dte)));
            }
            $employedUntil_dte = NULL;
            if ($request->employedUntil_dte != '') {
                $employedUntil_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->employedUntil_dte)));
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
        $rateList = DB::table('tbl_referenceLookupValue')
            ->select('tbl_referenceLookupValue.*')
            ->where('tbl_referenceLookupValue.valueGroup_id', 2)
            ->orderBy('tbl_referenceLookupValue.value_int', 'DESC')
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
                ->leftJoin('tbl_teacherReferenceQuestion', function ($join) use ($teacherReferenceId) {
                    $join->on('tbl_teacherReferenceQuestion.question_id', '=', 'tbl_referenceQuestion.question_id')
                        ->where(function ($query) use ($teacherReferenceId) {
                            $query->where('tbl_teacherReferenceQuestion.teacherReference_id', '=', $teacherReferenceId);
                        });
                })
                ->select('tbl_referenceTypeQuestion.*', 'tbl_referenceQuestion.questionType_int', 'tbl_referenceQuestion.question_txt', 'tbl_referenceQuestion.isCurrent_status', 'tbl_referenceQuestion.referenceLookupGroup_id', 'tbl_teacherReferenceQuestion.answer_txt as det_answer_txt', 'tbl_teacherReferenceQuestion.answer_int as det_answer_int', 'tbl_teacherReferenceQuestion.answer_ysn as det_answer_ysn')
                ->where('tbl_referenceTypeQuestion.referenceType_id', $Detail->referenceType_id)
                ->get();
        }

        $optQnList =  array();
        if ($Detail && $Detail->referenceType_id) {
            $optQnList = DB::table('tbl_referenceTypeQuestion')
                ->join('tbl_referenceQuestion', function ($join) {
                    $join->on('tbl_referenceTypeQuestion.question_id', '=', 'tbl_referenceQuestion.question_id')
                        ->where(function ($query) {
                            $query->where('tbl_referenceQuestion.questionType_int', '=', 2);
                        });
                })
                ->leftJoin('tbl_teacherReferenceQuestion', function ($join) use ($teacherReferenceId) {
                    $join->on('tbl_teacherReferenceQuestion.question_id', '=', 'tbl_referenceQuestion.question_id')
                        ->where(function ($query) use ($teacherReferenceId) {
                            $query->where('tbl_teacherReferenceQuestion.teacherReference_id', '=', $teacherReferenceId);
                        });
                })
                ->select('tbl_referenceTypeQuestion.*', 'tbl_referenceQuestion.questionType_int', 'tbl_referenceQuestion.question_txt', 'tbl_referenceQuestion.isCurrent_status', 'tbl_referenceQuestion.referenceLookupGroup_id', 'tbl_teacherReferenceQuestion.answer_txt as det_answer_txt', 'tbl_teacherReferenceQuestion.answer_int as det_answer_int', 'tbl_teacherReferenceQuestion.answer_ysn as det_answer_ysn')
                ->where('tbl_referenceTypeQuestion.referenceType_id', $Detail->referenceType_id)
                ->get();
        }

        $yesNoQnList =  array();
        if ($Detail && $Detail->referenceType_id) {
            $yesNoQnList = DB::table('tbl_referenceTypeQuestion')
                ->join('tbl_referenceQuestion', function ($join) {
                    $join->on('tbl_referenceTypeQuestion.question_id', '=', 'tbl_referenceQuestion.question_id')
                        ->where(function ($query) {
                            $query->where('tbl_referenceQuestion.questionType_int', '=', 3);
                        });
                })
                ->leftJoin('tbl_teacherReferenceQuestion', function ($join) use ($teacherReferenceId) {
                    $join->on('tbl_teacherReferenceQuestion.question_id', '=', 'tbl_referenceQuestion.question_id')
                        ->where(function ($query) use ($teacherReferenceId) {
                            $query->where('tbl_teacherReferenceQuestion.teacherReference_id', '=', $teacherReferenceId);
                        });
                })
                ->select('tbl_referenceTypeQuestion.*', 'tbl_referenceQuestion.questionType_int', 'tbl_referenceQuestion.question_txt', 'tbl_referenceQuestion.isCurrent_status', 'tbl_referenceQuestion.referenceLookupGroup_id', 'tbl_teacherReferenceQuestion.answer_txt as det_answer_txt', 'tbl_teacherReferenceQuestion.answer_int as det_answer_int', 'tbl_teacherReferenceQuestion.answer_ysn as det_answer_ysn')
                ->where('tbl_referenceTypeQuestion.referenceType_id', $Detail->referenceType_id)
                ->get();
        }

        $view = view("web.teacher.edit_receive_reference_view", ['Detail' => $Detail, 'feedbackList' => $feedbackList, 'rateList' => $rateList, 'textQnList' => $textQnList, 'optQnList' => $optQnList, 'yesNoQnList' => $yesNoQnList])->render();
        return response()->json(['html' => $view]);
    }

    public function receiveReferenceUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $teacherReference_id = $request->teacherReference_id;
            $validator = Validator::make($request->all(), [
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
            $isValid_status = 0;
            if ($request->prev_receivedOn_dtm == NULL || $request->prev_receivedOn_dtm == '') {
                $receivedOn_dtm = date("Y-m-d H:i:s");
            } else {
                $receivedOn_dtm = $request->prev_receivedOn_dtm;
            }
            if ($request->isValid_status) {
                $isValid_status = -1;
                if ($request->prev_receivedOn_dtm == NULL || $request->prev_receivedOn_dtm == '') {
                    $receivedOn_dtm = date("Y-m-d H:i:s");
                }
            }
            $verbalReference_status = 0;
            if ($request->verbalReference_status) {
                $verbalReference_status = -1;
            }

            DB::table('tbl_teacherReference')
                ->where('teacherReference_id', $teacherReference_id)
                ->update([
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
                    'isValid_status' => $isValid_status,
                    'verbalReference_status' => $verbalReference_status,
                    'feedbackQuality_int' => $request->feedbackQuality_int,
                    'receivedOn_dtm' => $receivedOn_dtm,
                    'receivedBy_int' => $user_id,
                    // 'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            if (count($request->textQn_qnId)) {
                foreach ($request->textQn_qnId as $key => $textQn_qnId) {
                    $name_qnTxt = 'textQn_qnTxt_' . $textQn_qnId;
                    $name_qnType = 'textQn_qnType_' . $textQn_qnId;
                    $name_answer = 'textQn_answer_' . $textQn_qnId;
                    $qnExist = DB::table('tbl_teacherReferenceQuestion')
                        ->where('teacherReference_id', "=", $teacherReference_id)
                        ->where('question_id', "=", $textQn_qnId)
                        ->first();
                    if ($qnExist) {
                        DB::table('tbl_teacherReferenceQuestion')
                            ->where('teacherReferenceQuestion_id', $qnExist->teacherReferenceQuestion_id)
                            ->update([
                                'question_txt' => $request->$name_qnTxt,
                                'type_int' => $request->$name_qnType,
                                'answer_txt' => $request->$name_answer,
                                'answer_dte' => date('Y-m-d H:i:s')
                            ]);
                    } else {
                        DB::table('tbl_teacherReferenceQuestion')
                            ->insert([
                                'teacherReference_id' => $teacherReference_id,
                                'question_id' => $textQn_qnId,
                                'question_txt' => $request->$name_qnTxt,
                                'type_int' => $request->$name_qnType,
                                'answer_txt' => $request->$name_answer,
                                'answer_dte' => date('Y-m-d H:i:s'),
                                'timestamp_ts' => date('Y-m-d H:i:s')
                            ]);
                    }
                }
            }

            if (count($request->optQn_qnId)) {
                foreach ($request->optQn_qnId as $key1 => $optQn_qnId) {
                    $name_qnTxt = 'optQn_qnTxt_' . $optQn_qnId;
                    $name_qnType = 'optQn_qnType_' . $optQn_qnId;
                    $name_answer = 'optQn_answer_' . $optQn_qnId;
                    $name_rateVal = 'optQn_rateVal_' . $optQn_qnId;
                    $answer_int = NULL;
                    if ($request->$name_rateVal) {
                        $answer_int = $request->$name_rateVal;
                    }
                    $qnExist = DB::table('tbl_teacherReferenceQuestion')
                        ->where('teacherReference_id', "=", $teacherReference_id)
                        ->where('question_id', "=", $optQn_qnId)
                        ->first();
                    if ($qnExist) {
                        DB::table('tbl_teacherReferenceQuestion')
                            ->where('teacherReferenceQuestion_id', $qnExist->teacherReferenceQuestion_id)
                            ->update([
                                'question_txt' => $request->$name_qnTxt,
                                'type_int' => $request->$name_qnType,
                                'answer_int' => $answer_int,
                                'answer_txt' => $request->$name_answer,
                                'answer_dte' => date('Y-m-d H:i:s')
                            ]);
                    } else {
                        DB::table('tbl_teacherReferenceQuestion')
                            ->insert([
                                'teacherReference_id' => $teacherReference_id,
                                'question_id' => $optQn_qnId,
                                'question_txt' => $request->$name_qnTxt,
                                'type_int' => $request->$name_qnType,
                                'answer_int' => $answer_int,
                                'answer_txt' => $request->$name_answer,
                                'answer_dte' => date('Y-m-d H:i:s'),
                                'timestamp_ts' => date('Y-m-d H:i:s')
                            ]);
                    }
                }
            }

            if (count($request->yesNoQn_qnId)) {
                foreach ($request->yesNoQn_qnId as $key2 => $yesNoQn_qnId) {
                    $name_qnTxt = 'yesNoQn_qnTxt_' . $yesNoQn_qnId;
                    $name_qnType = 'yesNoQn_qnType_' . $yesNoQn_qnId;
                    $name_answer = 'yesNoQn_answer_' . $yesNoQn_qnId;
                    $name_yesNo = 'yesNoQn_yesno_' . $yesNoQn_qnId;
                    $answer_ysn = NULL;
                    if ($request->$name_yesNo && $request->$name_yesNo == 1) {
                        $answer_ysn = '1';
                    }
                    if ($request->$name_yesNo && $request->$name_yesNo == 2) {
                        $answer_ysn = '0';
                    }
                    $qnExist = DB::table('tbl_teacherReferenceQuestion')
                        ->where('teacherReference_id', "=", $teacherReference_id)
                        ->where('question_id', "=", $yesNoQn_qnId)
                        ->first();
                    if ($qnExist) {
                        DB::table('tbl_teacherReferenceQuestion')
                            ->where('teacherReferenceQuestion_id', $qnExist->teacherReferenceQuestion_id)
                            ->update([
                                'question_txt' => $request->$name_qnTxt,
                                'type_int' => $request->$name_qnType,
                                'answer_ysn' => $answer_ysn,
                                'answer_txt' => $request->$name_answer,
                                'answer_dte' => date('Y-m-d H:i:s')
                            ]);
                    } else {
                        DB::table('tbl_teacherReferenceQuestion')
                            ->insert([
                                'teacherReference_id' => $teacherReference_id,
                                'question_id' => $yesNoQn_qnId,
                                'question_txt' => $request->$name_qnTxt,
                                'type_int' => $request->$name_qnType,
                                'answer_ysn' => $answer_ysn,
                                'answer_txt' => $request->$name_answer,
                                'answer_dte' => date('Y-m-d H:i:s'),
                                'timestamp_ts' => date('Y-m-d H:i:s')
                            ]);
                    }
                }
            }

            return redirect()->back()->with('success', "Teacher reference updated successfully.");
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
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
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
                // ->where('tbl_description.description_int', '!=', 1)
                ->get();

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();


            return view("web.teacher.teacher_documents", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'RTW_list' => $RTW_list, 'DBS_list' => $DBS_list, 'documentList' => $documentList, 'typeList' => $typeList, 'headerStatusList' => $headerStatusList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherDocumentFetch(Request $request)
    {
        $filePath = '';
        $det = DB::table('tbl_teacherDocument')
            ->where('teacherDocument_id', $request->teacherDocument_id)
            ->first();
        if ($det && $det->file_location) {
            $filePath = asset($det->file_location);
        }
        return response()->json($filePath);
    }

    public function teacherDocumentMail(Request $request)
    {
        $documentId = $request->input('DocumentId');
        $attachments = [];

        $docIds = explode(",", $documentId);
        foreach ($docIds as $key => $value) {
            $det = DB::table('tbl_teacherDocument')
                ->where('teacherDocument_id', $value)
                ->first();
            if ($det && $det->file_location) {
                $filePath = asset($det->file_location);
                array_push($attachments, $filePath);
            }
        }

        return response()->json($attachments);
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
                $vetUpdateServiceReg_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->vetUpdateServiceReg_dte)));
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
                $DBSDate_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->DBSDate_dte)));
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
                $DBSDate_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->DBSDate_dte)));
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
            $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'txt');
            if ($image = $request->file('file')) {
                $extension = $image->getClientOriginalExtension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "_" . $file_name;
                    if ($image->move(public_path('images/teacher'), $name)) {
                        $fPath = 'images/teacher/' . $name;
                        $fType = $extension;
                    }
                } else {
                    return redirect()->back()->with('error', "Please upload valid file.");
                }
            } else {
                return redirect()->back()->with('error', "Please upload valid file.");
            }

            $profilePicExist = DB::table('tbl_teacherDocument')
                ->select('tbl_teacherDocument.*')
                ->where('teacher_id', $teacher_id)
                ->where('type_int', 1)
                ->orderBy('teacherDocument_id', 'DESC')
                ->first();

            if ($request->type_int == 1 && $profilePicExist) {
                DB::table('tbl_teacherDocument')
                    ->where('teacherDocument_id', '=', $profilePicExist->teacherDocument_id)
                    ->update([
                        'file_location' => $fPath,
                        'file_name' => $request->file_name,
                        'file_type' => $fType,
                        'uploadOn_dtm' => date('Y-m-d H:i:s')
                    ]);
            } else {
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
            }

            if ($fPath) {
                $eData = array();
                if ($request->type_int == 3) {
                    $eData['docPassport_status'] = -1;
                }
                if ($request->type_int == 4) {
                    $eData['docDriversLicence_status'] = -1;
                }
                if ($request->type_int == 5) {
                    $eData['docBankStatement_status'] = -1;
                }
                if ($request->type_int == 6) {
                    $eData['docDBS_status'] = -1;
                }
                if ($request->type_int == 8) {
                    $eData['docDisqualForm_status'] = -1;
                }
                if ($request->type_int == 9) {
                    $eData['docHealthDec_status'] = -1;
                }
                if ($request->type_int == 10) {
                    $eData['docEUCard_status'] = -1;
                }
                if ($request->type_int == 11) {
                    $eData['docUtilityBill_status'] = -1;
                }
                if ($request->type_int == 12) {
                    $eData['docTelephoneBill_status'] = -1;
                }
                if ($request->type_int == 13) {
                    $eData['docBenefitStatement_status'] = -1;
                }
                if ($request->type_int == 14) {
                    $eData['docCreditCardBill_status'] = -1;
                }
                if ($request->type_int == 15 || $request->type_int == 17) {
                    $eData['docP45P60_status'] = -1;
                }
                if ($request->type_int == 16) {
                    $eData['docCouncilTax_status'] = -1;
                }

                if ($eData) {
                    DB::table('tbl_teacher')
                        ->where('teacher_id', '=', $teacher_id)
                        ->update($eData);
                }
            }

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
            // ->where('tbl_description.description_int', '!=', 1)
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
            $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'txt');
            if ($image = $request->file('file')) {
                $extension = $image->getClientOriginalExtension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "_" . $file_name;
                    if ($image->move(public_path('images/teacher'), $name)) {
                        $fPath = 'images/teacher/' . $name;
                        $fType = $extension;
                        if (file_exists($file_location)) {
                            unlink($file_location);
                        }
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

            if ($fPath) {
                $eData = array();
                if ($request->type_int == 3) {
                    $eData['docPassport_status'] = -1;
                }
                if ($request->type_int == 4) {
                    $eData['docDriversLicence_status'] = -1;
                }
                if ($request->type_int == 5) {
                    $eData['docBankStatement_status'] = -1;
                }
                if ($request->type_int == 6) {
                    $eData['docDBS_status'] = -1;
                }
                if ($request->type_int == 8) {
                    $eData['docDisqualForm_status'] = -1;
                }
                if ($request->type_int == 9) {
                    $eData['docHealthDec_status'] = -1;
                }
                if ($request->type_int == 10) {
                    $eData['docEUCard_status'] = -1;
                }
                if ($request->type_int == 11) {
                    $eData['docUtilityBill_status'] = -1;
                }
                if ($request->type_int == 12) {
                    $eData['docTelephoneBill_status'] = -1;
                }
                if ($request->type_int == 13) {
                    $eData['docBenefitStatement_status'] = -1;
                }
                if ($request->type_int == 14) {
                    $eData['docCreditCardBill_status'] = -1;
                }
                if ($request->type_int == 15 || $request->type_int == 17) {
                    $eData['docP45P60_status'] = -1;
                }
                if ($request->type_int == 16) {
                    $eData['docCouncilTax_status'] = -1;
                }

                if ($eData) {
                    DB::table('tbl_teacher')
                        ->where('teacher_id', '=', $teacher_id)
                        ->update($eData);
                }
            }

            return redirect()->back()->with('success', "Document updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function teacherDocumentDelete(Request $request)
    {
        $DocumentId = $request->DocumentId;
        $docIds = explode(",", $DocumentId);
        foreach ($docIds as $key => $value) {
            $docDetail = DB::table('tbl_teacherDocument')
                ->where('teacherDocument_id', "=", $value)
                ->first();
            if ($docDetail) {
                DB::table('tbl_teacherDocument')
                    ->where('teacherDocument_id', "=", $value)
                    ->delete();

                if (file_exists($docDetail->file_location)) {
                    unlink($docDetail->file_location);
                }

                $eData = array();
                if ($docDetail->type_int == 3) {
                    $eData['docPassport_status'] = 0;
                }
                if ($docDetail->type_int == 4) {
                    $eData['docDriversLicence_status'] = 0;
                }
                if ($docDetail->type_int == 5) {
                    $eData['docBankStatement_status'] = 0;
                }
                if ($docDetail->type_int == 6) {
                    $eData['docDBS_status'] = 0;
                }
                if ($docDetail->type_int == 8) {
                    $eData['docDisqualForm_status'] = 0;
                }
                if ($docDetail->type_int == 9) {
                    $eData['docHealthDec_status'] = 0;
                }
                if ($docDetail->type_int == 10) {
                    $eData['docEUCard_status'] = 0;
                }
                if ($docDetail->type_int == 11) {
                    $eData['docUtilityBill_status'] = 0;
                }
                if ($docDetail->type_int == 12) {
                    $eData['docTelephoneBill_status'] = 0;
                }
                if ($docDetail->type_int == 13) {
                    $eData['docBenefitStatement_status'] = 0;
                }
                if ($docDetail->type_int == 14) {
                    $eData['docCreditCardBill_status'] = 0;
                }
                if ($docDetail->type_int == 15 || $docDetail->type_int == 17) {
                    $eData['docP45P60_status'] = 0;
                }
                if ($docDetail->type_int == 16) {
                    $eData['docCouncilTax_status'] = 0;
                }

                if ($eData) {
                    DB::table('tbl_teacher')
                        ->where('teacher_id', '=', $docDetail->teacher_id)
                        ->update($eData);
                }
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
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
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

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacher.teacher_contact_log", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'teacherContactLogs' => $teacherContactLogs, 'methodList' => $methodList, 'quickSettingList' => $quickSettingList, 'headerStatusList' => $headerStatusList]);
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
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $bankList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 36)
                ->get();

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacher.teacher_payroll", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'bankList' => $bankList, 'headerStatusList' => $headerStatusList]);
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

    public function teacherFabAdd(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;
            $fabExit = DB::table('tbl_userFavourite')
                ->where('link_id', $teacher_id)
                ->where('type_int', 1)
                ->first();
            if ($fabExit) {
                DB::table('tbl_userFavourite')
                    ->where('favourite_id', $fabExit->favourite_id)
                    ->delete();
            } else {
                DB::table('tbl_userFavourite')
                    ->insert([
                        'user_id' => $user_id,
                        'link_id' => $teacher_id,
                        'type_int' => 1
                    ]);
            }
            return true;
        } else {
            return false;
        }
    }

    public function teacherHeaderStatusUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $teacher_id = $request->teacher_id;

            $validator = Validator::make($request->all(), [
                'applicationStatus_int' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'applicationStatus_int' => $request->applicationStatus_int
                ]);

            return redirect()->back()->with('success', "Details updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    /********* Teacher Portal *********/
    public function teacherSetPassword(Request $request, $id)
    {
        $teacher_id = base64_decode($id);
        $teacherDetail = DB::table('tbl_teacher')
            ->select('tbl_teacher.*')
            ->where('teacher_id', $teacher_id)
            ->first();
        $companyDetail = array();
        if ($teacherDetail) {
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $teacherDetail->company_id)
                ->get();
        }

        return view("web.teacherPortal.set_password", ['teacher_id' => $teacher_id, 'teacherDetail' => $teacherDetail, 'companyDetail' => $companyDetail]);
    }

    public function teacherPasswordUpdate(Request $request)
    {
        if ($request->password != $request->confirm_password) {
            return redirect()->back()->with('error', "Password and confirm password not match.");
        } else {
            $teacher_id = $request->teacher_id;
            DB::table('tbl_teacher')
                ->where('teacher_id', '=', $teacher_id)
                ->update([
                    'password' => Hash::make($request->password)
                ]);
            return redirect()->intended('/teacher');
        }
    }

    public function teacherLogin(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            return redirect()->intended('/teacher/detail');
        } else {
            $title = array('pageTitle' => "Teacher Login");
            return view("web.teacherPortal.teacher_login", ['title' => $title]);
        }
    }

    public function teacherProcessLogin(Request $request)
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
            $user_exist = DB::table('tbl_teacher')
                ->LeftJoin('company', 'company.company_id', '=', 'tbl_teacher.company_id')
                ->select('tbl_teacher.*', 'company.company_name', 'company.company_logo')
                ->where('tbl_teacher.login_mail', $request->user_name)
                ->get();
            if (count($user_exist) > 0) {
                if (!Hash::check($request->password, $user_exist[0]->password)) {
                    return redirect()->back()->withInput()->with('loginError', "Wrong password.");
                } else {
                    if ($user_exist[0]->activeStatus != 1) {
                        return redirect()->back()->withInput()->with('loginError', "You are not an active user.");
                    } else {
                        Session::put('teacherLoginData', $user_exist[0]);
                        return redirect()->intended('/teacher/detail');
                    }
                }
            } else {
                return redirect()->back()->withInput()->with('loginError', "Wrong user name.");
            }
        }
    }

    public function teacherLogout()
    {
        Session::forget('teacherLoginData');
        return redirect('/teacher');
    }

    public function logTeacherDetail(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $title = array('pageTitle' => "Teacher Detail");
            $headerTitle = "Teachers";
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            $teacherDetail = DB::table('tbl_teacher')
                ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$teacher_id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $teacher_id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();
            // dd($teacherDetail);
            $contactItemList = DB::table('tbl_contactItemTch')
                ->LeftJoin('tbl_description', function ($join) {
                    $join->on('tbl_description.description_int', '=', 'tbl_contactItemTch.type_int')
                        ->where(function ($query) {
                            $query->where('tbl_description.descriptionGroup_int', '=', 9);
                        });
                })
                ->select('tbl_contactItemTch.*', 'tbl_description.description_txt as type_txt')
                ->where('tbl_contactItemTch.teacher_id', $teacher_id)
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

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacherPortal.teacher_detail", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'contactItemList' => $contactItemList, 'titleList' => $titleList, 'nationalityList' => $nationalityList, 'ralationshipList' => $ralationshipList, 'contactTypeList' => $contactTypeList, 'headerStatusList' => $headerStatusList]);
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherDetailUpdate(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

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
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherAddressUpdate(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

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
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherContactItemInsert(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

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
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherContactItemUpdate(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;
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
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherEmerContactUpdate(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'emergencyContactName_txt' => $request->emergencyContactName_txt,
                    'emergencyContactNum1_txt' => $request->emergencyContactNum1_txt,
                    'emergencyContactNum2_txt' => $request->emergencyContactNum2_txt,
                    'emergencyContactRelation_int' => $request->emergencyContactRelation_int
                ]);

            return redirect()->back()->with('success', "Emergency contact updated successfully.");
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherProfession(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $title = array('pageTitle' => "Teacher Profession");
            $headerTitle = "Teachers";
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            $teacherDetail = DB::table('tbl_teacher')
                ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                ->LeftJoin('tbl_user as interviewer', 'interviewer.user_id', '=', 'tbl_teacher.interviewBy_id')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$teacher_id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'interviewer.firstName_txt as int_firstName_txt', 'interviewer.surname_txt as int_surname_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $teacher_id)
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
                ->where('tbl_teacherSubject.teacher_id', $teacher_id)
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
                ->where('tbl_teacherQualification.teacher_id', $teacher_id)
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

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacherPortal.teacher_profession", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'teacherSubjects' => $teacherSubjects, 'teacherQualifications' => $teacherQualifications, 'candidateList' => $candidateList, 'agerangeList' => $agerangeList, 'interviewQualityList' => $interviewQualityList, 'languageSkillList' => $languageSkillList, 'subjectList' => $subjectList, 'typeList' => $typeList, 'subTypeList' => $subTypeList, 'headerStatusList' => $headerStatusList]);
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherHealth(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $title = array('pageTitle' => "Teacher Health");
            $headerTitle = "Teachers";
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            $teacherDetail = DB::table('tbl_teacher')
                ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$teacher_id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $teacher_id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacherPortal.teacher_health", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'headerStatusList' => $headerStatusList]);
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherPrefUpdate(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;
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
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherHealthUpdate(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;
            $healthDeclaration_dte = NULL;
            if ($request->healthDeclaration_dte != '') {
                $healthDeclaration_dte = date("Y-m-d", strtotime(str_replace('/', '-', $request->healthDeclaration_dte)));
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'healthDeclaration_dte' => $healthDeclaration_dte,
                    'occupationalHealth_txt' => $request->occupationalHealth_txt,
                    'healthIssues_txt' => $request->healthIssues_txt
                ]);

            return redirect()->back()->with('success', "Health updated successfully.");
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherDocuments(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $title = array('pageTitle' => "Teacher Documents");
            $headerTitle = "Teachers";
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            $teacherDetail = DB::table('tbl_teacher')
                ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$teacher_id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $teacher_id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $RTW_list = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 39)
                ->get();

            $DBS_list = DB::table('tbl_teacherdbs')
                ->select('tbl_teacherdbs.*')
                ->where('tbl_teacherdbs.teacher_id', $teacher_id)
                ->get();

            $documentList = DB::table('tbl_teacherDocument')
                ->LeftJoin('tbl_description', function ($join) {
                    $join->on('tbl_description.description_int', '=', 'tbl_teacherDocument.type_int')
                        ->where(function ($query) {
                            $query->where('tbl_description.descriptionGroup_int', '=', 19);
                        });
                })
                ->select('tbl_teacherDocument.*', 'tbl_description.description_txt as doc_type_txt')
                ->where('tbl_teacherDocument.teacher_id', $teacher_id)
                ->where('tbl_teacherDocument.type_int', '!=', 1)
                ->where('tbl_teacherDocument.uploadOn_dtm', '!=', NULL)
                ->orderBy('tbl_teacherDocument.uploadOn_dtm', 'DESC')
                ->get();

            $typeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 19)
                // ->where('tbl_description.description_int', '!=', 1)
                ->get();

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacherPortal.teacher_documents", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'RTW_list' => $RTW_list, 'DBS_list' => $DBS_list, 'documentList' => $documentList, 'typeList' => $typeList, 'headerStatusList' => $headerStatusList]);
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherDocInsert(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            $fPath = '';
            $fType = '';
            $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');
            if ($image = $request->file('file')) {
                $extension = $image->getClientOriginalExtension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "_" . $file_name;
                    if ($image->move('public/images/teacher', $name)) {
                        $fPath = 'public/images/teacher/' . $name;
                        $fType = $extension;
                    }
                } else {
                    return redirect()->back()->with('error', "Please upload valid file.");
                }
            } else {
                return redirect()->back()->with('error', "Please upload valid file.");
            }

            $profilePicExist = DB::table('tbl_teacherDocument')
                ->select('tbl_teacherDocument.*')
                ->where('teacher_id', $teacher_id)
                ->where('type_int', 1)
                ->orderBy('teacherDocument_id', 'DESC')
                ->first();

            if ($request->type_int == 1 && $profilePicExist) {
                DB::table('tbl_teacherDocument')
                    ->where('teacherDocument_id', '=', $profilePicExist->teacherDocument_id)
                    ->update([
                        'file_location' => $fPath,
                        'file_name' => $request->file_name,
                        'file_type' => $fType,
                        'uploadOn_dtm' => date('Y-m-d H:i:s')
                    ]);
            } else {
                DB::table('tbl_teacherDocument')
                    ->insert([
                        'teacher_id' => $teacher_id,
                        'file_location' => $fPath,
                        'file_name' => $request->file_name,
                        'type_int' => $request->type_int,
                        'file_type' => $fType,
                        'uploadOn_dtm' => date('Y-m-d H:i:s'),
                        'loggedOn_dtm' => date('Y-m-d H:i:s'),
                        // 'loggedBy_id' => $user_id,
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);
            }

            if ($fPath) {
                $eData = array();
                if ($request->type_int == 3) {
                    $eData['docPassport_status'] = -1;
                }
                if ($request->type_int == 4) {
                    $eData['docDriversLicence_status'] = -1;
                }
                if ($request->type_int == 5) {
                    $eData['docBankStatement_status'] = -1;
                }
                if ($request->type_int == 6) {
                    $eData['docDBS_status'] = -1;
                }
                if ($request->type_int == 8) {
                    $eData['docDisqualForm_status'] = -1;
                }
                if ($request->type_int == 9) {
                    $eData['docHealthDec_status'] = -1;
                }
                if ($request->type_int == 10) {
                    $eData['docEUCard_status'] = -1;
                }
                if ($request->type_int == 11) {
                    $eData['docUtilityBill_status'] = -1;
                }
                if ($request->type_int == 12) {
                    $eData['docTelephoneBill_status'] = -1;
                }
                if ($request->type_int == 13) {
                    $eData['docBenefitStatement_status'] = -1;
                }
                if ($request->type_int == 14) {
                    $eData['docCreditCardBill_status'] = -1;
                }
                if ($request->type_int == 15 || $request->type_int == 17) {
                    $eData['docP45P60_status'] = -1;
                }
                if ($request->type_int == 16) {
                    $eData['docCouncilTax_status'] = -1;
                }

                if ($eData) {
                    DB::table('tbl_teacher')
                        ->where('teacher_id', '=', $teacher_id)
                        ->update($eData);
                }
            }

            return redirect()->back()->with('success', "Document added successfully.");
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherDocUpdate(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;
            $editDocumentId = $request->editDocumentId;
            $file_location = $request->file_location;

            $fPath = '';
            $fType = '';
            $allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');
            if ($image = $request->file('file')) {
                $extension = $image->getClientOriginalExtension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "_" . $file_name;
                    if ($image->move('public/images/teacher', $name)) {
                        $fPath = 'public/images/teacher/' . $name;
                        $fType = $extension;
                        if (file_exists($file_location)) {
                            unlink($file_location);
                        }
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
                    // 'loggedBy_id' => $user_id
                ]);

            if ($fPath) {
                $eData = array();
                if ($request->type_int == 3) {
                    $eData['docPassport_status'] = -1;
                }
                if ($request->type_int == 4) {
                    $eData['docDriversLicence_status'] = -1;
                }
                if ($request->type_int == 5) {
                    $eData['docBankStatement_status'] = -1;
                }
                if ($request->type_int == 6) {
                    $eData['docDBS_status'] = -1;
                }
                if ($request->type_int == 8) {
                    $eData['docDisqualForm_status'] = -1;
                }
                if ($request->type_int == 9) {
                    $eData['docHealthDec_status'] = -1;
                }
                if ($request->type_int == 10) {
                    $eData['docEUCard_status'] = -1;
                }
                if ($request->type_int == 11) {
                    $eData['docUtilityBill_status'] = -1;
                }
                if ($request->type_int == 12) {
                    $eData['docTelephoneBill_status'] = -1;
                }
                if ($request->type_int == 13) {
                    $eData['docBenefitStatement_status'] = -1;
                }
                if ($request->type_int == 14) {
                    $eData['docCreditCardBill_status'] = -1;
                }
                if ($request->type_int == 15 || $request->type_int == 17) {
                    $eData['docP45P60_status'] = -1;
                }
                if ($request->type_int == 16) {
                    $eData['docCouncilTax_status'] = -1;
                }

                if ($eData) {
                    DB::table('tbl_teacher')
                        ->where('teacher_id', '=', $teacher_id)
                        ->update($eData);
                }
            }

            return redirect()->back()->with('success', "Document updated successfully.");
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherDocDelete(Request $request)
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

            $eData = array();
            if ($docDetail->type_int == 3) {
                $eData['docPassport_status'] = 0;
            }
            if ($docDetail->type_int == 4) {
                $eData['docDriversLicence_status'] = 0;
            }
            if ($docDetail->type_int == 5) {
                $eData['docBankStatement_status'] = 0;
            }
            if ($docDetail->type_int == 6) {
                $eData['docDBS_status'] = 0;
            }
            if ($docDetail->type_int == 8) {
                $eData['docDisqualForm_status'] = 0;
            }
            if ($docDetail->type_int == 9) {
                $eData['docHealthDec_status'] = 0;
            }
            if ($docDetail->type_int == 10) {
                $eData['docEUCard_status'] = 0;
            }
            if ($docDetail->type_int == 11) {
                $eData['docUtilityBill_status'] = 0;
            }
            if ($docDetail->type_int == 12) {
                $eData['docTelephoneBill_status'] = 0;
            }
            if ($docDetail->type_int == 13) {
                $eData['docBenefitStatement_status'] = 0;
            }
            if ($docDetail->type_int == 14) {
                $eData['docCreditCardBill_status'] = 0;
            }
            if ($docDetail->type_int == 15 || $docDetail->type_int == 17) {
                $eData['docP45P60_status'] = 0;
            }
            if ($docDetail->type_int == 16) {
                $eData['docCouncilTax_status'] = 0;
            }

            if ($eData) {
                DB::table('tbl_teacher')
                    ->where('teacher_id', '=', $docDetail->teacher_id)
                    ->update($eData);
            }
        }
        return 1;
    }

    public function logTeacherPayroll(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $title = array('pageTitle' => "Teacher Payroll");
            $headerTitle = "Teachers";
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            $teacherDetail = DB::table('tbl_teacher')
                ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$teacher_id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $teacher_id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $bankList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 36)
                ->get();

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacherPortal.teacher_payroll", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'bankList' => $bankList, 'headerStatusList' => $headerStatusList]);
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherPayrollUpdate(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;
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
                    // 'RACSnumber_txt' => $request->RACSnumber_txt
                ]);

            return redirect()->back()->with('success', "Bank/Payroll updated successfully.");
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherProfilePicAdd(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            $fPath = '';
            $fType = '';
            $allowed_types = array('jpg', 'png', 'jpeg');
            if ($image = $request->file('file')) {
                $extension = $image->getClientOriginalExtension();
                $file_name = $image->getClientOriginalName();
                if (in_array(strtolower($extension), $allowed_types)) {
                    $rand = mt_rand(100000, 999999);
                    $name = time() . "_" . $rand . "_" . $file_name;
                    if ($image->move('public/images/teacher', $name)) {
                        $fPath = 'public/images/teacher/' . $name;
                        $fType = $extension;
                    }
                } else {
                    return redirect()->back()->with('error', "Please upload valid file.");
                }
            } else {
                return redirect()->back()->with('error', "Please upload valid file.");
            }

            if ($request->teacherDocument_id) {
                $docDetail = DB::table('tbl_teacherDocument')
                    ->where('teacherDocument_id', "=", $request->teacherDocument_id)
                    ->first();
                if ($docDetail) {
                    DB::table('tbl_teacherDocument')
                        ->where('teacherDocument_id', '=', $request->teacherDocument_id)
                        ->update([
                            'file_location' => $fPath,
                            'file_type' => $fType,
                            'uploadOn_dtm' => date('Y-m-d H:i:s')
                        ]);
                } else {
                    DB::table('tbl_teacherDocument')
                        ->insert([
                            'teacher_id' => $teacher_id,
                            'file_location' => $fPath,
                            'file_name' => 'Profile Image',
                            'type_int' => 1,
                            'file_type' => $fType,
                            'uploadOn_dtm' => date('Y-m-d H:i:s'),
                            'loggedOn_dtm' => date('Y-m-d H:i:s'),
                            // 'loggedBy_id' => $user_id,
                            'timestamp_ts' => date('Y-m-d H:i:s')
                        ]);
                }
            } else {
                DB::table('tbl_teacherDocument')
                    ->insert([
                        'teacher_id' => $teacher_id,
                        'file_location' => $fPath,
                        'file_name' => 'Profile Image',
                        'type_int' => 1,
                        'file_type' => $fType,
                        'uploadOn_dtm' => date('Y-m-d H:i:s'),
                        'loggedOn_dtm' => date('Y-m-d H:i:s'),
                        // 'loggedBy_id' => $user_id,
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);
            }

            return redirect()->back()->with('success', "Profile image added successfully.");
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherProfilePicDelete(Request $request)
    {
        if ($request->teacherDocument_id) {
            DB::table('tbl_teacherDocument')
                ->where('teacherDocument_id', "=", $request->teacherDocument_id)
                ->delete();
        }
        return true;
    }

    public function logTeacherTimesheet(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $title = array('pageTitle' => "Teacher Timesheet");
            $headerTitle = "Teachers";
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            $teacherDetail = DB::table('tbl_teacher')
                ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$teacher_id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $teacher_id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            if ($request->date) {
                $weekStartDate = Carbon::parse($request->date)->startOfWeek()->format('Y-m-d');
                $weekEndDate = Carbon::parse($weekStartDate)->endOfWeek()->format('Y-m-d');
            } else {
                $now = Carbon::now();
                $weekStartDate = $now->startOfWeek()->format('Y-m-d');
                $weekEndDate = Carbon::parse($weekStartDate)->endOfWeek()->format('Y-m-d');
            }
            // $now = Carbon::now();
            // $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            // $weekStartDate = '2023-02-06';
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $weekStartDate2 = date('Y-m-d', strtotime($weekStartDate . ' +1 days'));
            $weekStartDate3 = date('Y-m-d', strtotime($weekStartDate . ' +2 days'));
            $weekStartDate4 = date('Y-m-d', strtotime($weekStartDate . ' +3 days'));
            $weekStartDate5 = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $calenderList = array();

            $calenderList1 = DB::table('teacher_timesheet')
                ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('teacher_timesheet_item as tbl_asnItem1', function ($join) use ($weekStartDate) {
                    $join->on('tbl_asnItem1.teacher_timesheet_id', '=', 'teacher_timesheet.teacher_timesheet_id')
                        ->where(function ($query) use ($weekStartDate) {
                            $query->where('tbl_asnItem1.asnDate_dte', '=', $weekStartDate);
                        });
                })
                ->LeftJoin('teacher_timesheet_item as tbl_asnItem2', function ($join) use ($weekStartDate2) {
                    $join->on('tbl_asnItem2.teacher_timesheet_id', '=', 'teacher_timesheet.teacher_timesheet_id')
                        ->where(function ($query) use ($weekStartDate2) {
                            $query->where('tbl_asnItem2.asnDate_dte', '=', $weekStartDate2);
                        });
                })
                ->LeftJoin('teacher_timesheet_item as tbl_asnItem3', function ($join) use ($weekStartDate3) {
                    $join->on('tbl_asnItem3.teacher_timesheet_id', '=', 'teacher_timesheet.teacher_timesheet_id')
                        ->where(function ($query) use ($weekStartDate3) {
                            $query->where('tbl_asnItem3.asnDate_dte', '=', $weekStartDate3);
                        });
                })
                ->LeftJoin('teacher_timesheet_item as tbl_asnItem4', function ($join) use ($weekStartDate4) {
                    $join->on('tbl_asnItem4.teacher_timesheet_id', '=', 'teacher_timesheet.teacher_timesheet_id')
                        ->where(function ($query) use ($weekStartDate4) {
                            $query->where('tbl_asnItem4.asnDate_dte', '=', $weekStartDate4);
                        });
                })
                ->LeftJoin('teacher_timesheet_item as tbl_asnItem5', function ($join) use ($weekStartDate5) {
                    $join->on('tbl_asnItem5.teacher_timesheet_id', '=', 'teacher_timesheet.teacher_timesheet_id')
                        ->where(function ($query) use ($weekStartDate5) {
                            $query->where('tbl_asnItem5.asnDate_dte', '=', $weekStartDate5);
                        });
                })
                ->select('teacher_timesheet.teacher_timesheet_id', 'teacher_timesheet.asn_id', 'teacher_timesheet.school_id', 'tbl_school.name_txt', DB::raw("'$teacher_id' AS teacher_id"), 'teacher_timesheet.timesheet_status', 'teacher_timesheet.submit_status', 'teacher_timesheet.approve_by_school', 'teacher_timesheet.reject_status', 'tbl_asnItem1.timesheet_item_id AS timesheet_item_id1', 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asnItem1.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asnItem1.school_id AS day1school_id', DB::raw("IF(tbl_asnItem1.dayPart_int = 4, CONCAT(tbl_asnItem1.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem1.dayPart_int)) AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem2.timesheet_item_id AS timesheet_item_id2', 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asnItem2.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asnItem2.school_id AS day2school_id', DB::raw("IF(tbl_asnItem2.dayPart_int = 4, CONCAT(tbl_asnItem2.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem2.dayPart_int)) AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem3.timesheet_item_id AS timesheet_item_id3', 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asnItem3.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asnItem3.school_id AS day3school_id', DB::raw("IF(tbl_asnItem3.dayPart_int = 4, CONCAT(tbl_asnItem3.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem3.dayPart_int)) AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem4.timesheet_item_id AS timesheet_item_id4', 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asnItem4.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asnItem4.school_id AS day4school_id', DB::raw("IF(tbl_asnItem4.dayPart_int = 4, CONCAT(tbl_asnItem4.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem4.dayPart_int)) AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem5.timesheet_item_id AS timesheet_item_id5', 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asnItem5.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asnItem5.school_id AS day5school_id', DB::raw("IF(tbl_asnItem5.dayPart_int = 4, CONCAT(tbl_asnItem5.hours_dec, ' Hours'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = tbl_asnItem5.dayPart_int)) AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"))
                ->whereDate('teacher_timesheet.start_date', '=', $weekStartDate)
                ->whereDate('teacher_timesheet.end_date', '=', $weekEndDate)
                ->where('teacher_timesheet.teacher_id', $teacher_id)
                ->where('teacher_timesheet.timesheet_status', '!=', 1)
                ->groupBy('teacher_timesheet.teacher_timesheet_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();

            $calenderList2 = DB::table('tbl_asn')
                ->LeftJoin('tbl_school', 'tbl_asn.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'tbl_asn.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->LeftJoin('tbl_asnItem as tbl_asnItem1', function ($join) use ($weekStartDate) {
                    $join->on('tbl_asnItem1.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate) {
                            $query->where(
                                'tbl_asnItem1.timesheet_id',
                                NULL
                            )
                                ->where('tbl_asnItem1.asnDate_dte', '=', $weekStartDate);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem2', function ($join) use ($weekStartDate2) {
                    $join->on('tbl_asnItem2.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate2) {
                            $query->where(
                                'tbl_asnItem2.timesheet_id',
                                NULL
                            )
                                ->where('tbl_asnItem2.asnDate_dte', '=', $weekStartDate2);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem3', function ($join) use ($weekStartDate3) {
                    $join->on('tbl_asnItem3.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate3) {
                            $query->where(
                                'tbl_asnItem3.timesheet_id',
                                NULL
                            )
                                ->where('tbl_asnItem3.asnDate_dte', '=', $weekStartDate3);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem4', function ($join) use ($weekStartDate4) {
                    $join->on('tbl_asnItem4.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate4) {
                            $query->where(
                                'tbl_asnItem4.timesheet_id',
                                NULL
                            )
                                ->where('tbl_asnItem4.asnDate_dte', '=', $weekStartDate4);
                        });
                })
                ->LeftJoin('tbl_asnItem as tbl_asnItem5', function ($join) use ($weekStartDate5) {
                    $join->on('tbl_asnItem5.asn_id', '=', 'tbl_asn.asn_id')
                        ->where(function ($query) use ($weekStartDate5) {
                            $query->where(
                                'tbl_asnItem5.timesheet_id',
                                NULL
                            )
                                ->where('tbl_asnItem5.asnDate_dte', '=', $weekStartDate5);
                        });
                })
                ->select(DB::raw("NULL AS teacher_timesheet_id"), 'tbl_asn.asn_id', 'tbl_school.school_id', 'tbl_school.name_txt', 'tbl_teacher.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', DB::raw("0 AS timesheet_status"), DB::raw("0 AS submit_status"), DB::raw("0 AS approve_by_school"), DB::raw("0 AS reject_status"), 'tbl_asnItem1.asnItem_id AS day1asnItem_id', 'tbl_asnItem1.asnDate_dte AS day1asnDate_dte', 'tbl_asn.asn_id AS day1Link_id', 'tbl_asnItem1.dayPart_int AS day1LinkType_int', 'tbl_asn.school_id AS day1school_id', DB::raw("NULL AS day1Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem1.dayPercent_dec), 0) AS day1Amount_dec"), 'tbl_asnItem2.asnItem_id AS day2asnItem_id', 'tbl_asnItem2.asnDate_dte AS day2asnDate_dte', 'tbl_asn.asn_id AS day2Link_id', 'tbl_asnItem2.dayPart_int AS day2LinkType_int', 'tbl_asn.school_id AS day2school_id', DB::raw("NULL AS day2Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem2.dayPercent_dec), 0) AS day2Amount_dec"), 'tbl_asnItem3.asnItem_id AS day3asnItem_id', 'tbl_asnItem3.asnDate_dte AS day3asnDate_dte', 'tbl_asn.asn_id AS day3Link_id', 'tbl_asnItem3.dayPart_int AS day3LinkType_int', 'tbl_asn.school_id AS day3school_id', DB::raw("NULL AS day3Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem3.dayPercent_dec), 0) AS day3Amount_dec"), 'tbl_asnItem4.asnItem_id AS day4asnItem_id', 'tbl_asnItem4.asnDate_dte AS day4asnDate_dte', 'tbl_asn.asn_id AS day4Link_id', 'tbl_asnItem4.dayPart_int AS day4LinkType_int', 'tbl_asn.school_id AS day4school_id', DB::raw("NULL AS day4Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem4.dayPercent_dec), 0) AS day4Amount_dec"), 'tbl_asnItem5.asnItem_id AS day5asnItem_id', 'tbl_asnItem5.asnDate_dte AS day5asnDate_dte', 'tbl_asn.asn_id AS day5Link_id', 'tbl_asnItem5.dayPart_int AS day5LinkType_int', 'tbl_asn.school_id AS day5school_id', DB::raw("NULL AS day5Avail_txt"), DB::raw("IFNULL(SUM(tbl_asnItem5.dayPercent_dec), 0) AS day5Amount_dec"), DB::raw("NULL AS timesheet_item_id1"), DB::raw("NULL AS timesheet_item_id2"), DB::raw("NULL AS timesheet_item_id3"), DB::raw("NULL AS timesheet_item_id4"), DB::raw("NULL AS timesheet_item_id5"))
                ->whereIn('tbl_asn.asn_id', function ($query) use ($weekStartDate, $plusFiveDate, $company_id, $teacher_id) {
                    $query->select('tbl_asn.asn_id')
                        ->from('tbl_asn')
                        ->join('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                        ->where('timesheet_id', NULL)
                        ->where('status_int', 3)
                        ->where('teacher_id', '=', $teacher_id)
                        ->whereDate('asnDate_dte', '>=', $weekStartDate)
                        ->whereDate('asnDate_dte', '<=', $plusFiveDate)
                        ->where('company_id', $company_id)
                        ->groupBy('tbl_asn.asn_id')
                        ->get();
                })
                ->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_school.name_txt', 'ASC')
                ->get();

            $timesheetExist = DB::table('teacher_timesheet')
                ->whereDate('teacher_timesheet.start_date', '=', $weekStartDate)
                ->whereDate('teacher_timesheet.end_date', '=', $weekEndDate)
                ->where('teacher_timesheet.teacher_id', $teacher_id)
                ->get();
            if (count($timesheetExist) > 0) {
                // $calenderList = $calenderList1;
                $calenderList = $calenderList2->merge($calenderList1)->keyBy('asn_id');
            } else {
                $calenderList = $calenderList2;
            }
            // echo "<pre>";
            // print_r($calenderList);
            // exit;
            $dayPartList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 20)
                ->get();

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacherPortal.teacher_timesheet", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'weekStartDate' => $weekStartDate, 'calenderList' => $calenderList, 'weekEndDate' => $weekEndDate, 'plusFiveDate' => $plusFiveDate, 'dayPartList' => $dayPartList, 'headerStatusList' => $headerStatusList]);
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function logTeacherTimesheetAdd(Request $request)
    {
        $timesheetExist = DB::table('teacher_timesheet')
            ->where('teacher_timesheet_id', $request->teacher_timesheet_id)
            ->first();
        if ($request->teacher_timesheet_id && $timesheetExist) {
            $teacher_timesheet_id = $request->teacher_timesheet_id;
            DB::table('teacher_timesheet')
                ->where('teacher_timesheet_id', $teacher_timesheet_id)
                ->update([
                    'submit_status' => 1,
                    'reject_status' => 0
                ]);

            $timesheetDet = DB::table('teacher_timesheet')
                ->LeftJoin('tbl_school', 'teacher_timesheet.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_teacher', 'teacher_timesheet.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('teacher_timesheet.*', 'tbl_school.name_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt')
                ->where('teacher_timesheet.teacher_timesheet_id', $teacher_timesheet_id)
                ->first();
            if ($timesheetDet) {
                if ($timesheetDet->pdf_id) {
                    $pdfDet = DB::table('pdf')
                        ->where('pdf_id', $timesheetDet->pdf_id)
                        ->first();
                    if ($pdfDet) {
                        if (file_exists($pdfDet->pdf_path)) {
                            unlink($pdfDet->pdf_path);
                        }
                    }
                }
                $itemList = DB::table('teacher_timesheet_item')
                    ->select('teacher_timesheet_item.asnItem_id', 'teacher_timesheet_item.teacher_id', 'teacher_timesheet_item.asn_id', 'teacher_timesheet_item.school_id', DB::raw("DATE_FORMAT(asnDate_dte, '%a %D %b %y') AS asnDate_dte"), DB::raw("IF(dayPart_int = 4, CONCAT(hours_dec, ' hrs'), (SELECT description_txt FROM tbl_description WHERE descriptionGroup_int = 20 AND description_int = dayPart_int)) AS datePart_txt"))
                    ->where('teacher_timesheet_id', $teacher_timesheet_id)
                    ->orderBy('teacher_timesheet_item.asnDate_dte', 'ASC')
                    ->get();

                $pdf = PDF::loadView("web.teacherPortal.timesheet_pdf", ['timesheetDet' => $timesheetDet, 'itemList' => $itemList, 'weekStartDate' => $request->weekStartDate, 'weekEndDate' => $request->weekEndDate]);
                $pdfName = $timesheetDet->firstName_txt . '_' . $timesheetDet->surname_txt . '_' . $teacher_timesheet_id . '(' . $request->weekStartDate . 'to' . $request->weekEndDate . ')' . '.pdf';
                // return $pdf->stream($pdfName);
                // Save the PDF to the server
                $pdf->save(public_path('pdfs/' . $pdfName));

                $pdf_id = DB::table('pdf')
                    ->insertGetId([
                        'pdf_type' => 'Timesheet',
                        'pdf_name' => $pdfName,
                        'pdf_path' => 'pdfs/' . $pdfName,
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);

                DB::table('teacher_timesheet')
                    ->where('teacher_timesheet_id', $teacher_timesheet_id)
                    ->update([
                        'pdf_id' => $pdf_id
                    ]);
            }
            return redirect()->back()->with('success', "Timesheet added successfully.");
        } else {
            return redirect()->back()->with('error', "Something went wrong.");
        }
    }

    public function logTeacherTimesheetAddAjax(Request $request)
    {
        $timesheetExist = DB::table('teacher_timesheet')
            ->whereDate('teacher_timesheet.start_date', '=', $request->weekStartDate)
            ->whereDate('teacher_timesheet.end_date', '=', $request->weekEndDate)
            ->where('teacher_timesheet.school_id', $request->school_id)
            ->where('teacher_timesheet.teacher_id', $request->teacher_id)
            ->first();
        if ($timesheetExist) {
            $teacher_timesheet_id = $timesheetExist->teacher_timesheet_id;
        } else {
            $teacher_timesheet_id = DB::table('teacher_timesheet')
                ->insertGetId([
                    'school_id' => $request->school_id,
                    'teacher_id' => $request->teacher_id,
                    'start_date' => $request->weekStartDate,
                    'end_date' => $request->weekEndDate,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);
        }

        for ($i = 0; $i < count($request->asnItem_id); $i++) {
            if ($request->asnItem_id[$i]) {
                $itemExist = DB::table('teacher_timesheet_item')
                    ->select('teacher_timesheet_item.*')
                    ->where('teacher_timesheet_id', $teacher_timesheet_id)
                    ->where('asnItem_id', $request->asnItem_id[$i])
                    ->whereDate('asnDate_dte', $request->asnDate_dte[$i])
                    ->first();
                if ($itemExist == null) {
                    $itemDet = DB::table('tbl_asnItem')
                        ->select('tbl_asnItem.*')
                        ->where('asnItem_id', $request->asnItem_id[$i])
                        ->first();
                    DB::table('teacher_timesheet_item')
                        ->insertGetId([
                            'teacher_timesheet_id' => $teacher_timesheet_id,
                            'asn_id' => $request->asn_id[$i],
                            'asnItem_id' => $request->asnItem_id[$i],
                            'school_id' => $request->school_id,
                            'teacher_id' => $request->teacher_id,
                            'asnDate_dte' => $request->asnDate_dte[$i],
                            'dayPart_int' => $itemDet ? $itemDet->dayPart_int : 1,
                            'dayPercent_dec' => $itemDet ? $itemDet->dayPercent_dec : 1,
                            'hours_dec' => $itemDet ? $itemDet->hours_dec : NULL,
                            'start_tm' => $itemDet ? $itemDet->start_tm : NULL,
                            'end_tm' => $itemDet ? $itemDet->end_tm : NULL,
                            'charge_dec' => $itemDet ? $itemDet->charge_dec : NULL,
                            'cost_dec' => $itemDet ? $itemDet->cost_dec : NULL,
                            'timestamp_ts' => date('Y-m-d H:i:s')
                        ]);
                }
            }
        }
        return $teacher_timesheet_id;
    }

    public function teacherTimesheetEdit(Request $request)
    {
        $result['exist'] = "No";
        $timesheetExist = DB::table('teacher_timesheet_item')
            ->select('teacher_timesheet_item.*')
            ->where('timesheet_item_id', $request->timesheet_item_id)
            ->first();
        if ($timesheetExist) {
            $dayPartList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 20)
                ->get();
            $view = view("web.teacherPortal.event_edit", ['eventItemDetail' => $timesheetExist, 'dayPartList' => $dayPartList])->render();
            $result['exist'] = "Yes";
            $result['html'] = $view;
            return response()->json($result);
        } else {
            $result['exist'] = "No";
            return response()->json($result);
        }
        return response()->json($result);
    }

    public function teacherTimesheetUpdate(Request $request)
    {
        $timesheet_item_id = $request->timesheet_item_id;
        $start  = new Carbon($request->start_tm);
        $end    = new Carbon($request->end_tm);
        $totalDuration = $end->diffInSeconds($start);
        $diff = gmdate('H', $totalDuration);

        DB::table('teacher_timesheet_item')
            ->where('timesheet_item_id', $timesheet_item_id)
            ->update([
                'hours_dec' => $diff,
                'start_tm' => date("H:i:s", strtotime($request->start_tm)),
                'end_tm' => date("H:i:s", strtotime($request->end_tm)),
            ]);
        return redirect()->back()->with('success', "Record updated successfully.");
    }

    public function teacherTimesheetDelete(Request $request)
    {
        $timesheet_item_id = $request->timesheet_item_id;

        DB::table('teacher_timesheet_item')
            ->where('timesheet_item_id', $timesheet_item_id)
            ->delete();
        return true;
    }

    public function teacherTimesheetAddNew(Request $request)
    {
        if ($request->teacher_timesheet_id) {
            $teacher_timesheet_id = $request->teacher_timesheet_id;
        } else {
            $weekStartDate = Carbon::parse($request->asnDate_dte)->startOfWeek()->format('Y-m-d');
            $weekEndDate = Carbon::parse($request->asnDate_dte)->endOfWeek()->format('Y-m-d');

            $teacher_timesheet_id = DB::table('teacher_timesheet')
                ->insertGetId([
                    'asn_id' => $request->teacher_asn_id,
                    'school_id' => $request->school_id,
                    'teacher_id' => $request->teacher_id,
                    'start_date' => $weekStartDate,
                    'end_date' => $weekEndDate,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);
        }

        $start  = new Carbon($request->start_tm);
        $end    = new Carbon($request->end_tm);
        $totalDuration = $end->diffInSeconds($start);
        $diff = gmdate('H', $totalDuration);

        if ($teacher_timesheet_id) {
            DB::table('teacher_timesheet_item')
                ->insertGetId([
                    'teacher_timesheet_id' => $teacher_timesheet_id,
                    'asn_id' => $request->teacher_asn_id,
                    'asnItem_id' => $request->teacher_asn_item_id,
                    'school_id' => $request->school_id,
                    'teacher_id' => $request->teacher_id,
                    'asnDate_dte' => date('Y-m-d', strtotime($request->asnDate_dte)),
                    'dayPart_int' => 4,
                    'hours_dec' => $diff,
                    'start_tm' => date("H:i:s", strtotime($request->start_tm)),
                    'end_tm' => date("H:i:s", strtotime($request->end_tm)),
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);
        }

        return redirect()->back();
    }

    public function logTeacherPassword(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $title = array('pageTitle' => "Teacher Change Password");
            $headerTitle = "Teachers";
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            $teacherDetail = DB::table('tbl_teacher')
                ->LeftJoin('tbl_contactItemTch', 'tbl_teacher.teacher_id', '=', 'tbl_contactItemTch.teacher_id')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id, SUM(dayPercent_dec) AS daysWorked_dec FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE status_int = 3 GROUP BY teacher_id) AS t_days'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_days.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw("(SELECT teacherDocument_id, teacher_id, file_location FROM tbl_teacherDocument WHERE teacher_id='$teacher_id' AND type_int = 1 ORDER BY teacherDocument_id DESC LIMIT 1) AS t_document"),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_document.teacher_id');
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
                ->LeftJoin('tbl_userFavourite', function ($join) {
                    $join->on('tbl_userFavourite.link_id', '=', 'tbl_teacher.teacher_id')
                        ->where(function ($query) {
                            $query->where('tbl_userFavourite.type_int', '=', 1);
                        });
                })
                ->select('tbl_teacher.*', 'daysWorked_dec', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt', 'applicationStatus.description_txt as appStatus_txt', DB::raw('MAX(tbl_teacherContactLog.contactOn_dtm) AS lastContact_dte'), 'titleTable.description_txt as title_txt', 'tbl_contactItemTch.contactItem_txt', 'nationalityTbl.description_txt as nationality_txt', 'emergencyContactRelation.description_txt as emergencyContactRelation_txt', 'bankTbl.description_txt as bank_txt', 'interviewQuality.description_txt as interviewQuality_txt', 'interviewLanguageSkills.description_txt as interviewLanguageSkills_txt', 'rightToWork.description_txt as rightToWork_txt', 'file_location', 'teacherDocument_id', 'tbl_userFavourite.favourite_id')
                ->where('tbl_teacher.teacher_id', $teacher_id)
                ->groupBy('tbl_teacher.teacher_id')
                ->first();

            $headerStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 3)
                ->orderBy('tbl_description.description_int', 'ASC')
                ->get();

            return view("web.teacherPortal.teacher_password", ['title' => $title, 'headerTitle' => $headerTitle, 'teacherDetail' => $teacherDetail, 'headerStatusList' => $headerStatusList]);
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function LogTeacherPasswordUpdate(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $company_id = $teacherLoginData->company_id;
            $teacher_id = $teacherLoginData->teacher_id;

            if ($request->password != $request->confirm_password) {
                return redirect()->back()->with('error', "Password and confirm password not match.");
            } else {
                DB::table('tbl_teacher')
                    ->where('teacher_id', '=', $teacher_id)
                    ->update([
                        'password' => Hash::make($request->password)
                    ]);
                return redirect()->back()->with('success', "Password updated successfully.");
            }
        } else {
            return redirect()->intended('/teacher');
        }
    }

    public function LogTeacherStatusUpdateHead(Request $request)
    {
        $teacherLoginData = Session::get('teacherLoginData');
        if ($teacherLoginData) {
            $teacher_id = $teacherLoginData->teacher_id;

            $validator = Validator::make($request->all(), [
                'applicationStatus_int' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', "Please fill all mandatory fields.");
            }

            DB::table('tbl_teacher')->where('teacher_id', '=', $teacher_id)
                ->update([
                    'applicationStatus_int' => $request->applicationStatus_int
                ]);

            return redirect()->back()->with('success', "Details updated successfully.");
        } else {
            return redirect()->intended('/teacher');
        }
    }
    /********* Teacher Portal *********/

    public function testMail(Request $request)
    {
        $mail = 'sudip.websadroit@gmail.com';
        $myVar = new AlertController();
        $alertSetting = $myVar->test_mail($mail);
    }
}
