<?php
require 'database.php';
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

$db = new PasterDatabase($app);

$app->get('/', function(Application $app) {
	return $app['twig']->render('index.html.twig');
});

$app->post('/paste', function(Application $app, Request $request) use ($db) {
	$id = $db->addPaste($request->get('content'));
	if (is_null($id)) {
		return $app->abort(500, "Failed to add paste to db.");
	}

	return $app->redirect("paste/{$id}");;
});

$app->get('/paste/{id}', function(Application $app, $id) use ($db) {
    $paste = $db->getPaste($id);
	if (is_null($paste)) {
		return $app->redirect('../');
	}

	return $app['twig']->render('paste.html.twig', array(
		'id' => $paste['id'],
		'paste' => $paste['paste'],
		'time' =>  date('d/m/Y H:i', $paste['time'])
	));
});

$app->get('/paste/{id}/plain', function(Application $app, $id) use ($db) {
	$paste = $db->getPaste($id);
	if (is_null($paste)) {
		return $app->redirect('../../');
	}

	return $app['twig']->render('plain.twig', array('paste' => $paste['paste']));
});