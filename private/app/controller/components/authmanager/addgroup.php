<?php
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

$options['meta_title'] = $app['translator']->trans(_('Add %component%'), ['%component%' => $app['translator']->trans(_('Group'))]).' - '.$app['config_components']['authmanager']['title'];
$options['title'] = $app['translator']->trans(_('Add %component%'), ['%component%' => $app['translator']->trans(_('Group'))]);
$options['sub_title'] = $app['config_components']['authmanager']['title'];

$options['breadcrumb'][] = [
	'label' => $options['sub_title'], 
	'route_name' => 'component',
	'route_params' => ['_locale' => $app['locale'], 'slug' => 'authmanager'],
];
$options['breadcrumb'][] = ['label' => $options['title']];

$options['users'] = $app['passwdHandler']->getUsers();
ksort($options['users']);

if($app['request']->isMethod('POST')) {
	$app['request']->request->set('groupname', $app['slugify']->slugify($app['request']->request->get('groupname')));
	
	$postdata = $postdata_validate = $app['request']->request->all();
	
	if(isset($postdata_validate['users']))
		unset($postdata_validate['users']);
	
	$groups = $app['groupHandler']->getGroups();
	
	if(count($app['config_phphttp_excludedGroupnames']) > 0) {
		foreach($app['config_phphttp_excludedGroupnames'] as $excludedGroupname) {
			if(array_key_exists($excludedGroupname, $groups)) {
				unset($groups[$excludedGroupname]);
			}
		}
	}
	
	$constraint = new Assert\Collection([
			'groupname' =>  [
					new Assert\NotNull(),
					new Assert\NotBlank(),
					new Assert\Length(['min' => $app['config_phphttp_minGroupname']]),
					new AppAssert\NotInGroupnames(['groupnames' => $groups]),
					new AppAssert\ExcludedGroupnames(['excludedGroupnames' => $app['config_phphttp_excludedGroupnames']]),
			],
	]);
	
	$errors = $app['validator']->validateValue($postdata_validate, $constraint);
	
	if (0 === count($errors)) {
		$app['groupHandler']->addGroup($postdata['groupname']);
		
		if(isset($postdata['users'])) {
			foreach($postdata['users'] as $username)
				$app['groupHandler']->addUserToGroup($username, $postdata['groupname']);
		}
		
		$app['session']->getFlashBag()->add('success', $app['translator']->trans(_('Group added successfully')));
		
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