<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UtilisateursController;
use App\Models\Clients;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
    function index(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $clients = Clients::all();
        return view('email.index', $data, compact('clients'));
    }

    function send(Request $request){

        $name = "ARMADILLO";
        $email = $request ->email;
        $subject = $request ->subject;
        $msg = $request ->message;


        $message = file_get_contents('emaill/email_template.html');

        $message = str_replace('%message%', $msg , $message);
        
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


        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $msg;
        $mail->MsgHTML($message);
        $dt = $mail->send();
        $mail ->smtpClose();
        if($dt){
            return back()->with("success", "Email has been sent.");
        } else{
            echo 'Something went wrong';
        }

}
function indexsup(){
    $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
    $clients = Clients::all();
    return view('supervisor.email', $data, compact('clients'));
}
function indexagentm(){
    $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
    $clients = Clients::all();
    return view('mail.email', $data, compact('clients'));
}
}
