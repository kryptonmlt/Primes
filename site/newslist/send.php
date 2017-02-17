<?php
	require_once 'init.php';

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
		<title>Send | Mailing List</title>
		<link rel="stylesheet" type="text/css" href="css/global.css"/>
	</head>
	<body>
		<div class="container">
			<form action="send.php" method="post">
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
