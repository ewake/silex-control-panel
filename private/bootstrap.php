<?php
use Silex\Application;
use Symfony\Component\Debug\Debug;

if (!defined('_PUBLIC'))
	define('_PUBLIC', _BOOT);

if (in_array(PHP_SAPI, ['cli', 'cli-server'])) {
	// To help the built-in PHP dev server, check if the request was actually for
	// something which should probably be served as a static file
	$file = _BOOT . getenv('REQUEST_URI');
	if (is_file($file)) {
		return false;
	}

	putenv("SERVER_ADDR=".gethostbyname(gethostname()));
	putenv("HTTP_HOST=".gethostname());
}

require _ROOT . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(_ROOT);
$dotenv->load();

$dotenv->required([
		'PRIVATE_KEY',
		'HOSTNAME',
]);

$files = glob('{'._BOOT.'/config/*,'._ROOT . '/app/config/{*,'.getenv('SERVER_ADDR').'/*,'.getenv('HTTP_HOST').'/*}}.{ini,json,xml,yaml,properties,php}', GLOB_BRACE);
$settings = Zend\Config\Factory::fromFiles($files);

if($settings['debug'])
	Debug::enable();

$app = new Application();

foreach($settings as $key => $val)
	$app[$key] = $val;

Kint::enabled($app['debug']);

require _ROOT . '/app/env.php';
require _ROOT . '/app/middlewares.php';
require _ROOT . '/app/services.php';
require _ROOT . '/app/providers.php';
require _ROOT . '/app/messages.php';
require _ROOT . '/app/controllers.php';

//FIXME
foreach($settings as $key => $val)
	$app[$key] = $val;

return $app;