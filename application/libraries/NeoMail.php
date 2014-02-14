<?php
/* 
 * Mail Service
 * @author Bardsa Catalin
 */

class NeoMail {

  

    public static function check_email($email) {

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function genericMail($body, $subject, $email) {
        require_once 'Swift_ssl/swift_required.php';
        $transport = \Swift_SmtpTransport::newInstance('84.247.70.38', 25)
                ->setUsername('oringo')
                ->setPassword('atitudine');
        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance($subject)
                ->setContentType("text/html")
                ->setFrom(array('comenzi@oringo.ro' => 'Oringo'))
                ->setTo(array($email))
                ->setBody($body);
        $result = $mailer->send($message);
    }

    public static function genericMailAttach($body, $subject, $email, $attach) {
        if (self::check_email($email)) {
            require_once 'Swift_ssl/swift_required.php';
            $transport = \Swift_SmtpTransport::newInstance('84.247.70.38', 25)
                    ->setUsername('oringo')
                    ->setPassword('atitudine');
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance($subject)
                    ->setContentType("text/html")
                    ->setFrom(array('comenzi@oringo.ro' => 'Oringo'))
                    ->setTo(array($email))
                    ->setBody($body);

            foreach ($attach as $key => $att) {
                $message->attach(\Swift_Attachment::fromPath($attach[$key]));
            }

            $result = $mailer->send($message);
        } else {
            //invalid email
        }
    }

}

?>
