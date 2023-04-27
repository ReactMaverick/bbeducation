<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class InvoiceExport implements FromCollection, WithHeadings
{
    use Exportable;
    private $from;
    private $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $invoicesList = DB::table('tbl_invoice')
            ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
            ->LeftJoin('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
            ->select('tbl_invoice.invoice_id AS InvoiceNo', 'name_txt AS Customer', DB::raw("DATE_FORMAT(invoiceDate_dte, '%d/%m/%Y') AS InvoiceDate"), DB::raw("DATE_FORMAT(DATE_ADD(invoiceDate_dte, INTERVAL 30 DAY), '%d/%m/%Y') AS DueDate"), DB::raw("'Net 30' AS Terms"), DB::raw("'' AS Memo"), DB::raw("'Teachers' AS prodOrService"), DB::raw("'Teachers' AS ItemDescription"), DB::raw("'' AS ItemQuantity"), DB::raw("'' AS ItemRate"), DB::raw("CAST(SUM(numItems_dec * charge_dec) AS DECIMAL(9,2)) AS ItemAmount"), DB::raw("'20%' AS ItemTaxCode"), DB::raw("CAST(SUM(numItems_dec * charge_dec) * .2 AS DECIMAL(9,2)) AS ItemTaxAmount"))
            ->whereBetween('tbl_invoice.invoiceDate_dte', [$this->from, $this->to])
            ->groupBy('tbl_invoice.invoice_id')
            ->get();
        return $invoicesList;
    }

    public function headings(): array
    {
        return [
            'InvoiceNo',
            'Customer',
            'InvoiceDate',
            'DueDate',
            'Terms',
            'Memo',
            'Item(Product/Service)',
            'ItemDescription',
            'ItemQuantity',
            'ItemRate',
            'ItemAmount',
            'ItemTaxCode',
            'ItemTaxAmount'
        ];
    }
}
