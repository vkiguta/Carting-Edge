<?php

// Clean up the input values
foreach ($_POST as $key => $value) {
    if (ini_get('magic_quotes_gpc')) {
        $_POST[$key] = stripslashes($_POST[$key]);
    }

    $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
}

//
if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
    die("<div class='failure alert alert-danger'>Invalid input data.</div>");
}

// Assign the input values to variables for easy reference
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Test input values for errors
$errors = array();

if (!$email) {
    $errors[] = 'You must enter an email.';
} elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'You must enter a valid email.';
}

if (strlen($message) < 10) {
    if (!$message) {
        $errors[] = 'You must enter a message.';
    } else {
        $errors[] = 'Message must be at least 10 characters.';
    }
}

// Output errors and die with a failure message
if ($errors) {
    $errortext = '';

    foreach ($errors as $error) {
        $errortext .= '<li>'.$error.'</li>';
    }

    die("<div class='failure alert alert-danger'><strong>The following errors occured:</strong> <hr> <ul class='list-unstyled'>".$errortext.'</ul></div>');
}

// Send the email
$to = 'rafiquejadoon2@gmail.com';
$subject = "Orise - Contact Form: $name";
$headers = "From: $email";

// Send mail
mail($to, $subject, $message, $headers);

// Die with a success message
die("<div class='thanks alert alert-success'>Thanks for submitting your email! You will be contacted shortly.</div>");
