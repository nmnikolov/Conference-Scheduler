<?php
ini_set('display_errors', 1);

session_start();

require_once 'Autoloader.php';
\Framework\Autoloader::init();
\Framework\HttpContext\HttpContext::setInstance(new Framework\HttpContext\HttpRequest(), new Framework\HttpContext\HttpCookie(), new Framework\HttpContext\HttpSession());



//$date = new DateTime('now', new DateTimeZone('Europe/Sofia'));
//
//\Framework\HttpContext\HttpContext::getInstance()->getCookies()->time = $date->format("Y-m-d H:i:s");
//
//echo \Framework\HttpContext\HttpContext::getInstance()->getCookies()->time;
//echo "</br>";
//
//var_dump($_COOKIE);
//echo "</br>";
//
//\Framework\HttpContext\HttpContext::getInstance()->getCookies()->time->delete();
//
//var_dump($_COOKIE);
//
//exit;

//var_dump(filemtime("Controllers/."));
//exit;

$router = new Framework\Routers\Router();
$frontController = new \Framework\FrontController($router);
$app = new \Framework\App($frontController);
$app->start();