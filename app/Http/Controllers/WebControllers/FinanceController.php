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
}
