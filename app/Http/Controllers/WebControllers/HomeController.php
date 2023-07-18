<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        $title = array('pageTitle' => "Dashboard");
        $headerTitle = "Dashboard";
        // $admin = Auth::guard('subadmin')->user();
        // dd($admin);
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            if ($request->date) {
                $weekStartDate = $request->date;
            } else {
                $now = Carbon::now();
                $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            }
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));

            $latestAssignment = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
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
                ->select('tbl_asn.*', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', DB::raw('SUM(tbl_asnItem.dayPercent_dec) as daysThisWeek'), DB::raw('SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS predictedGP'), DB::raw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking'), DB::raw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing'), 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession')
                // ->where('tbl_asn.status_int', 2)
                ->where('tbl_asn.company_id', $company_id)
                ->where('tbl_teacher.is_delete', 0)
                // ->whereDate('tbl_asnItem.asnDate_dte', '>=', $weekStartDate)
                // ->whereDate('tbl_asnItem.asnDate_dte', '<=', $plusFiveDate)
                ->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_asn.timestamp_ts', 'DESC')
                ->limit(20)
                ->get();
            // $sideBarData = DB::table('tbl_asn')
            //     ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
            //     ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
            //     ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
            //     ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
            //     ->select(DB::raw('SUM(tbl_asnItem.dayPercent_dec) as daysThisWeek'), DB::raw('SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS predictedGP'), DB::raw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking'), DB::raw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing'))
            //     ->where('tbl_asn.status_int', 3)
            //     ->where('tbl_asn.company_id', $company_id)
            //     ->whereDate('tbl_asnItem.asnDate_dte', '>=', $weekStartDate)
            //     ->whereDate('tbl_asnItem.asnDate_dte', '<=', $plusFiveDate)
            //     ->get();
            // dd($sideBarData);
            $asnSubquery = DB::table('tbl_asn')
                ->selectRaw('CAST(SUM(dayPercent_dec) AS DECIMAL(9,1)) AS daysThisPeriod_dec')
                ->selectRaw('CAST(SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS DECIMAL(9,2)) AS predictedGP_dec')
                ->selectRaw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking_int')
                ->selectRaw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing_int')
                ->leftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                ->whereBetween('tbl_asnItem.asnDate_dte', [$weekStartDate, $plusFiveDate])
                ->first();

            $invoiceSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualGP_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoice.invoiceDate_dte', [$weekStartDate, $plusFiveDate])
                ->first();

            $billedSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualBilled_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoiceItem.dateFor_dte', [$weekStartDate, $plusFiveDate])
                ->first();

            // $sideBarData = DB::table(DB::raw("({$asnSubquery->toSql()}) AS t_asn"))
            //     ->mergeBindings($asnSubquery)
            //     ->join(DB::raw("({$invoiceSubquery->toSql()}) AS t_invoice"), function ($join) {
            //         $join->whereRaw('1 = 1');
            //     })
            //     ->mergeBindings($invoiceSubquery)
            //     ->join(DB::raw("({$billedSubquery->toSql()}) AS t_billed"), function ($join) {
            //         $join->whereRaw('1 = 1');
            //     })
            //     ->mergeBindings($billedSubquery)
            //     ->select([
            //         't_asn.daysThisPeriod_dec',
            //         't_asn.predictedGP_dec',
            //         't_asn.teachersWorking_int',
            //         't_asn.schoolsUsing_int',
            //         't_invoice.actualGP_dec',
            //         't_billed.actualBilled_dec',
            //     ])
            //     ->first();

            return view("web.dashboard", ['title' => $title, 'latestAssignment' => $latestAssignment, 'headerTitle' => $headerTitle, 'weekStartDate' => $weekStartDate, 'asnSubquery' => $asnSubquery, 'invoiceSubquery' => $invoiceSubquery, 'billedSubquery' => $billedSubquery]);
        } else {
            return redirect()->intended('/');
        }
    }
}
