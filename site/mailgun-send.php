<?php
   require_once 'mailgun-init.php';

   if (isset($_POST['subject'], $_POST['body'])) {
      $subject = $_POST['subject'];
      $body = $_POST['body'];

      $mailgun->sendMessage(MAILGUN_DOMAIN, [
            'from' => 'noreply@primes-project.eu',
            'to' => MAILGUN_LIST,
            'subject' => $subject,
            'html' => $body
      ]);
      header('Location: ' . REDIR_LOCATION);
   }
?>

<!doctype html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Send To Mailing List</title>
      <style type="text/css">
         body{font: 100% Tahoma, sans-serif}
         .container{width:100%;max-width:400px;}
         form .field{margin-bottom:10px;}
         input[type="text"],textarea{width:100%;padding:10px;font-size:1em;border:1px solid #ccc;}
         label input[type="text"],label textarea {margin-top:5px;}
         .button{background:#73A2BD;border:0;border-bottom:4px solid #6690A9;color:#F0F0F0;padding:10px 12px;font-size:1em;}
         .error {color:#FF0000;}
      </style>
   </head>
   <body>
      <div class="container">
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="field">
               <label>
                  Subject
                  <input type="text" name="subject"/>
               </label>
            </div>
            <div class="field">
               <label>
                  Body
                  <textarea name="body" rows="8"></textarea>
               </label>
            </div>
            <input type="submit" value="Send" class="button"/>
         </form>
      </div>
   </body>
</html>
