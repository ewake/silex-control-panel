<?php
return [
		'debug' => false,
		
		'config_private_key' => md5(getenv('PRIVATE_KEY')),
		
		'config_app_name' => 'Server Dashboard',
		'config_app_sub_name' => '',
		'config_app_version' => '1.0.0',
		
		'config_require_https' => true,
			
		'config_cache_suffix' => 1,
		
		//'config_cdn_url' = 'http://',
		
		'config_timezone' => 'Europe/Rome',
		
		'config_analytics' => 'UA-12345678-1',
		
		'config_trusted_proxies' => [],
		
		'config_credits_name' => 'EWake',
		'config_credits_title' => 'EWake - siti web, e-commerce, gestionali, web marketing, registrazioni domini e piani hosting a verona, vicenza e padova',
		'config_credits_url' => 'https://ewake.it',
		'config_credits_address' => 'Via borgo grande',
		'config_credits_street_number' => '19/B',
		'config_credits_postcode' => '37044',
		'config_credits_city' => 'Cologna Veneta',
		'config_credits_district' => '(VR)',
		'config_credits_state' => 'Italy',
		'config_credits_tel' => '+39.0442.84987',
		'config_credits_cell' => '',
		'config_credits_fax' => '+39.0442.84987',
		'config_credits_email' => 'info@domain.tld',
		'config_credits_pec' => 'info@pec.it',	
		'config_credits_vat' => '',
		'config_credits_cod_fisc' => '',
		'config_credits_rea' => '',	
		'config_credits_cap_soc' => '',
];
