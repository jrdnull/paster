<?php
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

$app = new Application(); 
$app['debug'] = false;
$app->register(new TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));
$app->register(new DoctrineServiceProvider(), array(
	'db.options' => array(
	'driver'   => 'pdo_sqlite',
	'path'     => __DIR__.'/../paster.db',
	)
));

return $app;