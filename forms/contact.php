<?php
// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'deepbargal098contact@example.com';

// Path to the PHP Email Form library
$php_email_form_path = '../assets/vendor/php-email-form/php-email-form.php';

// Check if the PHP Email Form library exists
if (file_exists($php_email_form_path)) {
    require_once($php_email_form_path);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form();


// Validate and sanitize form inputs
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

// Validate email
if (!$email) {
    die('Invalid email address.');
}

$contact->to = $receiving_email_address;
$contact->from_name = $name;
$contact->from_email = $email;
$contact->subject = $subject;

// Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
/*
$contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
);
*/

$contact->add_message($name, 'From');
$contact->add_message($email, 'Email');
$contact->add_message($message, 'Message', 10);

try {
    $send_result = $contact->send();
    if ($send_result === true) {
        echo 'Message sent successfully!';
    } else {
        echo 'Message could not be sent.';
    }
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
?>
