<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\WebControllers\AlertController;

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
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            if ($request->date) {
                $weekStartDate = $request->date;
            } else {
                $now = Carbon::now();
                $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            }
            $plusFiveDate = date('Y-m-d', strtotime($weekStartDate . ' +4 days'));
            $plusSevenDate = date('Y-m-d', strtotime($weekStartDate . ' +6 days'));

            $latestAssignment = DB::table('tbl_asn')
                ->LeftJoin('tbl_asnItem', 'tbl_asnItem.asn_id', '=', 'tbl_asn.asn_id')
                ->LeftJoin('tbl_teacher', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_asn.teacher_id')
                ->LeftJoin('tbl_school', 'tbl_school.school_id', '=', 'tbl_asn.school_id')
                ->leftJoin(
                    DB::raw('(SELECT asn_id, SUM(tbl_asnItem.dayPercent_dec) as daysOfWeek FROM tbl_asnItem GROUP BY tbl_asnItem.asn_id) AS days_asnItems'),
                    function ($join) {
                        $join->on('tbl_asn.asn_id', '=', 'days_asnItems.asn_id');
                    }
                )
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
                ->select('tbl_asn.*', 'tbl_teacher.firstName_txt as techerFirstname', 'tbl_teacher.surname_txt as techerSurname', 'tbl_school.name_txt as schooleName', 'tbl_teacherdbs.positionAppliedFor_txt', 'days_asnItems.daysOfWeek as daysThisWeek', DB::raw('SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS predictedGP'), DB::raw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking'), DB::raw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing'), 'assStatusDescription.description_txt as assignmentStatus', 'teacherProff.description_txt as teacherProfession')
                // ->where('tbl_asn.status_int', 2)
                ->where('tbl_asn.company_id', $company_id)
                // ->where('tbl_teacher.is_delete', 0)
                // ->whereDate('tbl_asnItem.asnDate_dte', '>=', $weekStartDate)
                // ->whereDate('tbl_asnItem.asnDate_dte', '<=', $plusFiveDate)
                ->groupBy('tbl_asn.asn_id')
                ->orderBy('tbl_asn.timestamp_ts', 'DESC')
                ->limit(100)
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
                ->whereBetween('tbl_asnItem.asnDate_dte', [$weekStartDate, $plusSevenDate])
                ->first();

            $invoiceSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualGP_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoice.invoiceDate_dte', [$weekStartDate, $plusSevenDate])
                ->first();

            $billedSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualBilled_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoiceItem.dateFor_dte', [$weekStartDate, $plusSevenDate])
                ->first();

            $resultNew = DB::table(DB::raw("(SELECT
                    CAST(SUM(dayPercent_dec) AS DECIMAL(9,1)) AS daysThisPeriod_dec,
                    CAST(SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS DECIMAL(9,2)) AS predictedGP_dec,
                    COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking_int,
                    COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing_int
                    FROM
                    tbl_asn
                    LEFT JOIN tbl_asnItem ON tbl_asn.asn_id = tbl_asnItem.asn_id
                    WHERE
                    tbl_asn.status_int = 3
                    AND tbl_asnItem.asnDate_dte BETWEEN ? AND ?) AS t_asn"))
                ->crossJoin(DB::raw("(SELECT 
                        IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualGP_dec
                    FROM
                        tbl_invoice
                    LEFT JOIN tbl_invoiceItem ON tbl_invoice.invoice_id = tbl_invoiceItem.invoice_id
                    WHERE
                        tbl_invoice.invoiceDate_dte BETWEEN ? AND ?) AS t_invoice"))
                ->crossJoin(DB::raw("(SELECT 
                        IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualBilled_dec
                    FROM
                        tbl_invoice
                    LEFT JOIN tbl_invoiceItem ON tbl_invoice.invoice_id = tbl_invoiceItem.invoice_id
                    WHERE
                        tbl_invoiceItem.dateFor_dte BETWEEN ? AND ?) AS t_billed"))
                ->select([
                    't_asn.daysThisPeriod_dec',
                    't_asn.predictedGP_dec',
                    't_asn.teachersWorking_int',
                    't_asn.schoolsUsing_int',
                    't_invoice.actualGP_dec',
                    't_billed.actualBilled_dec',
                ])
                ->setBindings([$weekStartDate, $plusSevenDate, $weekStartDate, $plusSevenDate, $weekStartDate, $plusSevenDate])
                ->get();

            // echo "<pre>";
            // print_r($resultNew);
            // exit;



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

            // dbs expire mail
            $adminMail = $webUserLoginData->user_name;
            // $adminMail = 'sanjoy.websadroit@gmail.com';
            $twentyOneDaysBeforeToday = Carbon::now()->toDateString();

            $expiredCertificates = DB::table('tbl_teacher')
                ->join('tbl_teacherdbs', 'tbl_teacherdbs.teacher_id', '=', 'tbl_teacher.teacher_id')
                ->select('tbl_teacher.*', 'tbl_teacherdbs.DBSDate_dte', 'tbl_teacherdbs.certificateNumber_txt', DB::raw('DATE_ADD(tbl_teacherdbs.DBSDate_dte, INTERVAL 3 YEAR) AS expiry_date'))
                ->whereRaw('DATE_SUB(DATE_ADD(tbl_teacherdbs.DBSDate_dte, INTERVAL 3 YEAR), INTERVAL -21 DAY) = ?', [$twentyOneDaysBeforeToday])
                // ->where('tbl_teacher.is_delete', 0)
                ->where('tbl_teacher.isCurrent_status', '<>', 0)
                ->where('tbl_teacher.company_id', $company_id)
                ->get();
            // echo "<pre>";
            // print_r($expiredCertificates);
            // exit;
            $mail_is_sent = DB::table('dbs_expire_mail')
                ->where('date', date('Y-m-d'))
                ->where('mail_id', $adminMail)
                ->where('company_id', $company_id)
                ->first();

            if (count($expiredCertificates) > 0 && !$mail_is_sent) {
                DB::table('dbs_expire_mail')
                    ->insertGetId([
                        'date' => date('Y-m-d'),
                        'mail_id' => $adminMail,
                        'company_id' => $company_id,
                        'timestamp_ts' => date('Y-m-d H:i:s')
                    ]);

                $mailData['subject'] = "Candidate DBS Record";
                $mailData['mail'] = $adminMail;
                $mailData['companyDetail'] = $companyDetail;
                $mailData['name'] = $webUserLoginData->firstName_txt . ' ' . $webUserLoginData->surname_txt;
                $mailData['expiredCertificates'] = $expiredCertificates;
                $myVar = new AlertController();
                $myVar->dbsExpireAdmin($mailData);
            }

            return view("web.dashboard", ['title' => $title, 'latestAssignment' => $latestAssignment, 'headerTitle' => $headerTitle, 'weekStartDate' => $weekStartDate, 'asnSubquery' => $asnSubquery, 'invoiceSubquery' => $invoiceSubquery, 'billedSubquery' => $billedSubquery]);
        } else {
            return redirect()->intended('/');
        }
    }
}
