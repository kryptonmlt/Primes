<?php

   require_once 'vendor/autoload.php';
   define('MAILGUN_KEY', 'XXXSKEYXXX');
   define('MAILGUN_PUBKEY', 'XXXPKEYXXX');
   define('MAILGUN_DOMAIN', 'primes-project.eu');
   define('MAILGUN_LIST', 'news@primes-project.eu');
   define('MAILGUN_SECRET', 'XXXSECRETXXX');
   define('REDIR_LOCATION', '/contact_us.html');
   define('BASE_URL', 'https://primes-project.eu/newslist');

   $mailgun = new Mailgun\Mailgun(MAILGUN_KEY);
   $mailgunValidate = new Mailgun\Mailgun(MAILGUN_PUBKEY);
   $mailgunOptIn = $mailgun->OptInHandler();

   function validateEmail($email) {
      return $mailgunValidate->get('address/validate', [ 'address' => $email ])->http_response_body->is_valid;
   }

?>
