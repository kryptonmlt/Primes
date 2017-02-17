<?php

	require_once 'init.php';

	if (isset($_GET['hash']))
		$hash  = $mailgunOptIn->validateHash(MAILGUN_SECRET, $_GET['hash']);

	if ($hash) {
		$list = $hash['mailingList'];
		$email = $hash['recipientAddress'];
		$mailgun->put('lists/' . MAILGUN_LIST . '/members/' . $email, [ 'subscribed' => 'yes' ]);

		$mailgun->sendMessage(MAILGUN_DOMAIN, [
			'from' => 'noreply@primes-project.eu',
			'to' => $email,
			'subject' => 'Welcome to news@primes-project.eu',
			'html' => "
				Hello {%recipient_name%},<br/>
				Thanks for confirming. You are now subscribed to our mailing list."
		]);
		header('Location: ' . REDIR_LOCATION);
	}

?>
