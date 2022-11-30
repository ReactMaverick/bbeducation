<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function finance()
    {
        $title = array('pageTitle' => "Finance");
        $headerTitle = "Finance";

        return view("web.finance.index", ['title' => $title, 'headerTitle' => $headerTitle]);
    }

    public function financeTimesheets()
    {
        $title = array('pageTitle' => "Finance");
        $headerTitle = "Finance Timesheets";

        return view("web.finance.finance_timesheet", ['title' => $title, 'headerTitle' => $headerTitle]);
    }

    public function financeInvoices()
    {
        $title = array('pageTitle' => "Finance");
        $headerTitle = "Finance Invoices";

        return view("web.finance.finance_invoice", ['title' => $title, 'headerTitle' => $headerTitle]);
    }

    public function financePayroll()
    {
        $title = array('pageTitle' => "Finance");
        $headerTitle = "Finance Payroll";

        return view("web.finance.finance_payroll", ['title' => $title, 'headerTitle' => $headerTitle]);
    }

    public function financeRemittance()
    {
        $title = array('pageTitle' => "Finance");
        $headerTitle = "Finance Remittance";

        return view("web.finance.finance_remittance", ['title' => $title, 'headerTitle' => $headerTitle]);
    }

}
