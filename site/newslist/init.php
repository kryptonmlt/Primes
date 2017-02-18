<?php

   require_once 'vendor/autoload.php';
   use Mailgun\Mailgun;
   define('MAILGUN_DOMAIN', 'primes-project.eu');
   define('MAILGUN_LIST', 'news@primes-project.eu');
   define('REDIR_LOCATION', '/contact_us.html');
   define('BASEURL', 'https://primes-project.eu/test/newslist');

XXXMAILGUNSECRETSXXX

   $mailgun = new Mailgun(MAILGUN_KEY);
   $mailgunValidate = new Mailgun(MAILGUN_PUBKEY);
   $mailgunOptIn = $mailgun->OptInHandler();

   function saneInput($data) {
      return htmlspecialchars(stripslashes(trim($data)));
   }

   function validateEmail($email) {
      global $mailgunValidate;
      return $mailgunValidate->get('address/validate', array('address' => $email))->http_response_body->is_valid;
   }

?>
