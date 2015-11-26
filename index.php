<?php
ini_set('display_errors', 1);

session_start();



require_once 'Autoloader.php';
\Framework\Autoloader::init();
\Framework\HttpContext\HttpContext::setInstance(new Framework\HttpContext\HttpRequest(), new Framework\HttpContext\HttpCookie(), new Framework\HttpContext\HttpSession(), new \Framework\HttpContext\HttpUser());

//\Framework\HttpContext\HttpContext::getInstance()->getCookies()->time->delete();
//
//$date = new DateTime('now', new DateTimeZone('Europe/Sofia'));
//\Framework\HttpContext\HttpContext::getInstance()->getCookies()->time = $date->format("Y-m-d H:i:s");
//
//echo "Time cookie " . \Framework\HttpContext\HttpContext::getInstance()->getCookies()->time . " END";
//var_dump($_COOKIE);
//
//\Framework\HttpContext\HttpContext::getInstance()->getCookies()->time->delete();
//
//var_dump($_COOKIE);
//
//exit;

//\Framework\HttpContext\HttpContext::getInstance()->getSession()->time->delete();
//
//var_dump($_SESSION);
//
//$date = new DateTime('now', new DateTimeZone('Europe/Sofia'));
//\Framework\HttpContext\HttpContext::getInstance()->getSession()->time = $date->format("Y-m-d H:i:s");
//
//echo "Time session " . \Framework\HttpContext\HttpContext::getInstance()->getSession()->time . " END";
//var_dump($_SESSION);
//
//\Framework\HttpContext\HttpContext::getInstance()->getSession()->time->delete();
//
//var_dump($_SESSION);
//
//exit;

//var_dump(\Framework\HttpContext\HttpContext::getInstance()->getRequest()->getForm()->username);
//var_dump(\Framework\HttpContext\HttpContext::getInstance()->getRequest()->test2);
//
//exit;

$router = new Framework\Routers\Router();
$frontController = new \Framework\FrontController($router);
$app = new \Framework\App($frontController);
$app->start();