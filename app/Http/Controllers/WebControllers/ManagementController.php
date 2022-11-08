<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function management()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management";

        return view("web.management.index", ['title' => $title, 'headerTitle' => $headerTitle]);
    }
}
