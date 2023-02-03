<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use PDF;

class FinanceController extends Controller
{
    public function finance(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.finance.index", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeTimesheets(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance Timesheets");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.finance.finance_timesheet", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeInvoices(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance Invoices");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.finance.finance_invoice", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financePayroll(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance Payroll");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            return view("web.finance.finance_payroll", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeRemittance(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Finance Remittance");
            $headerTitle = "Finance";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $Invoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->LeftJoin('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->LeftJoin('tbl_user as paymentLoggedTbl', 'tbl_invoice.paymentLoggedBy_id', '=', 'paymentLoggedTbl.user_id')
                ->LeftJoin('tbl_user as senderTbl', 'tbl_invoice.sentBy_int', '=', 'senderTbl.user_id')
                ->select('tbl_invoice.invoice_id', 'tbl_invoice.school_id', 'tbl_invoice.invoiceDate_dte As invoice_dte', 'tbl_school.name_txt As school_txt', 'tbl_invoice.paidOn_dte As paid_dte', DB::raw("CONCAT(paymentLoggedTbl.firstName_txt, ' ', paymentLoggedTbl.surname_txt) As remittee_txt"), 'tbl_invoice.sentOn_dte As sent_dte', DB::raw("CONCAT(senderTbl.firstName_txt, ' ', senderTbl.surname_txt) As sender_txt"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec"), DB::raw("ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec"));
            if ($request->include == '') {
                $Invoices->where('tbl_invoice.paidOn_dte', NULL);
            }
            if ($request->method) {
                $Invoices->where('tbl_invoice.paymentMethod_int', $request->method);
            }
            $remitInvoices = $Invoices->groupBy('tbl_invoice.invoice_id')
                ->get();

            $paymentMethodList = DB::table('tbl_description')
                ->select('tbl_description.*')
                ->where('tbl_description.descriptionGroup_int', 42)
                ->get();

            return view("web.finance.finance_remittance", ['title' => $title, 'headerTitle' => $headerTitle, 'remitInvoices' => $remitInvoices, 'paymentMethodList' => $paymentMethodList]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function financeInvoicePdf(Request $request, $invoice_id)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $schoolInvoices = DB::table('tbl_invoice')
                ->LeftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->select('tbl_invoice.*', DB::raw('ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec), 2) As net_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As vat_dec,
                ROUND(SUM(tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec + tbl_invoiceItem.charge_dec * tbl_invoiceItem.numItems_dec * vatRate_dec / 100), 2) As gross_dec'))
                ->where('tbl_invoice.invoice_id', $invoice_id)
                ->groupBy('tbl_invoice.invoice_id')
                ->first();
            $invoiceItemList = DB::table('tbl_invoiceItem')
                ->select('tbl_invoiceItem.*')
                ->where('tbl_invoiceItem.invoice_id', $invoice_id)
                ->orderBy('tbl_invoiceItem.dateFor_dte', 'ASC')
                ->get();

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
                ->where('tbl_school.school_id', $schoolInvoices->school_id)
                ->orderBy('tbl_schoolContactLog.schoolContactLog_id', 'DESC')
                ->first();

            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            $pdf = PDF::loadView('web.school.school_invoice_pdf', ['schoolDetail' => $schoolDetail, 'schoolInvoices' => $schoolInvoices, 'invoiceItemList' => $invoiceItemList, 'companyDetail' => $companyDetail]);
            $pdfName = 'invoice-' . $invoice_id . '.pdf';
            // return $pdf->download('test.pdf');
            return $pdf->stream($pdfName);
        } else {
            return redirect()->intended('/');
        }
    }
}
