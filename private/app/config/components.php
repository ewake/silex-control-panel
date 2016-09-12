<?php
return [
		'config_components' => [
				'roundcube' => [
						'title' => _('Webmail'),
						'descr' => _('Accesso alla casella di posta elettronica.'),
						'url' => 'https://'.getenv('HOSTNAME').'/webmail/',
				],
				
				'webmaillite' => [
						'title' => _('Webmail Lite'),
						'descr' => _('Accesso alla casella di posta elettronica anche tramite mobile.'),
						'url' => 'https://'.getenv('HOSTNAME').'/webmaillite/',
				],
				
				'webmaillite_adminpanel' => [
						'title' => _('Webmail Lite CP'),
						'descr' => _('Pannello di controllo di Webmail Lite.'),
						'url' => 'https://'.getenv('HOSTNAME').'/webmaillite/adminpanel',
						'auth_basic_1' => true,
				],
				
				'authmanager' => [
						'title' => _('Auth Manager'),
						'descr' => _('Gestione utenti e gruppi di autenticazione secondaria lato server.'),
				],
				
				'vestacp' => [
						'title' => _('Control Panel'),
						'descr' => _('Pannello di controllo principale del server.'),
						'url' => 'https://'.getenv('HOSTNAME').':8083/login/',
				],
				
				'webmin' => [
						'title' => _('Webmin'),
						'descr' => _('Pannello di controllo avanzato del server - solo per sistemisti.'),
						'url' => 'https://'.getenv('HOSTNAME').':10000',
						'tfa' => true,
				],
				
				'powerpanel' => [
						'title' => _('Power Panel'),
						'descr' => _('Pannello per il riavvio e l\'arresto del server - solo per sistemisti.'),
				],
				
				'phpinfo' => [
						'title' => _('PhpInfo'),
						'descr' => _('Informazioni sulla configurazione di PHP.'),
						'url' => 'https://'.getenv('HOSTNAME').'/phpinfo.php',
						'auth_basic_1' => true,
				],
				
				'phpmyadmin' => [
						'title' => _('PhpMyAdmin'),
						'descr' => _('Utility per la gestione dei database MySql.'),
						'url' => 'https://'.getenv('HOSTNAME').'/phpmyadmin',
						'auth_basic_1' => true,
				],
				
				'sypexdumper' => [
						'title' => _('Sypex Dumper'),
						'descr' => _('Utility per l\'importazione e l\'esportazione dei database MySql.'),
						'url' => 'https://'.getenv('HOSTNAME').'/sypexdumper',
						'auth_basic_1' => true,
				],
				
				'archive' => [

				],
				
				'monstaftp' => [
						'title' => _('FTP'),
						'descr' => _('Accesso via browser a file e cartelle tramite protocollo FTP.'),
						'url' => 'https://'.getenv('HOSTNAME').'/ftp',
						'auth_basic_1' => true,
				],
				
				/*'ftp' => [
						'title' => _('FTP'),
						'descr' => _('Accesso via browser tramite protocollo FTP.'),
						'url' => 'ftps://'.getenv('HOSTNAME'),
						'auth_basic_1' => true,
				],*/

				'codiac' => [
						'title' => _('File Editor'),
						'descr' => _('Editor avanzato via browser dei file del sito.'),
						'url' => 'https://'.getenv('HOSTNAME').'/ide',
						'auth_basic_1' => true,
				],
				
				/*'pydio' => [
						'title' => _('File Manager'),
						'descr' => _('Gestione via browser di file e cartelle del sito.'),
						'url' => 'https://'.getenv('HOSTNAME').'/pydio',
						'auth_basic_1' => true,
				],*/
				
				'owncloud' => [
						'title' => _('ownCloud'),
						'descr' => _('Condividi file, calendari, contatti, mail e altro da qualsiasi dispositivo.'),
						'url' => 'https://'.getenv('HOSTNAME').'/owncloud',
						'auth_basic_1' => true,
				],
				
				'google_pagespeed' => [
						'title' => _('Google PageSpeed'),
						'descr' => _('Pannello di gestione del modulo Apache mod_pagespeed di Google.'),
						'url' => 'https://'.getenv('HOSTNAME').'/pagespeed',
						'auth_basic_1' => true,
				],
					
				'google_analytics' => [
						'title' => _('Google Analytics'),
						'descr' => _('Accesso al servizio di statistiche Google Analytics.'),
						'url' => 'http://www.google.com/analytics/',
				],
				
				'awstats' => [
						'title' => _('AWStats'),
						'descr' => _('Report delle statistiche di accesso al sito.'),
						'url' => 'https://'.getenv('HOSTNAME').'/vstats/',
						'auth_basic' => true,
				],
				
				/*'webalizer' => [
						'title' => _('Webalizer'),
						'descr' => _('Report delle statistiche di accesso al sito.'),
						'url' => 'https://'.getenv('HOSTNAME').'/vstats/',
						'auth_basic_1' => true,
				],*/
		],
];