<?php
return [
		'config_return_path' => 'root@mailgun.org',
	
		'config_transport' => 'smtp', // smtp, mail, sendmail

		'swiftmailer.options' => [
				'host' => 'smtp.mailgun.org',
		    'port' => '587',
		    'username' => getenv('SMTP_USERNAME'),
		    'password' => getenv('SMTP_PASSWORD'),
		    'encryption' => 'tls', // null, ssl, tls
		    'auth_mode' => null
		],
];