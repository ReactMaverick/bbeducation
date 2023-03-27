<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class PayrollExport implements FromCollection, WithHeadings
{
    use Exportable;
    private $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        $paySummaryList = DB::table('tbl_teacher')
            ->LeftJoin('tbl_asn', 'tbl_teacher.teacher_id', '=', 'tbl_asn.teacher_id')
            ->LeftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
            ->LeftJoin('tbl_payrollRun', 'tbl_asnItem.payroll_id', '=', 'tbl_payrollRun.payroll_id')
            ->select('RACSnumber_txt', DB::raw("IF(knownAs_txt IS NULL OR knownAs_txt = '', firstName_txt, CONCAT(firstName_txt, ' (', knownAs_txt, ') ')) AS 'FirstName'"), 'surname_txt AS Surname', DB::raw("SUM(dayPercent_dec) AS Items"), 'tbl_asnItem.cost_dec AS Rate')
            // ->select('RACSnumber_txt', DB::raw("IF(knownAs_txt IS NULL OR knownAs_txt = '', firstName_txt, CONCAT(firstName_txt, ' (', knownAs_txt, ') ')) AS 'FirstName'"), 'surname_txt AS Surname', DB::raw("CAST(SUM(dayPercent_dec) * 6 AS DECIMAL(6,2)) AS Items"), DB::raw("CAST(tbl_asnItem.cost_dec / 6 AS DECIMAL(6,2)) AS Rate"))
            ->where('tbl_asnItem.payroll_id', '!=', NULL)
            ->whereDate('tbl_payrollRun.payDate_dte', '=', $this->date)
            ->groupBy('tbl_teacher.teacher_id')
            ->groupBy('tbl_asnItem.cost_dec')
            ->get();
        return $paySummaryList;
    }

    public function headings(): array
    {
        return [
            'Payroll Number',
            'First Name',
            'Surname',
            'Items',
            'Rate',
        ];
    }
}
