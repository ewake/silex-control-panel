<?php
$options['meta_title'] = $app['config_components']['authmanager']['title'];
$options['title'] = $app['config_components']['authmanager']['title'];

$options['breadcrumb'][] = ['label' => $options['title']];

$options['actions'][] = [
	'label' => $app['translator']->trans(_('Add %component%'), ['%component%' => $app['translator']->trans(_('User'))]),
	'route_name' => 'component',
	'route_params' => ['_locale' => $app['locale'], 'slug' => 'authmanager', 'action' => 'adduser'],
	'icon_class' => 'fa fa-user',
];

$options['actions'][] = [
	'label' => $app['translator']->trans(_('Add %component%'), ['%component%' => $app['translator']->trans(_('Group'))]),
	'route_name' => 'component',
	'route_params' => ['_locale' => $app['locale'], 'slug' => 'authmanager', 'action' => 'addgroup'],
	'icon_class' => 'fa fa-group',
];

$options['users'] = $app['passwdHandler']->getUsersAndGroups($app['groupHandler']);
ksort($options['users']);

$options['groups'] = $app['groupHandler']->getGroups();
ksort($options['groups']);
