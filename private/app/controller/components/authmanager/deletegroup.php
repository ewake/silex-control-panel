<?php
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

$groupname = $action_id;

if(!$app['groupHandler']->groupExists($groupname))
	return $app->abort(404);

$constraint = new Assert\Collection([
		'groupname' =>  [
				new Assert\NotNull(),
				new Assert\NotBlank(),
				new AppAssert\ExcludedGroupnames(['excludedGroupnames' => $app['config_phphttp_excludedGroupnames']]),
		],
]);

$errors = $app['validator']->validateValue(['groupname' => $groupname], $constraint);

if (0 === count($errors)) {			
	$app['groupHandler']->deleteGroup($groupname);
	
	$app['session']->getFlashBag()->add('success', $app['translator']->trans(_('Group deleted successfully')));
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

$redirect = $app['url_generator']->generate('component', ['_locale' => $app['locale'], 'slug' => 'authmanager']);