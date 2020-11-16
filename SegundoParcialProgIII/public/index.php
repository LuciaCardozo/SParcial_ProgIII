<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\AppConfig;
use App\Controllers\UsuarioController;
use App\Controllers\MateriaController;
use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddleware;

require __DIR__ . '/../vendor/autoload.php';

new AppConfig;

$app = AppFactory::create();
$app->setBasePath('/Ejercicios/SegundoParcialProgIII/public');


$app->group('/users', function (RouteCollectorProxy $group) {
    $group->post('[/]', UsuarioController::class . ":addOne");
})/*->add(new AuthMiddleware)->add(new JsonMiddleware)*/;

$app->group('/login', function (RouteCollectorProxy $group) {
    $group->post('[/]', UsuarioController::class . ":logIn");
});

$app->group('/materia', function (RouteCollectorProxy $group) {  
    $group->post('[/]', MateriaController::class . ":addMateria")->add(new AuthMiddleware('admin'));
    $group->get('[/]', MateriaController::class. ":getAll");
});

$app->group('/inscripcion', function (RouteCollectorProxy $group) {  
    $group->post('[/{id}]', MateriaController::class . ":inscripcionMaterias")->add(new AuthMiddleware('alumno'));
    $group->post('[/notas/{id}]', MateriaController::class . ":inscripcionMaterias")->add(new AuthMiddleware('profesor'));
});

$app->run();