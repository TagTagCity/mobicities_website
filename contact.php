<?php

require("sendgrid-php/sendgrid-php.php");

$sendgrid = new SendGrid('tagtagcity','tagtag2014',array("turn_off_ssl_verification" => true));

/* Check all form inputs using check_input function */
$yourname = check_input($_POST['name'], "Enter your name");
$phone  = check_input($_POST['phone']);
$email    = check_input($_POST['email'], "Enter your email");
$message  = check_input($_POST['message'], "Enter your message");

/* If e-mail is not valid show error message */
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
{
    show_error("E-mail address not valid");
}

/* Let's prepare the message for the e-mail */
$message = "Hello!

Your contact form has been submitted by:

Name: $yourname
E-mail: $email
Phone: $phone


Message:
$message

End of message
";

/* Send the message using mail() function */
$email = new SendGrid\Email();
$email->addTo('mathieu@tagtagcity.com')->
    setFrom('info@mobicities.com')->
    setSubject('Request for information from MobiCities website')->
    setText($message);

$sendgrid->send($email);

/* Redirect visitor to the thank you page*/
//header('Location: http://www.mobicities.be');
//exit();

/* Functions we used */
function check_input($data, $problem='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}

function show_error($myError)
{
?>
    <html>
    <body>

    <b>Please correct the following error:</b><br />
    <?php echo $myError; ?>

    </body>
    </html>
<?php
exit();
}
?>
