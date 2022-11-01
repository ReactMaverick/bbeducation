<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function assignments()
    {
        $title = array('pageTitle' => "Assignments");
        $headerTitle = "Assignments";

        return view("web.assignment", ['title' => $title, 'headerTitle' => $headerTitle]);
    }
}
