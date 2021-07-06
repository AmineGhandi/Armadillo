<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UtilisateursController;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
    function index(){
        return view('email.index');
    }
    function send(Request $request){
        $name = $request ->name;
        $email = $request ->email;
        $bcc = $request ->bcc;
        $subject = $request ->subject;
        $message = $request ->message;


        require 'PHPMailer/vendor/autoload.php';
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;                                      
        $mail->isSMTP();                                          
        $mail->Host       = env('EMAIL_HOST');                 
        $mail->SMTPAuth   = true;                
        $mail->Username   = env('EMAIL_USERNAME');                  
        $mail->Password   = env('EMAIL_PASSWORD');                              
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;
        $mail->setFrom($email, $name); 
        $mail->addAddress($email);
        $mail->addBCC($bcc);

        $mail->isHTML(true);  
        $mail->Subject =  $subject;
        $mail->Body    = $message;
        $dt = $mail->send();
        $mail ->smtpClose();
        if( !$mail->send() ) {
            return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
           
        }else {
            return back()->with("success", "Email has been sent.");
        }
    }
}
