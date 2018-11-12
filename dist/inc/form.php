<?php
    $your_secret = "6LdtLBMUAAAAAPaa8P2e4aeimgdB8YqFRa_dCkLg";
    $client_captcha_response = $_POST['g-recaptcha-response'];
    $user_ip = $_SERVER['REMOTE_ADDR'];

    $captcha_verify = open_https_url("https://www.google.com/recaptcha/api/siteverify?secret=$your_secret&response=$client_captcha_response&remoteip=$user_ip");
    $captcha_verify_decoded = json_decode($captcha_verify);
    if(!$captcha_verify_decoded->success)
      die('DIRTY ROBOT');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $human = $_POST['human'];
    $from = 'From: My Website';
    $to = 'peteralbertweir@gmail.com';
    $subject = 'Request Form';

    $body = "Name: $name \n E-Mail: $email \nMessage:\n$message";

    if ($_POST['submit']) {
        if ($email != '') {
            if ($human == '4') {
                if (mail ($to, $subject, $body, $from)) {
                    echo '<p>You have successfully submitted your information to PS4RS. Subscribers to our mailing list will begin to periodically receive updates.</p>';
                } else {
                    echo '<p>Something went wrong, go back and try again!</p><p><input type="button" value="Go Back" onclick="history.back(-1)" class="goback" /></p>';
                }
            } else if ($_POST['submit'] && $human != '4') {
                echo '<p>You answered the anti-spam question incorrectly!</p><p><input type="button" value="Go Back" onclick="history.back(-1)" class="goback" /></p>';
            }
        } else {
            echo '<p>You need to fill in all required fields!!</p><p><input type="button" value="Go Back" onclick="history.back(-1)" class="goback" /></p>';
        }
    }
?>
