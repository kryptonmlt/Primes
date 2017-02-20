<?php
   require_once 'mailgun-init.php';

   $fname = $lname = $email = '';
   $fnameError = $lnameError = $emailError = '';
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['fname'], $_POST['lname'], $_POST['email'])) {
         $fname = saneInput($_POST['fname']);
         $lname = saneInput($_POST['lname']);
         $email = saneInput($_POST['email']);

         $hash = '';
         if (validateEmail($email)) {
            $hash = $mailgunOptIn->generateHash(MAILGUN_LIST, MAILGUN_SECRET, $email);

            try {
               $mailgun->post('lists/' . MAILGUN_LIST . '/members', [
                     'name' => $fname . ' ' . $lname,
                     'address' => $email,
                     'subscribed' => 'no'
               ]);
            } catch (Mailgun\Connection\Exceptions\MissingRequiredParameters $e) {
               $emailError = 'Email already subscribed';
            }

            if ($emailError == '') {
               $mailgun->sendMessage(MAILGUN_DOMAIN, [
                     'from' => 'noreply@primes-project.eu',
                     'to' => $email,
                     'subject' => 'Please confirm your subscription to the PRIMES mailing list',
                     'html' => "Hello {$fname},<br/>
                     You signed up to our mailing list. Please confirm below.<br/><a href=\""
                     . BASEURL . "/confirm.php?hash={$hash}\">Confirm subscription</a>"
               ]);
               header('Location: ' . REDIR_LOCATION);
            }
         } else {
            $emailError = 'Invalid email address';
         }
      } else {
         if (!isset($_POST['fname']))
            $fnameError = "First name is required";
         if (!isset($_POST['lname']))
            $lnameError = "Last name is required";
         if (!isset($_POST['email']))
            $emailError = "E-mail address is required";
      }
   }
?>

<!doctype html>
<html>
   <head>
      include "meta.html"
      <title>PRIMES | Subscribe to Mailing List</title>
      <script type="text/javascript">
         window.onload = function () {
             document.getElementById("mCntct").className += " selected";
         }
      </script>
   </head>
   <body>
      <div id="main">
         include "header.html"
         <div id="content_header"></div>
         <div id="site_content">
            <div id="content_solo">
               <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="subscribe">
                  <div class="field">
                     <label>First Name *
                        <input class="myinput" type="text" name="fname" value="<?php echo $fname ?>"/>
                        <span class="error"><?php echo $fnameError ;?></span>
                     </label>
                  </div>
                  <div class="field">
                     <label>
                        Last Name *
                        <input class="myinput" type="text" name="lname" value="<?php echo $lname ?>"/>
                        <span class="error"><?php echo $lnameError ;?></span>
                     </label>
                  </div>
                  <div class="field">
                     <label>
                        Email Address *
                        <input class="myinput" type="text" name="email" value="<?php echo $email ?>"/>
                        <span class="error"><?php echo $emailError ;?></span>
                     </label>
                  </div>
                  <input type="submit" value="Subscribe" class="button"/>
               </form>
            </div>
         </div>
         <div id="content_footer"></div>
         <div id="footer">
            include "footer.html"
         </div>
      </div>
   </body>
</html>
