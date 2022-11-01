<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function teachers()
    {
        $title = array('pageTitle' => "Teachers");

        return view("web.teacher", ['title' => $title]);
    }
}
