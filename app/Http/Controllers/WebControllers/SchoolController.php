<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function schools()
    {
        $title = array('pageTitle' => "Schools");
        $headerTitle = "Schools";

        return view("web.school", ['title' => $title, 'headerTitle' => $headerTitle]);
    }
}
