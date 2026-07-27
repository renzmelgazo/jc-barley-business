<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

$mailConfig = require __DIR__ . '/mail.php';

function getMailer()
{
    global $mailConfig;

    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Host = $mailConfig['host'];

    $mail->SMTPAuth = true;

    $mail->Username = $mailConfig['username'];

    $mail->Password = $mailConfig['password'];

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = $mailConfig['port'];

    $mail->CharSet = "UTF-8";

    $mail->setFrom(

        $mailConfig['from_email'],

        $mailConfig['from_name']

    );

    $mail->isHTML(true);

    return $mail;
}