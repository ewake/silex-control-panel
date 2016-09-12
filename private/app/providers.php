<?php 
//use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
//use Silex\Provider\WebProfilerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Symfony\Component\Translation\Loader\PoFileLoader;
//use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use AppBundle\Utils as AppUtils;

//$app->register(new SecurityServiceProvider());
$app->register(new MonologServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
//$app->register(new WebProfilerServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new TranslationServiceProvider());

//https://groups.google.com/forum/#!topic/silex-php/L0pm0uy8nyM
$app['session.storage.handler'] = null;
/*$app['session.storage.handler'] = $app->share(function () use ($app) {
	return new MemcachedSessionHandler(new \Memcached);
});*/

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
	$translator->addLoader('po', new PoFileLoader());

	foreach($app['config_locales'] as $key => $val)
		$translator->addResource('po', _ROOT.'/locale/'.$key.'.po', $key);
	
	$translator->setLocale($app['locale']);

	return $translator;
}));

//TODO
/*$app['monolog'] = $app->share($app->extend('monolog', function($monolog, $app) {
	//$monolog->pushHandler(new \Monolog\Handler\RotatingFileHandler($app['monolog.logfile'], $app['monolog.maxFiles'], \Monolog\Logger::INFO));

	return $monolog;
}));

//main override function
$app['monolog.handler'] = function () use ($app) {
	$level = MonologServiceProvider::translateLevel($app['monolog.level']);

	return new StreamHandler($app['monolog.logfile'], $level, $app['monolog.bubble'], $app['monolog.permission']);
};*/

$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
	
	$twig->addGlobal('current_path', $app['request']->getRequestUri());
	
	//$twig->addExtension(new \Twig_Extensions_Extension_I18n());

	$twig->addFunction('asset', new \Twig_SimpleFunction('asset', function ($asset) use ($app) {
		$file = _PUBLIC.'/'.$asset;
		
		if(file_exists($file)){
			$parts = explode( '.', $asset);
			$extension = array_pop($parts);
			array_push($parts, filemtime($file), $extension);
			$asset = implode('.', $parts);
		}

		return sprintf((isset($app['config_cdn_url']) ? $app['config_cdn_url']: $app['request']->getBasePath()).'/%s', ltrim($asset, '/'));
	}));
	
	$twig->addFunction('tel', new \Twig_SimpleFunction('tel', function ($string) use ($app) {
		$string = AppUtils::linearize($string);
		
		$string = preg_replace("/[^0-9]/", "", $string);
	
		$string = '+'.intval($string);
	
		return $string;
	}));
	
	$twig->addFilter('rot13', new Twig_Filter_Function('str_rot13'));

	$twig->addFilter('obfuscate', new Twig_SimpleFilter('obfuscate', function ( $value ) {
		$safe = '';

		foreach (str_split($value) as $letter)
		{
			if (ord($letter) > 128) return $letter;

			// To properly obfuscate the value, we will randomly convert each letter to
			// its entity or hexadecimal representation, keeping a bot from sniffing
			// the randomly obfuscated letters out of the string on the responses.
			switch (rand(1, 3))
			{
				case 1:
					$safe .= '&#'.ord($letter).';'; break;

				case 2:
					$safe .= '&#x'.dechex(ord($letter)).';'; break;

				case 3:
					$safe .= $letter;
			}
		}

		return $safe;
	}));

	return $twig;
}));
