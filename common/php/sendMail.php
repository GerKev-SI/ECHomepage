<?php
session_start();

function IsInjected($str)
{
    $injections = array('(\n+)',
           '(\r+)',
           '(\t+)',
           '(%0A+)',
           '(%0D+)',
           '(%08+)',
           '(%09+)'
           );

    $inject = join('|', $injections);
    $inject = "/$inject/i";

    return (preg_match($inject,$str));
}

// empty entspricht !isset($var) || $var==$false
if (empty($_POST['fname']) 
||  empty($_POST['lname']) 
||  empty($_POST['email']) 
||  empty($_POST['subject']) 
||  empty($_POST['message']) 
||  empty($_POST['captcha_challenge']) 
||  empty($_SESSION['captcha_text'])) 
 {
    error_log("Variable empty");
    header('Location: ../../index.html?contactresponse=failed#contact-section');
    exit;
}

if ($_POST['captcha_challenge'] != $_SESSION['captcha_text']) {
    error_log("captcha challenge not accepted");
    header('Location: ../../index.html?contactresponse=failed#contact-section');
    exit;
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
$fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
$lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
$usermessage = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
$usermessage = htmlspecialchars($usermessage);

// !== nutzen um nicht 0 als false zu verwenden
if (strpos($_SERVER['HTTP_HOST'], 'ec-hormersdorf.de') !== false) {
    $to = "leitung@ec-hormersdorf.de";
    $from = "kontaktformular@ec-hormersdorf.de";
} else if (strpos($_SERVER['HTTP_HOST'], 'lkg-hormersdorf.de') !== false)
{
    $to = "leitung@lkg-hormersdorf.de";
    $from = "kontaktformular@lkg-hormersdorf.de";
} else {
    error_log("unknown targetmail");
    header('Location: ../../index.html?contactresponse=failed#contact-section');
    exit;
}

$message = "Vorname: " . $fname . "\r\n";
$message .= "Nachname: " . $lname . "\r\n";
$message .= "Betreff: " . $subject . "\r\n";
$message .= "Email: " . $email . "\r\n";
$message .= "\r\n\r\n" . $usermessage;

$message = filter_var($message, FILTER_SANITIZE_STRING);
$message = wordwrap($message, 70, "\r\n");

if (IsInjected($email)){
    error_log("Email is injected");
    header('Location: ../../index.html?contactresponse=failed#contact-section');
    exit;
}

$headers  = "Content-type: text/plain; charset=utf-8" . "\r\n";
$headers .= "Reply-To: "     . $email                 . "\r\n";
$headers .= "From: "         . $from                  . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion()           . "\r\n";

$result = mail($to, $subject, $message, $headers);

header('Location: ../../index.html?contactresponse=succeeded#contact-section');
?>
