<?php
	require_once 'init.php';

	$missingData = '';
	if (isset($_POST['fname'], $_POST['lname'], $_POST['email'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];

		$validate = $mailgunValidate->get('address/validate', [ 'address' => $email ])->http_response_body;

		if ($validate->is_valid) {
			$hash = $mailgunValidate->generateHash(MAILGUN_LIST, MAILGUN_SECRET, $email);
			$mailgun->sendMessage(MAILGUN_DOMAIN, [
				'from' => 'noreply@primes-project.eu',
				'to' => $email,
				'subject' => 'Please confirm your subscription to the PRIMES mailing list',
				'html' => "
					Hello {$fname},<br/>
					You signed up to our mailing list. Please confirm below.<br/><a href=\""
					. $BASE_URL . "/confirm.php?hash={$hash}\">Confirm subscription</a>"
			]);
			$mailgun->post('lists/' . MAILGUN_LIST . '/members', [
				'name' => $fname . ' ' . $lname,
				'address' => $email,
				'subscribed' => 'no'
			]);
			header('Location: ' . REDIR_LOCATION);
		}
	} else {
		$missingData = '<p>Please fill in all required fields</p>';
	}
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Subscribe | Mailing List</title>
		<link rel="stylesheet" type="text/css" href="css/global.css"/>
	</head>
	<body>
		<div class="container">
			<div class="error">
				<?php print_r($missingData); ?>
			</div>
			<form action="subscribe.php" method="post">
				<div class="field">
					<label>
						First Name *
						<input type="text" name="fname"/>
					</label>
				</div>
				<div class="field">
					<label>
						Last Name *
						<input type="text" name="lname"/>
					</label>
				</div>
				<div class="field">
					<label>
						Email Address *
						<input name="text" name="email"/>
					</label>
				</div>
				<input type="submit" value="Subscribe" class="button"/>
			</form>
		</div>
	</body>
</html>
