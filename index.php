<?php
header('Content-Type: text/html; charset=UTF-8');

define('ROOT', __DIR__);

$controller = $_GET['controller'] ?? 'article';
$action     = $_GET['action']     ?? 'index';

$allowedControllers = ['article', 'categorie'];
$allowedActions     = ['index', 'admin', 'create', 'edit', 'delete'];

if (!in_array($controller, $allowedControllers) || !in_array($action, $allowedActions)) {
    $controller = 'article';
    $action     = 'index';
}

require_once ROOT . '/controllers/' . ucfirst($controller) . 'Controller.php';

$className = ucfirst($controller) . 'Controller';
$ctrl = new $className();
$ctrl->$action();
