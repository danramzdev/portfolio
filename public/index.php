<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Aura\Router\RouterContainer;
use App\Controllers\ErrorController;

session_start();

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
//Rutas de usuarios
$map->get('getLogin', '/login', [
	'controller' => 'App\Controllers\UsersController',
	'action' => 'getLogin'
]);
$map->get('getLogout', '/logout', [
	'controller' => 'App\Controllers\UsersController',
	'action' => 'getLogout',
	'auth' => true
]);
$map->post('login', '/login', [
	'controller' => 'App\Controllers\UsersController',
	'action' => 'getLogin'
]);
$map->get('getRegister', '/registrar', [
	'controller' => 'App\Controllers\UsersController',
	'action' => 'getRegister',
	'auth' => true
]);
$map->post('register', '/registrar', [
	'controller' => 'App\Controllers\UsersController',
	'action' => 'getRegister',
	'auth' => true
]);
//Rutas de conocimiento
$map->get('knowledge', '/conocimiento', [
	'controller' => 'App\Controllers\KnowledgesController',
	'action' => 'getKnowledgeForm',
	'auth' => true
]);
$map->post('addKnowledge', '/conocimiento/subir', [
	'controller' => 'App\Controllers\KnowledgesController',
	'action' => 'addKnowledge',
	'auth' => true
]);
$map->get('getEditKnowledge', '/conocimiento/editar', [
	'controller' => 'App\Controllers\KnowledgesController',
	'action' => 'getEditKnowledge',
	'auth' => true
]);
$map->post('editKnowledge', '/conocimiento/editar', [
	'controller' => 'App\Controllers\KnowledgesController',
	'action' => 'getEditKnowledge',
	'auth' => true
]);
$map->get('deleteKnowledge', '/conocimiento/eliminar', [
	'controller' => 'App\Controllers\KnowledgesController',
	'action' => 'deleteKnowledge',
	'auth' => true
]);
//Rutas de sobre mi
$map->get('about', '/sobre', [
	'controller' => 'App\Controllers\AboutsController',
	'action' => 'getAbout',
	'auth' => true
]);
$map->post('aboutSave', '/sobre', [
	'controller' => 'App\Controllers\AboutsController',
	'action' => 'getAbout',
	'auth' => true
]);
//Ruta de portafolio
$map->get('portfolio', '/portafolio', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'getPortfolio',
	'auth' => true
]);
$map->post('addPortfolio', '/portafolio/subir', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'addPortfolio',
	'auth' => true
]);
$map->get('getEditPortfolio', '/portafolio/editar', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'getEditPortfolio',
	'auth' => true
]);
$map->post('editPortfolio', '/portafolio/editar', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'getEditPortfolio',
	'auth' => true
]);
$map->get('deletePortfolio', '/portafolio/eliminar', [
	'controller' => 'App\Controllers\PortfoliosController',
	'action' => 'deletePortfolio',
	'auth' => true
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
	$needsAuth = $handler['auth'] ?? false;
	$sessionUser = $_SESSION['userId'] ?? null;

	if ($needsAuth && !$sessionUser) {
		$controllerName = new ErrorController();
		$actionName = 'get404';
	}

	$controller = new $controllerName;
	$response = $controller->$actionName($request);

	foreach ($response->getHeaders() as $name => $values) {
		foreach ($values as $value) {
			header(sprintf('%s: %s', $name, $value), false);
		}
	}

	http_response_code($response->getStatusCode());
	echo $response->getBody();
}
