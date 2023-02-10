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
                echo $e;
                exit;
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
                echo $e;
                exit;
            }
        }
    }
}
