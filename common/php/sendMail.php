<?php
$message = "0";
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
//ab hier nur fuer PHP <5.2
if (preg_match("/^[a-zA-Z-' ]*$/",$_POST['fname'])) {
  if (preg_match("/^[a-zA-Z-' ]*$/",$_POST['lname'])) {
    if (preg_match("/^[a-zA-Z-_\,\.\!' \?]*$/",$_POST['message'])) {
      $message = $_POST['fname'] . " " . $_POST['lname'] . " wrote the following:" . "\r\n" . $_POST['message'];
    }
  }
}
//$message = filter_var($message, FILTER_SANITIZE_STRING);
$message = wordwrap($message, 70, "\r\n");

//ab hier nur fuer PHP <5.2
if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$_POST['email'])) {
  $email = $_POST['email'];
}
//$email  = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if (!IsInjected($email)){
    $headers  = 'Content-type: text/plain; charset=utf-8' . '\r\n'.
                'From: '         . $from                  . '\r\n'.
                'Reply-To: '     . $email                 . '\r\n'.
                'X-Mailer: PHP/' . phpversion();
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
