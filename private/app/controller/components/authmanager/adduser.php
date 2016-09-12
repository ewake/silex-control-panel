<?php
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

$options['meta_title'] = $app['translator']->trans(_('Add %component%'), ['%component%' => $app['translator']->trans(_('User'))]).' - '.$app['config_components']['authmanager']['title'];
$options['title'] = $app['translator']->trans(_('Add %component%'), ['%component%' => $app['translator']->trans(_('User'))]);
$options['sub_title'] = $app['config_components']['authmanager']['title'];

$options['breadcrumb'][] = [
	'label' => $options['sub_title'], 
	'route_name' => 'component',
	'route_params' => ['_locale' => $app['locale'], 'slug' => 'authmanager'],
];
$options['breadcrumb'][] = ['label' => $options['title']];

$options['groups'] = $app['groupHandler']->getGroups();
ksort($options['groups']);

if($app['request']->isMethod('POST')) {
	$app['request']->request->set('username', $app['slugify']->slugify($app['request']->request->get('username')));
	
	$postdata = $postdata_validate = $app['request']->request->all();
	
	if(isset($postdata_validate['groups']))
		unset($postdata_validate['groups']);
	
	$users = $app['passwdHandler']->getUsers();
	
	if(count($app['config_phphttp_excludedUsernames']) > 0) {
		foreach($app['config_phphttp_excludedUsernames'] as $excludedUsername) {
			if(array_key_exists($excludedUsername, $users)) {
				unset($users[$excludedUsername]);
			}
		}
	}
	
	$constraint = new Assert\Collection([
			'username' =>  [
					new Assert\NotNull(),
					new Assert\NotBlank(),
					new Assert\Length(['min' => $app['config_phphttp_minUsername']]),
					new AppAssert\NotInUsernames(['usernames' => $users]),	
					new AppAssert\ExcludedUsernames(['excludedUsernames' => $app['config_phphttp_excludedUsernames']]),
			],
			'password'  => [
					new Assert\NotNull(),
					new Assert\NotBlank(),
					new Assert\Length(['min' => $app['config_phphttp_minPassword']]),
			],
	]);
	
	$errors = $app['validator']->validateValue($postdata_validate, $constraint);
	
	if (0 === count($errors)) {
		$app['passwdHandler']->addUser($postdata['username'], $postdata['password']);
		
		if(isset($postdata['groups'])) {
			foreach($postdata['groups'] as $group)
				$app['groupHandler']->addUserToGroup($postdata['username'], $group);
		}
		
		$app['session']->getFlashBag()->add('success', $app['translator']->trans(_('User added successfully')));
		
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