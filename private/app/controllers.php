<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Request::setTrustedProxies($app['config_trusted_proxies']);

$app['controllers']
->assert('_locale', implode('|', array_keys($app['config_locales'])))
->value('_locale', $app['locale'])
->method('GET')
;

if($app['config_require_https'])
	$app['controllers']->requireHttps();

$app->get('/{_locale}', function ($_locale) use ($app) {
	return $app['twig']->render('home.twig');
})
->bind('home')
->assert('_locale', '('.implode('|', array_keys($app['config_locales'])).')?')
;

$app->match('/{_locale}/component/{slug}/{action}/{action_id}', function ($_locale, $slug, $action, $action_id) use ($app) {
	$options = [];
	$options['breadcrumb'][] = [
			'label' => _('Home'), 
			'route_name' => 'home', 
			'route_params' => ['_locale' => $app['locale']],
	];
	$options['actions'] = [];
	
	$redirect = false;
	if(file_exists(_ROOT.'/app/controller/components/'.$slug.'/'.$action.'.php'))
		require_once _ROOT.'/app/controller/components/'.$slug.'/'.$action.'.php';
	
	if($redirect)
		return $app->redirect($redirect);
	
	if(file_exists(_ROOT.'/app/view/components/'.$slug.'/'.$action.'.twig'))
		return $app['twig']->render('components/'.$slug.'/'.$action.'.twig', $options);
	else
		$app->abort(404);
})
->bind('component')
->value('slug', null)
->value('action', 'index')
->value('action_id', null)
->method('GET|POST')
;

$app->get('/logout', function () use ($app) {
	return $app['twig']->render('logout.twig');
})
->bind('logout')
;

$app->error(function (\Exception $e, $code) use ($app) {
	$options = [];
	$options['breadcrumb'][] = [
			'label' => _('Home'), 
			'route_name' => 'home', 
			'route_params' => ['_locale' => $app['locale']],
	];
	$options['code'] = $code;
	
	if($code == 403) {
		return $app['twig']->render('errors/403.twig', $options);
	}
	
	if ($app['debug']) {
	    return;
	}
	
	// 404.html, or 40x.html, or 4xx.html, or error.html
	$templates = [
	    'errors/'.$code.'.twig',
	    'errors/'.substr($code, 0, 2).'x.twig',
	    'errors/'.substr($code, 0, 1).'xx.twig',
	    'errors/default.twig',
	];
	
	return new Response($app['twig']->resolveTemplate($templates)->render($options), $code);
});
