<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mail;

class AlertController extends Controller
{
    public function test_mail($mail)
    {
        if ($mail) {
            try {
                Mail::send('/mail/testmail', ['mail' => $mail], function ($m) use ($mail) {
                    $m->to($mail)->subject("Password reset link")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function reset_password($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/resetPasswordMail', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])->subject("Password reset link")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function school_reset_password($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/resetPasswordMailSchool', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])->subject("Password reset link")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function sendToSchoolApproval($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/timesheet_approval', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])->subject("Timesheet For Approval")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function sendToSchoolTeacherItemSheet($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/teacher_timesheet_approval', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])->subject("Timesheet For Approval")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function sendInvoiceToSchool($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/school_invoice', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])
                        ->subject($mailData['subject'])
                        ->attach($mailData['invoice_path'], ['as' => $mailData['invoice_name']])
                        ->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function sendVettingMail($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/candidate_vetting', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])
                        ->cc($mailData['cc_mail'])
                        ->subject($mailData['subject'])
                        ->attach($mailData['invoice_path'], ['as' => $mailData['subject']])
                        ->attach($mailData['invoice_path2'], ['as' => "Candidate Timesheet"])
                        ->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function sendTeacherVettingMail($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/teacher_candidate_vetting', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])
                        ->subject($mailData['subject'])
                        ->attach($mailData['invoice_path'], ['as' => "Candidate Timesheet"])
                        ->attach($mailData['invoice_path2'], ['as' => $mailData['subject']])
                        ->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function sendSchFinanceInvoiceMail($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/sch_finance_invoice', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])
                        ->subject($mailData['subject'])
                        ->attach($mailData['invoice_path'], ['as' => $mailData['subject']])
                        ->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }
}
