<?php

function sanitize_my_email($field) {
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);
    return (filter_var($field, FILTER_VALIDATE_EMAIL));
}

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

$to      = 'leitung@ec-hormersdorf.de';
$subject = $_POST['subject'];
$message = $_POST['fname'] . " " . $_POST['lname'] . " wrote the following:" . "\r\n" . $_POST['message'];
$message = filter_var($message, FILTER_SANITIZE_STRING);
$message = wordwrap($message, 70, "\r\n");
if (!IsInjected($_POST['email'])){
    $headers = "Content-type: text/plain; charset=utf-8" . "\r\n" .
            $_POST['email'] . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
}

$result = mail($to, $subject, $message, $headers);
//ob_start();
if ($result){
    echo '<script type="text/javascript">';
    echo ' alert("Message succesfully send")';  //not showing an alert box.
    echo '</script>';
} else {
    echo '<script type="text/javascript">';
    echo ' alert("Error sending message")';  //not showing an alert box.
    echo '</script>';
}

echo("<script>window.location = '../index.html';</script>");
//header("Location: index.html");
//ob_end_flush();
?>
