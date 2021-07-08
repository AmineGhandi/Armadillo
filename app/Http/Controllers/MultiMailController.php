<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UtilisateursController;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MultiMailController extends Controller
{
    function index(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $utilisateurs = Utilisateurs::all();
        return view('multimail.index', $data, compact('utilisateurs'));
    }

    function send(Request $request){
        // dd($request);
        // exit;
        $name = $request ->name;
        $email = $request ->email;
                 $request ->bcc[0];
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
        for ($i=0; $i < count($request ->bcc); $i++) { 
            // $mail->addBCC($request ->email[$i]);
            $mail->addBCC($request ->bcc[$i]);
            
        }

        $mail->isHTML(true);
        $mail->Subject =  $subject;
        $mail->Body    = $message;
        $dt = $mail->send();
        $mail ->smtpClose();
        if($dt){
            return back()->with("success", "Email has been sent.");
        } else{
            echo 'Something went wrong';
        }
}
}