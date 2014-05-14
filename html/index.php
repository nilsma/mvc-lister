<?php
session_start();

require_once 'config.php';
require_once 'application/models/model.class.php';
require_once 'application/controllers/controller.class.php';
require_once 'application/views/view.class.php';

$model = new Model();
$ctrl = new Controller($model);
$view = new View($model, $ctrl, 'MVC Lister', 'index');

$headers = array();
$headers[] = '<meta charset="UTF-8">' . "\n";
$headers[] = '<link rel="stylesheet" href="public/css/main.css">' . "\n";
$headers[] = '<script type="text/javascript" src="public/js/main.js"></script>' . "\n";

$view->setHeaders($headers);

$view->render();

?>