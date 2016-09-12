<?php
return [
		'twig.path' => [
				_ROOT . '/app/view'
		],
		
		'twig.options' => [
				'cache' => _ROOT . '/var/cache/twig',
				'debug' => false,
				'auto_reload' => true,	
		],
];