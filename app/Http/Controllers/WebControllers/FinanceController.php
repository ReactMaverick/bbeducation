<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function finance()
    {
        $title = array('pageTitle' => "Finance");

        return view("web.finance", ['title' => $title]);
    }
}
