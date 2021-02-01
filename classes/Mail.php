<?php

class Mail implements MailInterface{

    public function sendMail($sender, $sender_email, $recipient, $subject, $message)
    {
       $to = $recipient;
       $subject = $subject;
       $from = $sender_email;

       //setting content header
       $headers = 'MIME-Version: 1.0' . "\r\n";
       $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

       // create email headers
       $headers .= 'From: '.$from."\r\n".
                   'Reply-To: '.$from."\r\n".
                   'Return-Path: kondishiva007@gmail.com'."\r\n".
                   'CC: kondishiva007@gmail.com'."\r\n".
                   'BCC: kondishiva007@gmail.com'."\r\n".
                   'X-Mailer: PHP/'.phpversion();

      $body = '<html><body>';
      $body .= $message;
      $body .= '</body></html>';


      if (mail($to, $subject, $body, $headers)){
        return 'sent';
      }else{
        return 'failed';
      }

    }


}


?>
