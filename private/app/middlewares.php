<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/*$app->before(function (Request $request, Application $app) {
	
}, Application::EARLY_EVENT);*/

$app->before(function (Request $request, Application $app) {
	$app['locale_fallbacks'] = array_keys($app['config_locales']);
	
	$app['passwdHandler'] = function ($app) {
		return new PHPHttp\Passwd($app['config_phphttp_htpasswd']);
	};
	$app['groupHandler'] = function ($app) {
		return new PHPHttp\Group($app['config_phphttp_htgroup']);
	};

	if (!isset($_SERVER['PHP_AUTH_USER']) || !$app['groupHandler']->isInGroup($_SERVER['PHP_AUTH_USER'], $app['config_phphttp_adminGroup']) ) {
		//https://github.com/symfony/symfony/issues/1813
		//https://github.com/symfony/symfony/blob/4532320a1117491efbffc0023ac5ca09f18d7b5a/ServerBag.php
		//return $app->abort(403, _('You are not allowed to access the system.'));
		header('HTTP/1.0 401 Unauthorized');
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="Realm"');
		echo _('You are not allowed to access the system.');
		exit();
	}
	
	if(array_key_exists($request->get('locale'), $app['config_locales'])) {
		$app['locale'] = $request->get('locale');
		$app['session']->set('locale', $app['locale']);
	} elseif(array_key_exists($app['session']->get('locale'), $app['config_locales'])) {
		$app['locale'] = $app['session']->get('locale');
	} else {
		$app['locale'] = $request->getPreferredLanguage(array_keys($app['config_locales']));
		$app['session']->set('locale', $app['locale']);
	}
});

$app->after(function (Request $request, Response $response) use ($app) {
	if ($app['debug']) {
		return;
	}
	
	if (0 === strpos($response->headers->get('Content-Type'), 'text/html')) {
		$search = array('/\n/','/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
		$replace = array(' ','>','<','\\1');

		$minified_content = preg_replace($search, $replace, $response->getContent());

		$response->setContent($minified_content);
	}
});