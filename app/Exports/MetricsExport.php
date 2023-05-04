<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use stdClass;

class MetricsExport implements FromCollection, WithHeadings
{
    use Exportable;
    private $company_id;
    private $startOfMonth;
    private $endOfMonth;

    public function __construct($company_id, $startOfMonth, $endOfMonth)
    {
        $this->company_id = $company_id;
        $this->startOfMonth = $startOfMonth;
        $this->endOfMonth = $endOfMonth;
    }

    public function collection()
    {
        $asnSubquery = DB::table('tbl_asn')
            ->selectRaw('CAST(SUM(dayPercent_dec) AS DECIMAL(9,1)) AS daysThisPeriod_dec')
            ->selectRaw('CAST(SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS DECIMAL(9,2)) AS predictedGP_dec')
            ->selectRaw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking_int')
            ->selectRaw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing_int')
            ->leftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->where('tbl_asn.status_int', 3)
            ->where('tbl_asn.company_id', $this->company_id)
            ->whereBetween('tbl_asnItem.asnDate_dte', [$this->startOfMonth, $this->endOfMonth])
            ->first();

        $invoiceSubquery = DB::table('tbl_invoice')
            ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualGP_dec')
            ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
            ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
            ->where('tbl_school.company_id', $this->company_id)
            ->whereBetween('tbl_invoice.invoiceDate_dte', [$this->startOfMonth, $this->endOfMonth])
            ->first();

        $billedSubquery = DB::table('tbl_invoice')
            ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualBilled_dec')
            ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
            ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
            ->where('tbl_school.company_id', $this->company_id)
            ->whereBetween('tbl_invoiceItem.dateFor_dte', [$this->startOfMonth, $this->endOfMonth])
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
        //         't_asn.teachersWorking_int',
        //         't_asn.schoolsUsing_int',
        //         't_asn.predictedGP_dec',
        //         't_billed.actualBilled_dec',
        //         't_invoice.actualGP_dec',
        //     ])
        //     ->get();
        $metricsDetail = array();
        $obj = new stdClass();
        $obj->daysThisPeriod_dec = $asnSubquery->daysThisPeriod_dec;
        $obj->teachersWorking_int = $asnSubquery->teachersWorking_int;
        $obj->schoolsUsing_int = $asnSubquery->schoolsUsing_int;
        $obj->predictedGP_dec = $asnSubquery->predictedGP_dec;
        $obj->actualBilled_dec = $billedSubquery->actualBilled_dec;
        $obj->actualGP_dec = $invoiceSubquery->actualGP_dec;
        array_push($metricsDetail, $obj);
        // echo "<pre>";
        // print_r($metricsDetail);
        // exit;
        $metricsDetail = collect($metricsDetail);

        return $metricsDetail;
    }

    public function headings(): array
    {
        return [
            'Total Days',
            'Teachers Working',
            'School using BB',
            'Predicted GP',
            'Billed GP',
            'Total Turnover',
        ];
    }
}
