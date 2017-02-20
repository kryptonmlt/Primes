<?php
   // CHANGE THE TWO LINES BELOW
   define('EMAIL_TO', "Nikos.Ntarmos@glasgow.ac.uk");
   define('EMAIL_SUBJECT', "Primes Website Contact Form");

   require_once 'mailgun-init.php';

   function validateName($name) {
      $string_exp = "/^[A-Za-z .'-]+$/";
      return preg_match($string_exp, $name);
   }

   function validateComments($comments) {
      return (strlen($comments) > 2);
   }

   function clean_string($string) {
      $bad = array("content-type", "bcc:", "to:", "cc:", "href");
      return str_replace($bad, "", $string);
   }

   $name = $email_from = $comments = '';
   $error_name = $error_email = $error_comments = '';

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // validation expected data exists
      $num_errors = 0;
      if (isset($_POST['name'], $_POST['email'], $_POST['comments'])) {
         $name = saneInput($_POST['name']); // required
         $email_from = saneInput($_POST['email']); // required
         $comments = saneInput($_POST['comments']); // required

         if (!validateEmail($email_from)) {
            $error_email = 'The Email Address you entered does not appear to be valid.<br />';
            $num_errors++;
         }

         if (!validateName($name)) {
            $error_name = 'The Name you entered does not appear to be valid.<br />';
            $num_errors++;
         }

         if (!validateComments($comments)) {
            $error_comments = 'Empty comments field.<br />';
            $num_errors++;
         }

         if ($num_errors == 0) {
            $email_message = "Form details below.\n\n";
            $email_message .= "Name: " . clean_string($name) . "\n";
            $email_message .= "Email: " . clean_string($email_from) . "\n";
            $email_message .= "Comments: " . clean_string($comments) . "\n";

            // create email headers
            $headers = 'From: ' . $email_from . "\r\n" .
               'Reply-To: ' . $email_from . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
            @mail(EMAIL_TO, EMAIL_SUBJECT, $email_message, $headers);
         }
      } else {
         if (!isset($_POST['name']))
            $error_name = "First name is required";
         if (!isset($_POST['email']))
            $error_email = "Email address is required";
         if (!isset($_POST['comments']))
            $error_comments = "Comments field cannot be empty";
      }
   }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      include "meta.html"
      <title>PRIMES | Contact us</title>
      <style type="text/css">
         @media (max-width: 860px) {
            .sidebar {
               display:block;
               margin:0 auto;
               float:left;
               clear:both;
               width:90%;
               margin-left: 50%;
               margin-right: -50%;
               transform:translateX(-50%);
               max-width:800px;
            }
         }
      </style>
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
            <div id="content">
               <h1>Contact Us</h1>
               <p>We are keen on discussing PRIMES with all interested stakeholders and would be delighted to hear your questions, thoughts and suggestions. Please use the form below to contact us and we shall respond as soon as we can. Alternatively, you can connect with us through our social media accounts or [<a href="subscribe.php">subscribe to our mailing list</a>].</p>
               <form name="htmlform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <table width="100%">
                     <tr>
                        <td valign="top">
                           <label for="name">Name *</label>
                        </td>
                        <td valign="top">
                           <input type="text" id="name" maxlength="80" class="mytext" value="<?php echo $name ?>"/><span class="error"><?php echo $error_name; ?></span>
                        </td>
                     </tr>
                     <tr>
                        <td valign="top">
                           <label for="email">Email Address *</label>
                        </td>
                        <td valign="top">
                           <input type="text" id="email" maxlength="80" class="mytext" value="<?php echo $email ?>"/><span class="error"><?php echo $error_email; ?></span>
                        </td>
                     </tr>
                     <tr>
                        <td valign="top">
                           <label for="comments">Comments *</label>
                        </td>
                        <td valign="top">
                           <textarea id="comments" rows="10" height="auto" class="mytext" value="<?php echo $comments ?>"/></textarea><span class="error"><?php echo $error_comments; ?></span>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align:center">
                           <input type="submit" value="Submit"/>
                        </td>
                     </tr>
                  </table>
               </form>
            </div>
            <div class="sidebar" id="contact-info">
               <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
               <div>
                  <div class="contact-item">
                     <span class="contact-icon"><i class="fa fa-map-marker"></i></span>
                     <span class="contact-data"><a href="https://goo.gl/maps/yaNkJ7V1HEA2" alt="Mailing address" target="_blank">Project PRIMES Coordinator<br/>
                        Sir Alwyn Williams Building<br/>
                        Glasgow G12 8RZ<br/>
                        Scotland<br/>
                        United Kingdom</a>
                     </span>
                  </div>
                  <br/>
                  <div class="contact-item">
                     <span class="contact-icon"><i class="fa fa-envelope"></i></span>
                     <span class="contact-data"><a href="mailto:info@primes-project.eu" alt="Email" target="_blank">info [at] primes [dash] project [dot] eu</a></span>
                  </div>
                  <br/>
                  <div class="contact-item">
                     <span class="contact-icon"><i class="fa fa-twitter"></i></span>
                     <span class="contact-data"><a href="https://twitter.com/Project_PRIMES" alt="Twitter" target="_blank">@Project_PRIMES</a></span>
                  </div>
                  <br/>
                  <div class="contact-item">
                     <span class="contact-icon"><i class="fa fa-facebook"></i></span>
                     <span class="contact-data"><a href="https://www.facebook.com/ProjectPRIMES" alt="Facebook" target="_blank">ProjectPRIMES</a></span>
                  </div>
                  <br/>
                  <div class="contact-item">
                     <span class="contact-icon"><i class="fa fa-google-plus"></i></span>
                     <span class="contact-data"><a href="https://plus.google.com/u/0/107236897284106820905" alt="Google+" target="_blank">Project PRIMES</a></span>
                  </div>
               </div>
            </div>
         </div>
         <div id="content_footer"></div>
         <div id="footer">
            include "footer.html"
         </div>
      </div>
    </body>
</html>
