<?php
$app->get('/',function() use ($app){
	//echo $app->randomlib->generateString(128);
	$app->render('home.php');
})->name('home');

$app->get('/flash',function() use ($app){
	$app->flash('global','You have registered!');
	$app->response->redirect($app->urlFor('home'));
});