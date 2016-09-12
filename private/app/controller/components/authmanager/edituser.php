<?php
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

$options['meta_title'] = $app['translator']->trans(_('Edit %component%'), ['%component%' => $app['translator']->trans(_('User'))]).' - '.$app['config_components']['authmanager']['title'];
$options['title'] = $app['translator']->trans(_('Edit %component%'), ['%component%' => $app['translator']->trans(_('User'))]);
$options['sub_title'] = $app['config_components']['authmanager']['title'];

$options['breadcrumb'][] = [
	'label' => $options['sub_title'], 
	'route_name' => 'component',
	'route_params' => ['_locale' => $app['locale'], 'slug' => 'authmanager'],
];
$options['breadcrumb'][] = ['label' => $options['title']];

$options['groups'] = $app['groupHandler']->getGroups();
ksort($options['groups']);

$options['username'] = $action_id;

if(!$app['passwdHandler']->userExists($options['username']))
	return $app->abort(404);

$options['userGroups'] = $app['groupHandler']->getGroupsByUser($options['username']);

if($app['request']->isMethod('POST')) {
	$errors = [];
	
	$postdata = $postdata_validate = $app['request']->request->all();
	
	unset($postdata_validate['username']);	
	if(isset($postdata_validate['groups']))
		unset($postdata_validate['groups']);
	
	if(!empty($postdata['password'])) {
		$constraint = new Assert\Collection([
				'password'  => [
						new Assert\NotNull(),
						new Assert\NotBlank(),
						new Assert\Length(['min' => $app['config_phphttp_minPassword']]),
				],
		]);
		
		$errors = $app['validator']->validateValue($postdata_validate, $constraint);
	}
	
	if (0 === count($errors)) {
		if(!empty($postdata['password']))
			$app['passwdHandler']->editUser($postdata['username'], $postdata['password']);
		
		if(isset($postdata['groups'])) {
			$app['groupHandler']->setGroupsToUser($postdata['username'], $postdata['groups']);
		} else {
			$app['groupHandler']->setGroupsToUser($postdata['username'], []);
		}
		
		$app['session']->getFlashBag()->add('success', $app['translator']->trans(_('User updated successfully')));
		
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