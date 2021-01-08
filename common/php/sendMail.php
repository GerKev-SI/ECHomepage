<?php
$message = "";
$email = "0";
$subject = "0";
$fname = "0";
$lname = "0";
$from = "0";
$to = "0";

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

$to      = $_POST['targetemail']; //'leitung@ec-hormersdorf.de'
$from    = $_POST['frommail']; //kontaktformular@ec-hormersdorf.de
$subject = $_POST['subject'];

$message = "Vorname: " . $_POST['fname'] . "\r\n";
$message .= "Nachname: " . $_POST['lname'] . "\r\n";
$message .= "Email: " . $_POST['email'] . "\r\n";
$message .= "\r\n\r\n" . $_POST['message'];

$message = filter_var($message, FILTER_SANITIZE_STRING);
$message = wordwrap($message, 70, "\r\n");

$email  = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

if (!IsInjected($email)){
    $headers  = "Content-type: text/plain; charset=utf-8" . "\r\n";
    $headers .= "Reply-To: "     . $email                 . "\r\n";
    $headers .= "From: "         . $from                  . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion()           . "\r\n";
}

if (!(empty($message) or empty($email))){
  $result = mail($to, $subject, $message, $headers);
}

if ($result){
    echo '<script type="text/javascript">';
    echo ' alert("Message succesfully send")';  //not showing an alert box.
    echo '</script>';
} else {
    echo '<script type="text/javascript">';
    echo ' alert("Error sending message")';  //not showing an alert box.
    echo '</script>';
}

echo("<script>window.location = '../../index.html';</script>");
?>
