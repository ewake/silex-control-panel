<?php
return [
		'config_phphttp_htpasswd' => dirname(dirname(_ROOT)) . '/private/htauth/.htpasswd',
		'config_phphttp_htgroup' => dirname(dirname(_ROOT)) . '/private/htauth/.htgroup',
		
		// only part of this group can access the system
		'config_phphttp_adminGroup' => 'admin',
		
		'config_phphttp_minUsername' => 4,
		'config_phphttp_minPassword' => 5,
		'config_phphttp_minGroupname' => 4,
		
		'config_phphttp_excludedUsernames' => ['superadmin'],
		'config_phphttp_excludedGroupnames' => ['superadmin'],
];
