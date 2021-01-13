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

function alert(){
    echo '<script type="text/javascript">';
    echo ' alert("Error sending message")';  //not showing an alert box.
    echo '</script>';
}
function success(){
    echo '<script type="text/javascript">';
    echo ' alert("Message succesfully send")';  //not showing an alert box.
    echo '</script>';
}

// empty entspricht !isset($var) || $var==$false
if (empty($_POST['targetemail'])
||  empty($_POST['fname']) 
||  empty($_POST['lname']) 
||  empty($_POST['email']) 
||  empty($_POST['subject']) 
||  empty($_POST['message']) 
||  empty($_POST['captcha_challenge']) 
||  empty($_SESSION['captcha_text'])) 
 {
    error_log("Variable empty");
    alert();
    echo("<script>window.location = '../../index.html';</script>");
    //header('Location: ../../index.html');
    exit;
}

if ($_POST['captcha_challenge'] != $_SESSION['captcha_text']) {
    error_log("captcha challenge not accepted");
    alert();
    echo("<script>window.location = '../../index.html';</script>");
    //header('Location: ../../index.html');
    exit;
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
$fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
$lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
$targetemail = filter_var($_POST['targetemail'], FILTER_SANITIZE_STRING);//'leitung@ec-hormersdorf.de'
$usermessage = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
$usermessage = htmlspecialchars($usermessage);

if ($targetemail === "EC") {
    $to = "leitung@ec-hormersdorf.de";
    $from = "kontaktformular@ec-hormersdorf.de";
} else if ($targetemail === "EC")
{
    $to = "leitung@lkg-hormersdorf.de";
    $from = "kontaktformular@lkg-hormersdorf.de";
} else {
    error_log("not allowed targetemail");
    alert();
    echo("<script>window.location = '../../index.html';</script>");
    //header('Location: ../../index.html');
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
    alert();
    echo("<script>window.location = '../../index.html';</script>");
    //header('Location: ../../index.html');
    exit;
}

$headers  = "Content-type: text/plain; charset=utf-8" . "\r\n";
$headers .= "Reply-To: "     . $email                 . "\r\n";
$headers .= "From: "         . $from                  . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion()           . "\r\n";

$result = mail($to, $subject, $message, $headers);

//header('Location: ../../index.html?contactresponse=failed#contact-section');
//header('Location: ../../index.html?contactresponse=succeeded#contact-section');
success();
echo("<script>window.location = '../../index.html';</script>");
?>
