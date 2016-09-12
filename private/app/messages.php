<?php
//global
_('Logout');
_('No results found.');
_('Submit');
_('Back');
_('Cancel');
_('OK');
_('It requires server-side authentication');
_('It requires main server-side authentication');
_('It requires secondary server-side authentication');
_('It requires two factor authentication');
_('It opens a new window');

//errors
_('Error %code%');
_('You are not allowed to access the system.');
_('Page not found.');
_('An error occurred on the client.');
_('Internal server error.');
_('An error occurred on the server.');

//authmanager
_('Users');
_('Groups');
_('Username');
_('Actions');
_('Members');
_('Group Name');
_('No spaces, min %n% characters');
_('No spaces, min %n% characters, "%characters%" allowed');
_('Min %n% characters');
_('Are you sure you want to delete user "%name%"?');
_('Are you sure you want to delete group "%name%"?');

//powerpanel
_('Warning: use these commands only if you know what you\'re doing.');
_('It is recommended to turn off the SSH server via Webmin at each cloud restart.');
_('Reboot');
_('Shutdown');
_('Are you sure you want to reboot the server?');
_('Are you sure you want to shutdown the server?');

$app['translator.domains'] = [
		'validators' => [
				'it' => [
						'Username "%string%" not allowed.' => 'Utente "%string%" non permesso.',
						'Username "%string%" already exists.' => 'L\'utente "%string%" esiste già.',
						'Group "%string%" not allowed.' => 'Gruppo "%string%" non permesso.',
						'Group "%string%" already exists.' => 'Il gruppo "%string%" esiste già.',			
				],
		],
];