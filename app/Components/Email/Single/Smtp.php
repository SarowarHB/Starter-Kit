<?php

namespace App\Components\Email\Single;

use Exception;
use Throwable;
use PHPMailer\PHPMailer\PHPMailer;
use App\Components\Email\EmailInterface;

/**
 * Handle smtp mail sending
 */
class Smtp implements EmailInterface
{
    /**
     * Send email
     *
     * @param array $args
     */
    public function send($args)
    {
        $mail = new PHPMailer(true);

      //  try {
            $mail->isSMTP();
            $mail->Host     = settings('mail_host');
            $mail->SMTPAuth = true;
            $mail->Username = settings('mail_user_name');
            $mail->Password = settings('mail_password');

            if (settings('encryption') == 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mail->Port     = settings('mail_port');
            $mail->CharSet  = 'UTF-8';
            $mail->setFrom(settings('mail_from'), settings('mail_from_name'));
            $mail->addAddress($args['email']);
            $mail->isHTML(true);
            $mail->Subject  = $args['subject'];
            $mail->Body     = $args['body'];
            $mail->send();
       // } catch (Throwable $th) {
           // throw new Exception($th);
       // }
    }
}
