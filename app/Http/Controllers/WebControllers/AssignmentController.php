<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;

class AssignmentController extends Controller
{
    public function assignments(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $assignment = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, MIN(asnDate_dte) AS asnStartDate_dte FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS t_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 't_asnItems.asn_id');
                    }
                )
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
                ->LeftJoin('tbl_description as teacherProff', function ($join) {
                    $join->on('teacherProff.description_int', '=', 'tbl_asn.professionalType_int')
                        ->where(function ($query) {
                            $query->where('teacherProff.descriptionGroup_int', '=', 7);
                        });
                })
                ->LeftJoin('tbl_description as assType', function ($join) {
                    $join->on('assType.description_int', '=', 'tbl_asn.asnLength_int')
                        ->where(function ($query) {
                            $query->where('assType.descriptionGroup_int', '=', 35);
                        });
                })
                ->select('tbl_asn.*', 'tbl_asnItem.hours_dec', 'tbl_asnItem.dayPercent_dec', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession', 'assType.description_txt as assignmentType', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), DB::raw('IF(t_asnItems.asn_id IS NULL, IF(createdOn_dtm IS NULL, tbl_asn.timestamp_ts, createdOn_dtm), asnStartDate_dte) AS asnStartDate_dte'), DB::raw('SUM(tbl_asnItem.dayPercent_dec) as daysThisWeek'))
                ->where('tbl_asn.company_id', $company_id);
            $openAssignmentQuery = clone $assignment;
            $closeAssignmentQuery = clone $assignment;
            $pendingAssignmentQuery = clone $assignment;
            $completeAssignmentQuery = clone $assignment;
            $allAssignmentQuery = clone $assignment;

            if ($request->include != 1) {
                $assignment->whereIn('assStatusDescription.description_int', array('1', '2'));
            }
            $assignmentList = $assignment->groupBy('tbl_asn.asn_id')->get();

            $openAssignmentList = $openAssignmentQuery->where('assStatusDescription.description_int', 1)->groupBy('tbl_asn.asn_id')->get();
            $closeAssignmentList = $closeAssignmentQuery->whereIn('assStatusDescription.description_int', array('6', '7'))->groupBy('tbl_asn.asn_id')->get();
            $pendingAssignmentList = $pendingAssignmentQuery->where('assStatusDescription.description_int', 2)->groupBy('tbl_asn.asn_id')->get();
            $completeAssignmentList = $completeAssignmentQuery->where('assStatusDescription.description_int', 3)->groupBy('tbl_asn.asn_id')->get();
            $allAssignmentList = $allAssignmentQuery->groupBy('tbl_asn.asn_id')->get();

            return view("web.assignment.index", ['title' => $title, 'headerTitle' => $headerTitle, 'assignmentList' => $assignmentList, 'openAssignmentList' => $openAssignmentList, 'closeAssignmentList' => $closeAssignmentList, 'pendingAssignmentList' => $pendingAssignmentList, 'completeAssignmentList' => $completeAssignmentList, 'allAssignmentList' => $allAssignmentList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function createNewAssignment(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $asn_id = DB::table('tbl_asn')
                ->insertGetId([
                    'company_id' => $company_id,
                    'school_id' => $request->school_id,
                    'ageRange_int' => 4,
                    'asnLength_int' => 1,
                    'professionalType_int' => 2,
                    'status_int' => 1,
                    'createdBy_id' => $user_id,
                    'createdOn_dtm' => date('Y-m-d H:i:s'),
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);
            $result['login'] = 'yes';
            $result['asn_id'] = $asn_id;
        } else {
            $result['login'] = 'no';
        }
        return response()->json($result);
    }

    public function assignmentDetails(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments Detail");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $assignmentDetail = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, MIN(asnDate_dte) AS asnStartDate_dte FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS t_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 't_asnItems.asn_id');
                    }
                )
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
                ->LeftJoin('tbl_description as teacherProff', function ($join) {
                    $join->on('teacherProff.description_int', '=', 'tbl_asn.professionalType_int')
                        ->where(function ($query) {
                            $query->where('teacherProff.descriptionGroup_int', '=', 7);
                        });
                })
                ->LeftJoin('tbl_description as assType', function ($join) {
                    $join->on('assType.description_int', '=', 'tbl_asn.asnLength_int')
                        ->where(function ($query) {
                            $query->where('assType.descriptionGroup_int', '=', 35);
                        });
                })
                ->select('tbl_asn.*', 'tbl_asnItem.hours_dec', 'tbl_asnItem.dayPercent_dec', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession', 'assType.description_txt as assignmentType', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), DB::raw('IF(t_asnItems.asn_id IS NULL, IF(createdOn_dtm IS NULL, tbl_asn.timestamp_ts, createdOn_dtm), asnStartDate_dte) AS asnStartDate_dte'), DB::raw('SUM(tbl_asnItem.dayPercent_dec) as daysThisWeek'))
                ->where('tbl_asn.asn_id', $id)
                ->groupBy('tbl_asn.asn_id')
                ->first();

            // echo $currentMonth = date('m');
            // exit;
            $prevDays = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->select(DB::raw('SUM(tbl_asnItem.dayPercent_dec) as previousDays'))
                ->where('tbl_asn.asn_id', $id)
                ->whereDate('tbl_asnItem.asnDate_dte', '<', date('Y-m-d'))
                ->whereMonth('tbl_asnItem.asnDate_dte', '!=', date('m'))
                ->groupBy('tbl_asn.asn_id')
                ->first();

            $nextDays = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->select(DB::raw('SUM(tbl_asnItem.dayPercent_dec) as nDays'))
                ->where('tbl_asn.asn_id', $id)
                ->whereDate('tbl_asnItem.asnDate_dte', '>', date('Y-m-d'))
                ->whereMonth('tbl_asnItem.asnDate_dte', '!=', date('m'))
                ->groupBy('tbl_asn.asn_id')
                ->first();

            $ageRangeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 5)
                ->get();

            $subjectList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 6)
                ->get();

            $yearGrList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 34)
                ->get();

            $assLengthList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 35)
                ->get();

            $profTypeList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 7)
                ->get();

            $studentList = DB::table('tbl_student')
                ->select('tbl_student.*')
                ->where('tbl_student.isCurrent_ysn', -1)
                ->get();

            $assignmentStatusList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 33)
                ->get();

            $dayPartList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 20)
                ->get();

            if ($request->ajax()) {
                $eventItem = DB::table('tbl_asnItem')
                    ->LeftJoin('tbl_description', function ($join) {
                        $join->on('tbl_description.description_int', '=', 'tbl_asnItem.dayPart_int')
                            ->where(function ($query) {
                                $query->where('tbl_description.descriptionGroup_int', '=', 20);
                            });
                    })
                    ->select('tbl_asnItem.asnItem_id as id', 'tbl_asnItem.asnDate_dte as start', DB::raw('IF(dayPart_int = 4, CONCAT("Set hours: ", hours_dec), description_txt) AS title'))
                    ->where('tbl_asnItem.asn_id', $id)
                    ->groupBy('tbl_asnItem.asnItem_id')
                    ->get();
                // $eventItem = [
                //     [
                //         'id' => 999,
                //         'title' => 'Repeating Event',
                //         'start' => '2022-12-25'
                //     ],
                //     [
                //         'id' => 999,
                //         'title' => 'Repeating Event',
                //         'start' => '2022-12-23'
                //     ]
                // ];
                return response()->json($eventItem);
            }

            $candVetting = DB::table('tbl_asnVetting')
                ->select('tbl_asnVetting.vetting_id')
                ->where('tbl_asnVetting.asn_id', $id)
                ->orderBy('tbl_asnVetting.vetting_id', 'DESC')
                ->first();

            return view("web.assignment.assignment_detail", ['title' => $title, 'headerTitle' => $headerTitle, 'asn_id' => $id, 'assignmentDetail' => $assignmentDetail, 'ageRangeList' => $ageRangeList, 'subjectList' => $subjectList, 'yearGrList' => $yearGrList, 'assLengthList' => $assLengthList, 'profTypeList' => $profTypeList, 'studentList' => $studentList, 'assignmentStatusList' => $assignmentStatusList, 'dayPartList' => $dayPartList, 'prevDays' => $prevDays, 'nextDays' => $nextDays, 'candVetting' => $candVetting]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function insertAssignmentEvent(Request $request, $id)
    {
        $Detail = DB::table('tbl_asn')
            ->where('tbl_asn.asn_id', $id)
            ->first();
        if ($Detail) {
            $charge_dec = NULL;
            if ($Detail->charge_dec) {
                $charge_dec = $Detail->charge_dec;
            }
            $cost_dec = NULL;
            if ($Detail->cost_dec) {
                $cost_dec = $Detail->cost_dec;
            }

            $eventItemDetail = DB::table('tbl_asnItem')
                ->where('tbl_asnItem.asn_id', $id)
                ->whereDate('tbl_asnItem.asnDate_dte', $request->event_start)
                ->first();

            if ($eventItemDetail) {
                $dayPart_int = '';
                $dayPercent_dec = 1;
                if ($eventItemDetail->dayPart_int == 1) {
                    $dayPart_int = 2;
                    $dayPercent_dec = 0.5;
                } elseif ($eventItemDetail->dayPart_int == 2) {
                    $dayPart_int = 3;
                    $dayPercent_dec = 0.5;
                } elseif ($eventItemDetail->dayPart_int == 4) {
                    $dayPart_int = 1;
                } else {
                    $dayPart_int = 4;
                }
                if ($dayPart_int == 1 || $dayPart_int == 2 || $dayPart_int == 3) {
                    DB::table('tbl_asnItem')
                        ->where('asnItem_id', $eventItemDetail->asnItem_id)
                        ->update([
                            'dayPart_int' => $dayPart_int,
                            'dayPercent_dec' => $dayPercent_dec,
                            'hours_dec' => NULL,
                            // 'cost_dec' => $cost_dec
                        ]);

                    $eventItem = DB::table('tbl_asnItem')
                        ->LeftJoin('tbl_description', function ($join) {
                            $join->on('tbl_description.description_int', '=', 'tbl_asnItem.dayPart_int')
                                ->where(function ($query) {
                                    $query->where('tbl_description.descriptionGroup_int', '=', 20);
                                });
                        })
                        ->select('tbl_asnItem.asnItem_id as id', 'tbl_asnItem.asnDate_dte as start', DB::raw('IF(dayPart_int = 4, CONCAT("Set hours: ", hours_dec), description_txt) AS title'))
                        ->where('tbl_asnItem.asnItem_id', $eventItemDetail->asnItem_id)
                        ->groupBy('tbl_asnItem.asnItem_id')
                        ->first();
                    $result['type'] = "Update";
                    $result['eventItem'] = $eventItem;
                    return response()->json($result);
                } else {
                    DB::table('tbl_asnItem')
                        ->where('asnItem_id', $eventItemDetail->asnItem_id)
                        ->delete();
                    $result['type'] = "Delete";
                    $result['eventId'] = $eventItemDetail->asnItem_id;
                    return response()->json($result);
                }
            } else {
                $asnItem_id = DB::table('tbl_asnItem')
                    ->insertGetId([
                        'asn_id' => $id,
                        'asnDate_dte' => $request->event_start,
                        'dayPart_int' => 1,
                        'charge_dec' => $charge_dec,
                        'cost_dec' => $cost_dec,
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);

                $eventItem = DB::table('tbl_asnItem')
                    ->LeftJoin('tbl_description', function ($join) {
                        $join->on('tbl_description.description_int', '=', 'tbl_asnItem.dayPart_int')
                            ->where(function ($query) {
                                $query->where('tbl_description.descriptionGroup_int', '=', 20);
                            });
                    })
                    ->select('tbl_asnItem.asnItem_id as id', 'tbl_asnItem.asnDate_dte as start', DB::raw('IF(dayPart_int = 4, CONCAT("Set hours: ", hours_dec), description_txt) AS title'))
                    ->where('tbl_asnItem.asnItem_id', $asnItem_id)
                    ->groupBy('tbl_asnItem.asnItem_id')
                    ->first();
                $result['type'] = "Add";
                $result['eventItem'] = $eventItem;
                return response()->json($result);
            }
        }
        return false;
    }

    public function updateAssignmentEvent(Request $request, $id)
    {
        $asnItem_id = $request->id;
        $Detail = DB::table('tbl_asn')
            ->where('tbl_asn.asn_id', $id)
            ->first();
        if ($Detail) {
            $charge_dec = NULL;
            if ($Detail->charge_dec) {
                $charge_dec = $Detail->charge_dec;
            }
            $cost_dec = NULL;
            if ($Detail->cost_dec) {
                $cost_dec = $Detail->cost_dec;
            }

            $eventItemDetail = DB::table('tbl_asnItem')
                ->where('tbl_asnItem.asnItem_id', $asnItem_id)
                ->first();

            if ($eventItemDetail) {
                $dayPart_int = '';
                $dayPercent_dec = 1;
                if ($eventItemDetail->dayPart_int == 1) {
                    $dayPart_int = 2;
                    $dayPercent_dec = 0.5;
                } elseif ($eventItemDetail->dayPart_int == 2) {
                    $dayPart_int = 3;
                    $dayPercent_dec = 0.5;
                } elseif ($eventItemDetail->dayPart_int == 4) {
                    $dayPart_int = 1;
                } else {
                    $dayPart_int = 4;
                }
                if ($dayPart_int == 1 || $dayPart_int == 2 || $dayPart_int == 3) {
                    DB::table('tbl_asnItem')
                        ->where('asnItem_id', $eventItemDetail->asnItem_id)
                        ->update([
                            'dayPart_int' => $dayPart_int,
                            'dayPercent_dec' => $dayPercent_dec,
                            'hours_dec' => NULL,
                            // 'cost_dec' => $cost_dec
                        ]);

                    $eventItem = DB::table('tbl_asnItem')
                        ->LeftJoin('tbl_description', function ($join) {
                            $join->on('tbl_description.description_int', '=', 'tbl_asnItem.dayPart_int')
                                ->where(function ($query) {
                                    $query->where('tbl_description.descriptionGroup_int', '=', 20);
                                });
                        })
                        ->select('tbl_asnItem.asnItem_id as id', 'tbl_asnItem.asnDate_dte as start', DB::raw('IF(dayPart_int = 4, CONCAT("Set hours: ", hours_dec), description_txt) AS title'))
                        ->where('tbl_asnItem.asnItem_id', $eventItemDetail->asnItem_id)
                        ->groupBy('tbl_asnItem.asnItem_id')
                        ->first();
                    $result['type'] = "Update";
                    $result['eventItem'] = $eventItem;
                    return response()->json($result);
                } else {
                    DB::table('tbl_asnItem')
                        ->where('asnItem_id', $eventItemDetail->asnItem_id)
                        ->delete();
                    $result['type'] = "Delete";
                    $result['eventId'] = $eventItemDetail->asnItem_id;
                    return response()->json($result);
                }
            } else {
                return false;
            }
        }
        return false;
    }

    public function checkAssignmentEvent(Request $request, $id)
    {
        $result['exist'] = "No";
        $Detail = DB::table('tbl_asn')
            ->where('tbl_asn.asn_id', $id)
            ->first();
        if ($Detail) {
            $eventItemDetail = DB::table('tbl_asnItem')
                ->where('tbl_asnItem.asn_id', $id)
                ->whereDate('tbl_asnItem.asnDate_dte', $request->event_start)
                ->first();

            if ($eventItemDetail) {
                $dayPartList = DB::table('tbl_description')
                    ->select('tbl_description.*')
                    ->where('tbl_description.descriptionGroup_int', 20)
                    ->get();

                $view = view("web.assignment.event_edit_view", ['eventItemDetail' => $eventItemDetail, 'dayPartList' => $dayPartList])->render();
                $result['exist'] = "Yes";
                $result['eventId'] = $eventItemDetail->asnItem_id;
                $result['html'] = $view;
                return response()->json($result);
            } else {
                $result['exist'] = "No";
                return response()->json($result);
            }
        }
        return response()->json($result);
    }

    public function checkAssignmentEvent2(Request $request, $id)
    {
        $result['exist'] = "No";
        $asnItem_id = $request->id;
        $Detail = DB::table('tbl_asn')
            ->where('tbl_asn.asn_id', $id)
            ->first();
        if ($Detail) {
            $eventItemDetail = DB::table('tbl_asnItem')
                ->where('tbl_asnItem.asnItem_id', $asnItem_id)
                ->first();

            if ($eventItemDetail) {
                $dayPartList = DB::table('tbl_description')
                    ->select('tbl_description.*')
                    ->where('tbl_description.descriptionGroup_int', 20)
                    ->get();

                $view = view("web.assignment.event_edit_view", ['eventItemDetail' => $eventItemDetail, 'dayPartList' => $dayPartList])->render();
                $result['exist'] = "Yes";
                $result['eventId'] = $eventItemDetail->asnItem_id;
                $result['html'] = $view;
                return response()->json($result);
            } else {
                $result['exist'] = "No";
                return response()->json($result);
            }
        }
        return response()->json($result);
    }

    public function ajaxAssignmentEventUpdate(Request $request)
    {
        $editEventId = $request->editEventId;

        DB::table('tbl_asnItem')
            ->where('asnItem_id', $editEventId)
            ->update([
                'dayPart_int' => $request->dayPart_int,
                'asnDate_dte' => date("Y-m-d", strtotime($request->asnDate_dte)),
                'charge_dec' => $request->charge_dec,
                'dayPercent_dec' => $request->dayPercent_dec,
                'hours_dec' => $request->hours_dec,
                'cost_dec' => $request->cost_dec
            ]);

        $eventItem = DB::table('tbl_asnItem')
            ->LeftJoin('tbl_description', function ($join) {
                $join->on('tbl_description.description_int', '=', 'tbl_asnItem.dayPart_int')
                    ->where(function ($query) {
                        $query->where('tbl_description.descriptionGroup_int', '=', 20);
                    });
            })
            ->select('tbl_asnItem.asnItem_id as id', 'tbl_asnItem.asnDate_dte as start', DB::raw('IF(dayPart_int = 4, CONCAT("Set hours: ", hours_dec), description_txt) AS title'))
            ->where('tbl_asnItem.asnItem_id', $editEventId)
            ->groupBy('tbl_asnItem.asnItem_id')
            ->first();

        $result['status'] = "success";
        $result['eventId'] = $editEventId;
        $result['eventItem'] = $eventItem;
        return response()->json($result);
    }

    public function addBlockBooking(Request $request)
    {
        $eventItemArr = array();
        $IdArray = array();
        $firstDate = '';
        $assignmentId = $request->assignmentId;
        $blockStartDate = date("Y-m-d", strtotime($request->blockStartDate));
        $blockEndDate = date("Y-m-d", strtotime($request->blockEndDate));
        $blockDayPart = $request->blockDayPart;
        if ($blockDayPart == 1) {
            $dayPercent_dec = 1;
        } elseif ($blockDayPart == 2 || $blockDayPart == 3) {
            $dayPercent_dec = 0.5;
        } elseif ($blockDayPart == 4) {
            $dayPercent_dec = 0.33;
        } else {
            $dayPercent_dec = NULL;
        }
        $blockHour = NULL;
        if ($request->blockHour) {
            $blockHour = $request->blockHour;
        }

        $Detail = DB::table('tbl_asn')
            ->where('tbl_asn.asn_id', $assignmentId)
            ->first();
        if ($Detail) {
            $charge_dec = NULL;
            if ($Detail->charge_dec) {
                $charge_dec = $Detail->charge_dec;
            }
            $cost_dec = NULL;
            if ($Detail->cost_dec) {
                $cost_dec = $Detail->cost_dec;
            }

            $period = CarbonPeriod::create($blockStartDate, $blockEndDate);
            foreach ($period as $date) {
                // echo $date->format('Y-m-d');
                $day = date('D', strtotime($date->format('Y-m-d')));
                if ($day == 'Mon' || $day == 'Tue' || $day == 'Wed' || $day == 'Thu' || $day == 'Fri') {
                    if ($firstDate == '') {
                        $firstDate = $date->format('Y-m-d');
                    }
                    $eventItemExist = DB::table('tbl_asnItem')
                        ->where('tbl_asnItem.asn_id', $assignmentId)
                        ->whereDate('tbl_asnItem.asnDate_dte', $date->format('Y-m-d'))
                        ->first();

                    if ($eventItemExist) {
                        array_push($IdArray, $eventItemExist->asnItem_id);
                        DB::table('tbl_asnItem')
                            ->where('asnItem_id', $eventItemExist->asnItem_id)
                            ->delete();
                    }
                    $asnItem_id = DB::table('tbl_asnItem')
                        ->insertGetId([
                            'asn_id' => $assignmentId,
                            'asnDate_dte' => $date->format('Y-m-d'),
                            'dayPart_int' => $blockDayPart,
                            'dayPercent_dec' => $dayPercent_dec,
                            'hours_dec' => $blockHour,
                            'charge_dec' => $charge_dec,
                            'cost_dec' => $cost_dec,
                            'timestamp_ts' => date('Y-m-d H:i:s')
                        ]);

                    $eventItem = DB::table('tbl_asnItem')
                        ->LeftJoin('tbl_description', function ($join) {
                            $join->on('tbl_description.description_int', '=', 'tbl_asnItem.dayPart_int')
                                ->where(function ($query) {
                                    $query->where('tbl_description.descriptionGroup_int', '=', 20);
                                });
                        })
                        ->select('tbl_asnItem.asnItem_id as id', 'tbl_asnItem.asnDate_dte as start', DB::raw('IF(dayPart_int = 4, CONCAT("Set hours: ", hours_dec), description_txt) AS title'))
                        ->where('tbl_asnItem.asnItem_id', $asnItem_id)
                        ->groupBy('tbl_asnItem.asnItem_id')
                        ->first();

                    array_push($eventItemArr, $eventItem);
                }
            }

            $result['status'] = "success";
            $result['firstDate'] = $firstDate;
            $result['eventItemArr'] = $eventItemArr;
            $result['IdArray'] = $IdArray;
            return response()->json($result);
        }
        return false;
    }

    public function unBlockBooking(Request $request)
    {
        $IdArray = array();
        $firstDate = '';
        $assignmentId = $request->assignmentId;
        $blockStartDate = date("Y-m-d", strtotime($request->unblockStartDate));
        $blockEndDate = date("Y-m-d", strtotime($request->unblockEndDate));

        $Detail = DB::table('tbl_asn')
            ->where('tbl_asn.asn_id', $assignmentId)
            ->first();
        if ($Detail) {
            $period = CarbonPeriod::create($blockStartDate, $blockEndDate);
            foreach ($period as $date) {
                // echo $date->format('Y-m-d');
                $eventItemExist = DB::table('tbl_asnItem')
                    ->where('tbl_asnItem.asn_id', $assignmentId)
                    ->whereDate('tbl_asnItem.asnDate_dte', $date->format('Y-m-d'))
                    ->first();

                if ($eventItemExist) {
                    array_push($IdArray, $eventItemExist->asnItem_id);
                    DB::table('tbl_asnItem')
                        ->where('asnItem_id', $eventItemExist->asnItem_id)
                        ->delete();
                }
            }

            $result['status'] = "success";
            $result['firstDate'] = $firstDate;
            $result['IdArray'] = $IdArray;
            return response()->json($result);
        }
        return false;
    }

    public function prevNextEvent(Request $request, $id)
    {
        $Detail = DB::table('tbl_asn')
            ->where('tbl_asn.asn_id', $id)
            ->first();
        if ($Detail) {
            $date = date("Y-m-d", strtotime($request->Date));
            $month = date("m", strtotime($request->Date));
            // echo $date;exit;
            $prevDays = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->select(DB::raw('SUM(tbl_asnItem.dayPercent_dec) as previousDays'))
                ->where('tbl_asn.asn_id', $id)
                ->whereDate('tbl_asnItem.asnDate_dte', '<', $date)
                ->whereMonth('tbl_asnItem.asnDate_dte', '!=', $month)
                ->groupBy('tbl_asn.asn_id')
                ->first();

            $nextDays = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->select(DB::raw('SUM(tbl_asnItem.dayPercent_dec) as nDays'))
                ->where('tbl_asn.asn_id', $id)
                ->whereDate('tbl_asnItem.asnDate_dte', '>', $date)
                ->whereMonth('tbl_asnItem.asnDate_dte', '!=', $month)
                ->groupBy('tbl_asn.asn_id')
                ->first();

            $result['prevDays'] = $prevDays;
            $result['nextDays'] = $nextDays;
            return response()->json($result);
        }
        return false;
    }

    public function assignmentDetailUpdate(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $asn_id = $request->assignmentId;

            $statusBy_id = NULL;
            $statusOn_dtm = NULL;
            if ($request->status_int) {
                $statusBy_id = $user_id;
                $statusOn_dtm = date('Y-m-d H:i:s');
            }
            $firstDate_dte = NULL;
            if ($request->firstDate_dte) {
                $firstDate_dte = date("Y-m-d", strtotime($request->firstDate_dte));
            }

            DB::table('tbl_asn')
                ->where('asn_id', $asn_id)
                ->update([
                    'ageRange_int' => $request->ageRange_int,
                    'subject_int' => $request->subject_int,
                    'yearGroup_int' => $request->yearGroup_int,
                    'asnLength_int' => $request->asnLength_int,
                    'professionalType_int' => $request->professionalType_int,
                    'student_id' => $request->student_id,
                    'charge_dec' => $request->charge_dec,
                    'cost_dec' => $request->cost_dec,
                    'status_int' => $request->status_int,
                    'notes_txt' => $request->notes_txt,
                    'firstDate_dte' => $firstDate_dte,
                    'statusBy_id' => $statusBy_id,
                    'statusOn_dtm' => $statusOn_dtm
                ]);

            return redirect()->back()->with('success', "Details updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }



    public function assignmentContact(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments Contact");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;

            $assignmentDetail = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, MIN(asnDate_dte) AS asnStartDate_dte FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS t_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 't_asnItems.asn_id');
                    }
                )
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
                ->LeftJoin('tbl_description as teacherProff', function ($join) {
                    $join->on('teacherProff.description_int', '=', 'tbl_asn.professionalType_int')
                        ->where(function ($query) {
                            $query->where('teacherProff.descriptionGroup_int', '=', 7);
                        });
                })
                ->LeftJoin('tbl_description as assType', function ($join) {
                    $join->on('assType.description_int', '=', 'tbl_asn.asnLength_int')
                        ->where(function ($query) {
                            $query->where('assType.descriptionGroup_int', '=', 35);
                        });
                })
                ->select('tbl_asn.*', 'tbl_asnItem.hours_dec', 'tbl_asnItem.dayPercent_dec', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession', 'assType.description_txt as assignmentType', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), DB::raw('IF(t_asnItems.asn_id IS NULL, IF(createdOn_dtm IS NULL, tbl_asn.timestamp_ts, createdOn_dtm), asnStartDate_dte) AS asnStartDate_dte'))
                ->where('tbl_asn.asn_id', $id)
                ->groupBy('tbl_asn.asn_id')
                ->first();

            $ContactHistory1 = DB::table('tbl_schoolContactLog')
                ->select('schoolContactLog_id', 'contactOn_dtm', DB::raw('CONCAT("School: ", spokeTo_txt) AS contactWith_txt'), 'notes_txt', 'asnLink_id')
                ->where('tbl_schoolContactLog.school_id', $assignmentDetail->school_id)
                ->orderBy('contactOn_dtm', 'DESC')
                ->get()
                ->toArray();
            $ContactHistory2 = DB::table('tbl_teacherContactLog')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_teacherContactLog.teacher_id')
                ->select('teacherContactLog_id', 'contactOn_dtm', DB::raw('CONCAT("Teacher: ", IF(knownAs_txt IS NULL OR knownAs_txt = "", CONCAT(firstName_txt, " ",  surname_txt), CONCAT(knownAs_txt, " ",  surname_txt))) AS contactWith_txt'), 'notes_txt', 'asnLink_id')
                // ->union($ContactHistory1)
                ->where('tbl_teacherContactLog.asnLink_id', $id)
                ->orderBy('contactOn_dtm', 'DESC')
                ->get()
                ->toArray();
            $ContactHistory = array_merge($ContactHistory1, $ContactHistory2);
            // dd($ContactHistory);
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
                ->where('tbl_schoolContact.school_id', $assignmentDetail->school_id)
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

            return view("web.assignment.assignment_contact", ['title' => $title, 'headerTitle' => $headerTitle, 'asn_id' => $id, 'assignmentDetail' => $assignmentDetail, 'ContactHistory' => $ContactHistory, 'schoolContacts' => $schoolContacts, 'quickSettingList' => $quickSettingList, 'methodList' => $methodList, 'reasonList' => $reasonList, 'outcomeList' => $outcomeList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function assignmentContactLogInsert(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->school_id;
            $asn_id = $request->asn_id;
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
                    'asnLink_id' => $asn_id,
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);

            return redirect()->back()->with('success', "Contact history added successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function asnContactHistoryEdit(Request $request)
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

        $view = view("web.assignment.contact_history_edit_view", ['contactDetail' => $contactDetail, 'schoolContacts' => $schoolContacts, 'quickSettingList' => $quickSettingList, 'methodList' => $methodList, 'reasonList' => $reasonList, 'outcomeList' => $outcomeList])->render();
        return response()->json(['html' => $view]);
    }

    public function asnContactLogEdit(Request $request)
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

        $view = view("web.assignment.contact_log_edit_view", ['contactDetail' => $contactDetail, 'quickSettingList' => $quickSettingList, 'methodList' => $methodList])->render();
        return response()->json(['html' => $view]);
    }

    public function asnSchoolContactLogUpdate(Request $request)
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

            return redirect()->back()->with('success', "Contact history updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function asnTeacherContactLogUpdate(Request $request)
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

            return redirect()->back()->with('success', "Contact history updated successfully.");
        } else {
            return redirect()->intended('/');
        }
    }

    public function assignmentCandidate(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments Candidate");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;

            $assignmentDetail = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, MIN(asnDate_dte) AS asnStartDate_dte FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS t_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 't_asnItems.asn_id');
                    }
                )
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
                ->LeftJoin('tbl_description as teacherProff', function ($join) {
                    $join->on('teacherProff.description_int', '=', 'tbl_asn.professionalType_int')
                        ->where(function ($query) {
                            $query->where('teacherProff.descriptionGroup_int', '=', 7);
                        });
                })
                ->LeftJoin('tbl_description as assType', function ($join) {
                    $join->on('assType.description_int', '=', 'tbl_asn.asnLength_int')
                        ->where(function ($query) {
                            $query->where('assType.descriptionGroup_int', '=', 35);
                        });
                })
                ->select('tbl_asn.*', 'tbl_asnItem.hours_dec', 'tbl_asnItem.dayPercent_dec', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession', 'assType.description_txt as assignmentType', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), DB::raw('IF(t_asnItems.asn_id IS NULL, IF(createdOn_dtm IS NULL, tbl_asn.timestamp_ts, createdOn_dtm), asnStartDate_dte) AS asnStartDate_dte'))
                ->where('tbl_asn.asn_id', $id)
                ->groupBy('tbl_asn.asn_id')
                ->first();

            $schoolLatLong = DB::table('tbl_asn')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->select(DB::raw('CAST(lat_txt AS DECIMAL(9, 7)) AS schoolLat'), DB::raw('CAST(lon_txt AS DECIMAL(9, 7)) AS schoolLong'))
                ->where('tbl_asn.asn_id', $id)
                ->groupBy('tbl_asn.asn_id')
                ->first();
            $v_schoolLat = $schoolLatLong->schoolLat;
            $v_schoolLon = $schoolLatLong->schoolLong;

            $asnDet = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->select(DB::raw('IFNULL(ageRange_int, 0) AS ageRange'), 'subject_int', 'yearGroup_int', DB::raw('COUNT(DISTINCT asnItem_id) AS itemCount'), DB::raw('IFNULL(professionalType_int, 0) AS professionalType'))
                ->where('tbl_asn.asn_id', $id)
                ->groupBy('tbl_asn.asn_id')
                ->first();
            $v_ageRange = $asnDet->ageRange;
            $v_subject = $asnDet->subject_int == '' ? NULL : $asnDet->subject_int;
            $v_yearGroup = $asnDet->yearGroup_int == '' ? NULL : $asnDet->yearGroup_int;
            $v_asnDatesCount = $asnDet->itemCount;
            $v_professionalType = $asnDet->professionalType;

            $candidate = DB::table('tbl_teacher')
                ->leftJoin(
                    DB::raw('(SELECT teacher_id FROM tbl_teacherSubject WHERE subject_id = "' . $v_subject . '" GROUP BY teacher_id) AS t_subject'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_subject.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw('(SELECT tbl_teacherCalendar.teacher_id, COUNT(date_dte) AS daysBlocked_int FROM tbl_teacherCalendar WHERE tbl_teacherCalendar.date_dte IN (SELECT asnDate_dte FROM tbl_asnItem WHERE asn_id = ' . $id . ') GROUP BY tbl_teacherCalendar.teacher_id) AS t_diary'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_diary.teacher_id');
                    }
                )
                ->leftJoin(
                    DB::raw('(SELECT tbl_asn.teacher_id, COUNT(tbl_asnItem.asnDate_dte) AS daysBooked_int FROM tbl_asn LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id WHERE tbl_asnItem.asnDate_dte IN (SELECT asnDate_dte FROM tbl_asnItem WHERE asn_id = ' . $id . ') AND (status_int = 3) GROUP BY tbl_asn.teacher_id) AS t_asns'),
                    function ($join) {
                        $join->on('tbl_teacher.teacher_id', '=', 't_asns.teacher_id');
                    }
                )
                ->LeftJoin('tbl_description as statusTbl', function ($join) {
                    $join->on('statusTbl.description_int', '=', 'tbl_teacher.applicationStatus_int')
                        ->where(function ($query) {
                            $query->where('statusTbl.descriptionGroup_int', '=', 3);
                        });
                })
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
                ->select('tbl_teacher.teacher_id', 'tbl_teacher.knownAs_txt', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'statusTbl.description_txt as status_txt', DB::raw('(CAST(((ACOS(SIN(tbl_teacher.lat_txt * PI() / 180) * SIN(' . $v_schoolLat . ' * PI() / 180) + COS(tbl_teacher.lat_txt * PI() / 180) * COS(' . $v_schoolLat . ' * PI() / 180) * COS((tbl_teacher.lon_txt - ' . $v_schoolLon . ') * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS DECIMAL(7, 1))) AS distance_dec'), DB::raw('CAST(IF(daysBlocked_int + daysBooked_int >= ' . $v_asnDatesCount . ', 0, IF((IFNULL(daysBlocked_int, 0) + IFNULL(daysBooked_int, 0)) / ' . $v_asnDatesCount . ' < 0, 0, (1 - ((IFNULL(daysBlocked_int, 0) + IFNULL(daysBooked_int, 0)) / ' . $v_asnDatesCount . ')) * 100)) AS DECIMAL(5, 1)) AS availability_dec'), 'tbl_teacher.prefYearGroup_int', 't_subject.teacher_id as subjectTeacherId', 'ageRangeSpecialism.description_txt as ageRangeSpecialism_txt', 'professionalType.description_txt as professionalType_txt');

            if ($request->showall) {
                $candidate->whereIn('applicationStatus_int', array('1', '2'))
                    ->whereRaw('(' . $v_ageRange . ' = 0 OR ageRangeSpecialism_int = ' . $v_ageRange . ') AND (tbl_teacher.isCurrent_status <> 0) AND (professionalType_int = ' . $v_professionalType . ' OR ' . $v_professionalType . ' = 0)');
            } else {
                $candidate->whereRaw('(applicationStatus_int = 1) AND (' . $v_ageRange . ' = 0 OR ageRangeSpecialism_int = ' . $v_ageRange . ') AND (tbl_teacher.isCurrent_status <> 0) AND (professionalType_int = ' . $v_professionalType . ' OR ' . $v_professionalType . ' = 0)');
            }

            $candidateList = $candidate->groupBy('tbl_teacher.teacher_id')
                ->orderByRaw('CAST(IF(daysBlocked_int + daysBooked_int >= ' . $v_asnDatesCount . ', 0, IF((IFNULL(daysBlocked_int, 0) + IFNULL(daysBooked_int, 0)) / ' . $v_asnDatesCount . ' < 0, 0, (1 - ((IFNULL(daysBlocked_int, 0) + IFNULL(daysBooked_int, 0)) / ' . $v_asnDatesCount . ')) * 100)) AS DECIMAL(5, 1)) DESC, distance_dec ASC')
                ->get();

            $schoolId = $assignmentDetail->school_id;
            $continuityList = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_description as applicationStatus', function ($join) {
                    $join->on('applicationStatus.description_int', '=', 'tbl_teacher.applicationStatus_int')
                        ->where(function ($query) {
                            $query->where('applicationStatus.descriptionGroup_int', '=', 3);
                        });
                })
                ->LeftJoin('tbl_schoolTeacherList', function ($join) use ($schoolId) {
                    $join->on('tbl_schoolTeacherList.teacher_id', '=', 'tbl_asn.teacher_id')
                        ->where(function ($query) use ($schoolId) {
                            $query->where('tbl_schoolTeacherList.school_id', '=', $schoolId)
                                ->where('tbl_schoolTeacherList.rejectOrPreferred_int', '!=', 2);
                        });
                })
                ->select('tbl_asn.teacher_id', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_teacher.applicationStatus_int', 'applicationStatus.description_txt as status_txt', DB::raw('SUM(dayPercent_dec) AS daysWorked_dec'), 'tbl_schoolTeacherList.rejectOrPreferred_int')
                ->where('tbl_asn.school_id', '=', $schoolId)
                ->where('tbl_asn.status_int', '=', 3)
                ->where('tbl_teacher.continuityStatus', '=', 1)
                ->groupBy('tbl_asn.teacher_id')
                ->orderByRaw('SUM(dayPercent_dec) DESC')
                ->get();

            $preferedList = DB::table('tbl_schoolTeacherList')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_schoolTeacherList.teacher_id')
                ->LeftJoin('tbl_description as applicationStatus', function ($join) {
                    $join->on('applicationStatus.description_int', '=', 'tbl_teacher.applicationStatus_int')
                        ->where(function ($query) {
                            $query->where('applicationStatus.descriptionGroup_int', '=', 3);
                        });
                })
                ->select('tbl_schoolTeacherList.*', 'tbl_teacher.firstName_txt', 'tbl_teacher.surname_txt', 'tbl_teacher.knownAs_txt', 'tbl_teacher.applicationStatus_int', 'applicationStatus.description_txt as status_txt')
                ->where('tbl_schoolTeacherList.school_id', $schoolId)
                ->where('tbl_schoolTeacherList.rejectOrPreferred_int', 1)
                ->groupBy('tbl_schoolTeacherList.teacher_id')
                ->get();

            return view("web.assignment.assignment_candidate", ['title' => $title, 'headerTitle' => $headerTitle, 'asn_id' => $id, 'assignmentDetail' => $assignmentDetail, 'asnDet' => $asnDet, 'candidateList' => $candidateList, 'continuityList' => $continuityList, 'preferedList' => $preferedList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function addAsnPreferredTeacher(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $school_id = $request->SchoolId;
            $teacher_id = $request->preferTeacherId;

            DB::table('tbl_schoolTeacherList')
                ->insert([
                    'school_id' => $school_id,
                    'teacher_id' => $teacher_id,
                    'rejectOrPreferred_int' => 1,
                    'notes_txt' => NULL,
                    'addedBy_id' => $user_id,
                    'addedOn_dtm' => date('Y-m-d H:i:s'),
                    'timestamp_ts' => date('Y-m-d H:i:s')
                ]);
            return true;
        } else {
            return false;
        }
    }

    public function updateAssignmentTeacher(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $asn_id = $request->asn_id;
            $teacher_id = $request->assignTeacherId;

            DB::table('tbl_asn')
                ->where('asn_id', $asn_id)
                ->update([
                    'status_int' => 2,
                    'teacher_id' => $teacher_id
                ]);
            return true;
        } else {
            return false;
        }
    }

    public function assignmentSchool(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments School Detail");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;

            $assignmentDetail = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, MIN(asnDate_dte) AS asnStartDate_dte FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS t_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 't_asnItems.asn_id');
                    }
                )
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
                ->LeftJoin('tbl_description as teacherProff', function ($join) {
                    $join->on('teacherProff.description_int', '=', 'tbl_asn.professionalType_int')
                        ->where(function ($query) {
                            $query->where('teacherProff.descriptionGroup_int', '=', 7);
                        });
                })
                ->LeftJoin('tbl_description as assType', function ($join) {
                    $join->on('assType.description_int', '=', 'tbl_asn.asnLength_int')
                        ->where(function ($query) {
                            $query->where('assType.descriptionGroup_int', '=', 35);
                        });
                })
                ->select('tbl_asn.*', 'tbl_asnItem.hours_dec', 'tbl_asnItem.dayPercent_dec', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession', 'assType.description_txt as assignmentType', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), DB::raw('IF(t_asnItems.asn_id IS NULL, IF(createdOn_dtm IS NULL, tbl_asn.timestamp_ts, createdOn_dtm), asnStartDate_dte) AS asnStartDate_dte'))
                ->where('tbl_asn.asn_id', $id)
                ->groupBy('tbl_asn.asn_id')
                ->first();

            $schoolId = $assignmentDetail->school_id;
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
                ->where('tbl_school.school_id', $schoolId)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
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
                ->where('tbl_schoolContact.school_id', $schoolId)
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
                ->where('tbl_contactItemSch.school_id', $schoolId)
                // ->where(function ($query) {
                //     $query->where('tbl_contactItemSch.schoolContact_id', NULL);
                //     // ->orWhere('tbl_schoolContact.isCurrent_status', '=', '-1');
                // })
                ->get();

            return view("web.assignment.assignment_school", ['title' => $title, 'headerTitle' => $headerTitle, 'asn_id' => $id, 'assignmentDetail' => $assignmentDetail, 'schoolDetail' => $schoolDetail, 'schoolContacts' => $schoolContacts, 'contactItems' => $contactItems, 'school_id' => $schoolId]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function assignmentFinance(Request $request, $id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Assignments Finance");
            $headerTitle = "Assignments";
            $company_id = $webUserLoginData->company_id;

            $assignmentDetail = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, MIN(asnDate_dte) AS asnStartDate_dte FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS t_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 't_asnItems.asn_id');
                    }
                )
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
                ->LeftJoin('tbl_description as teacherProff', function ($join) {
                    $join->on('teacherProff.description_int', '=', 'tbl_asn.professionalType_int')
                        ->where(function ($query) {
                            $query->where('teacherProff.descriptionGroup_int', '=', 7);
                        });
                })
                ->LeftJoin('tbl_description as assType', function ($join) {
                    $join->on('assType.description_int', '=', 'tbl_asn.asnLength_int')
                        ->where(function ($query) {
                            $query->where('assType.descriptionGroup_int', '=', 35);
                        });
                })
                ->select('tbl_asn.*', 'tbl_asnItem.hours_dec', 'tbl_asnItem.dayPercent_dec', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'yearDescription.description_txt as yearGroup', 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession', 'assType.description_txt as assignmentType', DB::raw('SUM(IF(hours_dec IS NOT NULL, hours_dec, dayPercent_dec)) AS days_dec,IF(hours_dec IS NOT NULL, "hrs", "days") AS type_txt'), DB::raw('IF(t_asnItems.asn_id IS NULL, IF(createdOn_dtm IS NULL, tbl_asn.timestamp_ts, createdOn_dtm), asnStartDate_dte) AS asnStartDate_dte'))
                ->where('tbl_asn.asn_id', $id)
                ->groupBy('tbl_asn.asn_id')
                ->first();

            $invoiceList = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select('tbl_invoice.*', DB::raw('CAST(SUM(numItems_dec * charge_dec) AS DECIMAL(6, 2)) AS net_dec'), DB::raw('CAST(SUM((numItems_dec * charge_dec) * vatRate_dec) AS DECIMAL(6, 2)) vat_dec'), DB::raw('CAST(SUM((numItems_dec * charge_dec) * (1 + vatRate_dec)) AS DECIMAL(6, 2)) gross_dec'))
                ->whereIn('tbl_invoiceItem.asnItem_id', function ($query) use ($id) {
                    $query->select('asnItem_id')
                        ->from('tbl_asnItem')
                        ->where('tbl_asnItem.asn_id', $id)
                        ->get();
                })
                ->get();

            return view("web.assignment.assignment_finance", ['title' => $title, 'headerTitle' => $headerTitle, 'asn_id' => $id, 'assignmentDetail' => $assignmentDetail, 'invoiceList' => $invoiceList]);
        } else {
            return redirect()->intended('/');
        }
    }
}
