<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Aura\Router\RouterContainer;
use App\Controllers\ErrorController;

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

$map->get('index', '/', [
  'controller' => 'App\Controllers\IndexController',
  'action' => 'getIndex'
]);
//Rutas de conocimiento
$map->get('knowledge', '/conocimiento', [
  'controller' => 'App\Controllers\KnowledgesController',
  'action' => 'getKnowledgeForm'
]);
$map->post('addKnowledge', '/conocimiento/subir', [
  'controller' => 'App\Controllers\KnowledgesController',
  'action' => 'addKnowledge'
]);
$map->get('getEditKnowledge', '/conocimiento/editar/{id}', [
  'controller' => 'App\Controllers\KnowledgesController',
  'action' => 'getEditKnowledge'
]);
$map->post('editKnowledge', '/conocimiento/editar/{id}', [
  'controller' => 'App\Controllers\KnowledgesController',
  'action' => 'getEditKnowledge'
]);
$map->get('deleteKnowledge', '/conocimiento/eliminar/{id}', [
  'controller' => 'App\Controllers\KnowledgesController',
  'action' => 'deleteKnowledge'
]);
//Rutas de sobre mi
$map->get('about', '/sobre', [
  'controller' => 'App\Controllers\AboutsController',
  'action' => 'getAbout'
]);
$map->post('aboutSave', '/sobre', [
  'controller' => 'App\Controllers\AboutsController',
  'action' => 'getAbout'
]);
//Ruta de portafolio
$map->get('portfolio', '/portafolio', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'getPortfolio'
]);
$map->post('addPortfolio', '/portafolio/subir', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'addPortfolio'
]);
$map->get('getEditPortfolio', '/portafolio/editar/{id}', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'getEditPortfolio'
]);
$map->post('editPortfolio', '/portafolio/editar/{id}', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'getEditPortfolio'
]);
$map->get('deletePortfolio', '/portafolio/eliminar/{id}', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'deletePortfolio'
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
  $controller = new ErrorController();
  $response = $controller->get404();
  echo $response->getBody();
} else {
  $handler = $route->handler;
  $controllerName = $handler['controller'];
  $actionName = $handler['action'];

  $controller = new $controllerName;
  $response = $controller->$actionName($request, $route);

  echo $response->getBody();
}
