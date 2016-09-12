<?php
return [
		'config_return_path' => 'root@host.domain.tld',
		
		'config_debug_emails_to' => [
				'info@domain.tld' => 'superadmin',
		],
		
		'config_transport' => 'sendmail', // smtp, mail, sendmail
		
		'config_sendmail_path' => '/usr/sbin/sendmail -bs',

		'swiftmailer.options' => [
				'host' => '',
		    'port' => '',
		    'username' => '',
		    'password' => '',
		    'encryption' => null, // null, ssl, tls
		    'auth_mode' => null
		],
];
