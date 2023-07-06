<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MetricsExport;

class ManagementController extends Controller
{
    public function management()
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Management");
            $headerTitle = "Management";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $studentList = DB::table('tbl_student')
                ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
                ->where('tbl_student.is_delete', 0)
                ->orderBy('student_id', 'DESC')
                ->get();

            $now = Carbon::now();
            $startOfMonth = $now->startOfMonth()->format('Y-m-d');
            $endOfMonth = $now->endOfMonth()->format('Y-m-d');

            $asnSubquery = DB::table('tbl_asn')
                ->selectRaw('CAST(SUM(dayPercent_dec) AS DECIMAL(9,1)) AS daysThisPeriod_dec')
                ->selectRaw('CAST(SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS DECIMAL(9,2)) AS predictedGP_dec')
                ->selectRaw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking_int')
                ->selectRaw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing_int')
                ->leftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                ->whereBetween('tbl_asnItem.asnDate_dte', [$startOfMonth, $endOfMonth])
                ->first();

            $invoiceSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualGP_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoice.invoiceDate_dte', [$startOfMonth, $endOfMonth])
                ->first();

            $billedSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualBilled_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoiceItem.dateFor_dte', [$startOfMonth, $endOfMonth])
                ->first();

            // $metricsDetail = DB::table(DB::raw("({$asnSubquery->toSql()}) AS t_asn"))
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
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            return view("web.management.index", ['title' => $title, 'headerTitle' => $headerTitle, 'studentList' => $studentList, 'startOfMonth' => $startOfMonth, 'endOfMonth' => $endOfMonth, 'asnSubquery' => $asnSubquery, 'invoiceSubquery' => $invoiceSubquery, 'billedSubquery' => $billedSubquery, 'companyDetail' => $companyDetail]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function viewMetricsAjax(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $startOfMonth = date("Y-m-d", strtotime(str_replace('/', '-', $request->metricStartDate)));
            $endOfMonth = date("Y-m-d", strtotime(str_replace('/', '-', $request->metricEndDate)));

            $asnSubquery = DB::table('tbl_asn')
                ->selectRaw('CAST(SUM(dayPercent_dec) AS DECIMAL(9,1)) AS daysThisPeriod_dec')
                ->selectRaw('CAST(SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS DECIMAL(9,2)) AS predictedGP_dec')
                ->selectRaw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking_int')
                ->selectRaw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing_int')
                ->leftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                ->whereBetween('tbl_asnItem.asnDate_dte', [$startOfMonth, $endOfMonth])
                ->first();

            $invoiceSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualGP_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoice.invoiceDate_dte', [$startOfMonth, $endOfMonth])
                ->first();

            $billedSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualBilled_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoiceItem.dateFor_dte', [$startOfMonth, $endOfMonth])
                ->first();

            // $metricsDetail = DB::table(DB::raw("({$asnSubquery->toSql()}) AS t_asn"))
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

            return response()->json(['asnSubquery' => $asnSubquery, 'invoiceSubquery' => $invoiceSubquery, 'billedSubquery' => $billedSubquery]);
        } else {
            return 'login';
        }
    }

    public function viewMetricsExport(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $startOfMonth = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
            $endOfMonth = date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date)));

            $fileName = 'MetricsReport' . time() . '.xlsx';

            return Excel::download(new MetricsExport($company_id, $startOfMonth, $endOfMonth), $fileName);
        } else {
            return redirect()->intended('/');
        }
    }

    public function studentInsert(Request $request)
    {
        $student_id = DB::table('tbl_student')
            ->insertGetId([
                'firstName_txt' => $request->firstName_txt,
                'surname_txt' => $request->surname_txt,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        $studentList = DB::table('tbl_student')
            ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
            ->where('tbl_student.is_delete', 0)
            ->orderBy('student_id', 'DESC')
            ->get();

        $html = '';
        if (count($studentList) > 0) {
            foreach ($studentList as $key => $student) {
                $html .= "<tr class='school-detail-table-data selectStudentRow'
                            id='selectStudentRow$student->student_id' studentId='$student->student_id' firstName='$student->firstName_txt' surname='$student->surname_txt' isCurrent='$student->isCurrent_ysn'>
                            <td>$student->studentName_txt</td>
                            <td>$student->isCurrent_txt</td>
                        </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function studentUpdate(Request $request)
    {
        $isCurrent_ysn = 0;
        if ($request->isCurrent_ysn) {
            $isCurrent_ysn = -1;
        }
        DB::table('tbl_student')
            ->where('student_id', $request->student_id)
            ->update([
                'firstName_txt' => $request->firstName_txt,
                'surname_txt' => $request->surname_txt,
                'isCurrent_ysn' => $isCurrent_ysn
            ]);

        $studentList = DB::table('tbl_student')
            ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
            ->where('tbl_student.is_delete', 0)
            ->orderBy('student_id', 'DESC')
            ->get();

        $html = '';
        if (count($studentList) > 0) {
            foreach ($studentList as $key => $student) {
                $html .= "<tr class='school-detail-table-data selectStudentRow'
                            id='selectStudentRow$student->student_id' studentId='$student->student_id' firstName='$student->firstName_txt' surname='$student->surname_txt' isCurrent='$student->isCurrent_ysn'>
                            <td>$student->studentName_txt</td>
                            <td>$student->isCurrent_txt</td>
                        </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function studentDelete(Request $request)
    {
        DB::table('tbl_student')
            ->where('student_id', $request->studentId)
            ->update([
                'is_delete' => 1
            ]);

        $studentList = DB::table('tbl_student')
            ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
            ->where('tbl_student.is_delete', 0)
            ->orderBy('student_id', 'DESC')
            ->get();

        $html = '';
        if (count($studentList) > 0) {
            foreach ($studentList as $key => $student) {
                $html .= "<tr class='school-detail-table-data selectStudentRow'
                            id='selectStudentRow$student->student_id' studentId='$student->student_id' firstName='$student->firstName_txt' surname='$student->surname_txt' isCurrent='$student->isCurrent_ysn'>
                            <td>$student->studentName_txt</td>
                            <td>$student->isCurrent_txt</td>
                        </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function managementUser()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management User";

        return view("web.management.user", ['title' => $title, 'headerTitle' => $headerTitle]);
    }

    public function managementMailshot()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management Mailshot";

        return view("web.management.mailshot", ['title' => $title, 'headerTitle' => $headerTitle]);
    }
}
