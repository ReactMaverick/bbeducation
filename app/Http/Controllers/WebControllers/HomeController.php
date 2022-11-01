<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        $title = array('pageTitle' => "Dashboard");

        return view("web.dashboard", ['title' => $title]);
    }
}
