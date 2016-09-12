<?php
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

$options['meta_title'] = $app['translator']->trans(_('Edit %component%'), ['%component%' => $app['translator']->trans(_('Group'))]).' - '.$app['config_components']['authmanager']['title'];
$options['title'] = $app['translator']->trans(_('Edit %component%'), ['%component%' => $app['translator']->trans(_('Group'))]);
$options['sub_title'] = $app['config_components']['authmanager']['title'];

$options['breadcrumb'][] = [
	'label' => $options['sub_title'], 
	'route_name' => 'component',
	'route_params' => ['_locale' => $app['locale'], 'slug' => 'authmanager'],
];
$options['breadcrumb'][] = ['label' => $options['title']];

$options['users'] = $app['passwdHandler']->getUsers();
ksort($options['users']);

$options['groupname'] = $action_id;

if(($options['groupUsers'] = $app['groupHandler']->getGroup($options['groupname'])) === false) {
	return $app->abort(404);
}

if($app['request']->isMethod('POST')) {
	$errors = [];
	
	$postdata = $app['request']->request->all();
	
	if (0 === count($errors)) {		
		if(isset($postdata['users'])) {
			$app['groupHandler']->setUsersToGroup($postdata['groupname'], $postdata['users']);
		} else {
			$app['groupHandler']->setUsersToGroup($postdata['groupname'], []);
		}
		
		$app['session']->getFlashBag()->add('success', $app['translator']->trans(_('Group updated successfully')));
		
		$redirect = $app['url_generator']->generate('component', ['_locale' => $app['locale'], 'slug' => 'authmanager']);
	} else {
		$message = '';
		
		foreach ($errors as $error) {
			//http://stackoverflow.com/a/11915711
			/*$field = preg_replace('/\[|\]/', "", $violation->getPropertyPath());
			$error = $violation->getMessage();
			$errors[$field] = $error;*/
			
			$message .= $error->getPropertyPath().' '.$error->getMessage().PHP_EOL;
		}
		
		$app['session']->getFlashBag()->add('danger', $message);
	}
}