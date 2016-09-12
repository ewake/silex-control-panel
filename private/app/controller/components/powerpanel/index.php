<?php
use Linode\LinodeApi;

$options['meta_title'] = $app['config_components']['powerpanel']['title'];
$options['title'] = $app['config_components']['powerpanel']['title'];

$options['breadcrumb'][] = ['label' => $options['title']];

if($app['request']->isMethod('POST')) {
	$action = $app['request']->request->get('action');
	
	$api = new LinodeApi(getenv('API_KEY'));
	
	switch($action) {
		case 'reboot':
			$res = $api->reboot(getenv('LINODE_ID'));
			
			$app['session']->getFlashBag()->add('success', $app['translator']->trans(_('The server is being restarted. Wait a few minutes before reloading the page.')));
			break;
			
		case 'shutdown':
			$res = $api->shutdown(getenv('LINODE_ID'));
				
			$app['session']->getFlashBag()->add('success', $app['translator']->trans(_('The server is shutting down. Contact the administrator if you want to start it again.')));	
			break;	
	}
	
	$redirect = $app['url_generator']->generate('component', ['_locale' => $app['locale'], 'slug' => 'powerpanel']);
}