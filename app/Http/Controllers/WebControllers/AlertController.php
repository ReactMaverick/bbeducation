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

    public function mailAdminAfterApproval($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/admin_mail_after_approve', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])->subject("Timesheet Approved By School")->getSwiftMessage()
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

    public function sendToSchoolTimeSheet($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/log_timesheet_approval', ['mailData' => $mailData], function ($m) use ($mailData) {
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
                        ->attach($mailData['invoice_path'], ['as' => $mailData['invoice_name'] . ".pdf"])
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
        if (!empty($mailData['mail'])) {
            try {
                Mail::send('mail.candidate_vetting', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])
                        ->cc($mailData['cc_mail'])
                        ->subject($mailData['subject'])
                        ->attach($mailData['invoice_path'], ['as' => $mailData['subject'] . '.pdf'])
                        // ->attach($mailData['invoice_path2'], ['as' => 'Candidate Timesheet.pdf'])
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
                        // ->cc("kumarbarun137@gmail.com")
                        ->subject($mailData['subject'])
                        // ->attach($mailData['invoice_path'], ['as' => "Candidate Timesheet.pdf"])
                        // ->attach($mailData['invoice_path2'], ['as' => $mailData['subject'] . ".pdf"])
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
                        ->attach($mailData['invoice_path'], ['as' => $mailData['pdfName']])
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

    public function sendSchRemitInvoiceMail($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/sch_finance_invoice', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])
                        ->subject($mailData['subject'])
                        ->attach($mailData['invoice_path'], ['as' => $mailData['pdfName']])
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

    public function sendSchOverdueInvoiceMail($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/sch_overdue_invoice', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])
                        ->subject($mailData['subject']);
                    foreach ($mailData['fileArr'] as $file) {
                        $m->attach($file['invoice_path'], ['as' => $file['name']]);
                    }
                    $m->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function sendSchAccountSummary($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/sch_account_summary', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])
                        ->subject($mailData['subject']);
                    foreach ($mailData['fileArr'] as $file) {
                        $m->attach($file['invoice_path'], ['as' => $file['name']]);
                    }
                    $m->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function referenceRequestMail($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/reference_request', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])->subject($mailData['subject'])->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function referenceReceivedToAdmin($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/admin_ref_received', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])
                        ->subject($mailData['subject'])
                        ->attach($mailData['invoice_path'], ['as' => $mailData['subject'] . ".pdf"])
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

    public function dbsExpireAdmin($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/dbs_expire_admin', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])->subject($mailData['subject'])->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                // echo $e;
                // exit;
            }
        }
    }

    public function fPasswordOtpAlert($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/tForgetPasswordMail', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])->subject("Forgot Password")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            } catch (\Exception $e) {
                echo $e;
                exit;
            }
        }
    }

    public function adminUserAddMail($mailData)
    {
        if ($mailData['mail']) {
            try {
                Mail::send('/mail/adminUser_mail', ['mailData' => $mailData], function ($m) use ($mailData) {
                    $m->to($mailData['mail'])->subject("Successfully added as Admin")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
                return true;
            } catch (\Exception $e) {
                echo $e;
                return false;
                exit;
            }
        }
    }

}
