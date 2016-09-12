<?php
use Cocur\Slugify\Slugify;

$app['slugify'] = $app->share(function () {
	return new Slugify();
});