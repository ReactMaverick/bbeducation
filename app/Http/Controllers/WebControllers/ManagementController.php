<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagementController extends Controller
{
    public function management()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management";

        $studentList = DB::table('tbl_student')
            ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
            ->orderBy('student_id', 'DESC')
            ->get();

        return view("web.management.index", ['title' => $title, 'headerTitle' => $headerTitle, 'studentList' => $studentList]);
    }

    public function studentInsert(Request $request)
    {
        $student_id = DB::table('tbl_student')
            ->insertGetId([
                'firstName_txt' => $request->firstName_txt,
                'surname_txt' => $request->surname_txt,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        $studentList = DB::table('tbl_student')
            ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
            ->orderBy('student_id', 'DESC')
            ->get();

        $html = '';
        if (count($studentList) > 0) {
            foreach ($studentList as $key => $student) {
                $html .= "<tr class='school-detail-table-data selectStudentRow'
                            id='selectStudentRow$student->student_id' studentId='$student->student_id' firstName='$student->firstName_txt' surname='$student->surname_txt' isCurrent='$student->isCurrent_ysn'>
                            <td>$student->studentName_txt</td>
                            <td>$student->isCurrent_txt</td>
                        </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function studentUpdate(Request $request)
    {
        $isCurrent_ysn = 0;
        if ($request->isCurrent_ysn) {
            $isCurrent_ysn = -1;
        }
        DB::table('tbl_student')
            ->where('student_id', $request->student_id)
            ->update([
                'firstName_txt' => $request->firstName_txt,
                'surname_txt' => $request->surname_txt,
                'isCurrent_ysn' => $isCurrent_ysn
            ]);

        $studentList = DB::table('tbl_student')
            ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
            ->orderBy('student_id', 'DESC')
            ->get();

        $html = '';
        if (count($studentList) > 0) {
            foreach ($studentList as $key => $student) {
                $html .= "<tr class='school-detail-table-data selectStudentRow'
                            id='selectStudentRow$student->student_id' studentId='$student->student_id' firstName='$student->firstName_txt' surname='$student->surname_txt' isCurrent='$student->isCurrent_ysn'>
                            <td>$student->studentName_txt</td>
                            <td>$student->isCurrent_txt</td>
                        </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function managementUser()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management User";

        return view("web.management.user", ['title' => $title, 'headerTitle' => $headerTitle]);
    }

    public function managementMailshot()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management Mailshot";

        return view("web.management.mailshot", ['title' => $title, 'headerTitle' => $headerTitle]);
    }
}
