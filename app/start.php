<?php

use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use Noodlehaus\Config;
use RandomLib\Factory as RandomLib;

use Codecourse\User\User;
use Codecourse\Mail\Mailer;
use Codecourse\Helpers\Hash;

use Codecourse\Validation\Validator;

use Codecourse\Middleware\BeforeMiddleware;
use Codecourse\Middleware\CsrfMiddleware;

session_cache_limiter(false);
session_start();

ini_set('display_errors','On');

define('INC_ROOT',dirname(__DIR__));

require INC_ROOT.'/vendor/autoload.php';

$app = new Slim([
	'mode'=> file_get_contents(INC_ROOT.'/mode.php'),
	'view'=> new Twig(),
	'templates.path'=> INC_ROOT.'/app/views/'

	]);

//echo $app->config('mode');
/* Test route
$app->get('/test',function(){
	echo 'This is a test route.';
});*/

$app->add(new BeforeMiddleware);
$app->add(new CsrfMiddleware);

$app->configureMode($app->config('mode'),function() use ($app){
	$app->config = Config::load(INC_ROOT."/app/config/{$app->mode}.php");

});

//var_dump($app->config);
//echo $app->config->get('db.driver');

require 'database.php';
require 'filters.php';
require 'routes.php';

$app->auth = false;

$app->container->set('user',function(){
	return new User;
});

$app->container->singleton('hash',function() use ($app){
	return new Hash($app->config);
});

$app->container->singleton('validation',function() use ($app){
	return new Validator($app->user);
});

$app->container->singleton('mail',function() use ($app){
	$mailer = new PHPMailer;

	$mailer->Host = $app->config->get('mail.host');
	$mailer->SMTPAuth = $app->config->get('mail.smtp_auth');
	$mailer->SMTPSecure = $app->config->get('mail.smtp_secure');
	$mailer->Port = $app->config->get('mail.port');
	$mailer->Username = $app->config->get('mail.username');
	$mailer->Password = $app->config->get('mail.password');

	$mailer->isHTML($app->config->get('mail.html'));

	return new Mailer($app->view,$mailer);

});

$app->container->singleton('randomlib',function(){
	$factory = new RandomLib;
	return $factory->getMediumStrengthGenerator();
});
//var_dump($app->user);
/*
$app->get('/',function() use ($app){
	$app->render('home.php');
});*/

$view = $app->view();
$view->parserOptions = [
	'debug'=>$app->config->get('twig.debug')
];
$view->parserExtensions = [
	new TwigExtension
];

//$hash = $app->hash; //It equvalent with $hash = new Hash($app->config);



