<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

$mail = new PHPMailer(true);


try {
    // server settings
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Port = 587;
$mail->Username = 'datetoffee@gmail.com';
$mail->Password = 'qpmrapgoxfznezhi';
$mail->SMTPSecure = 'tls';

    
    // recipients
    $mail->setFrom('datetoffee@gmail.com');
    $mail->addAddress('salma.shah.0516@gmail.com');

    // content
    $mail->isHTML(true);
    $mail->Subject = 'Test Mail vis Gmail STMPT';
    $mail->Body    = 'HEEEELOOOOo bello';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
