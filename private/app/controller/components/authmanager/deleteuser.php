<?php
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

$username = $action_id;

if(!$app['passwdHandler']->userExists($username))
	return $app->abort(404);

$userGroups = $app['groupHandler']->getGroupsByUser($username);

$constraint = new Assert\Collection([
		'username' =>  [
				new Assert\NotNull(),
				new Assert\NotBlank(),
				new AppAssert\ExcludedUsernames(['excludedUsernames' => $app['config_phphttp_excludedUsernames']]),
		],
]);

$errors = $app['validator']->validateValue(['username' => $username], $constraint);
	
if (0 === count($errors)) {
	foreach($userGroups as $group) {
		$app['groupHandler']->deleteUserFromGroup($username, $group);
	}
	
	$app['passwdHandler']->deleteUser($username);
	
	$app['session']->getFlashBag()->add('success', $app['translator']->trans(_('User deleted successfully')));
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