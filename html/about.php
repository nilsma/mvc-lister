<?php
session_start();

require_once 'application/libs/config.php';

$model = new Base_Model();
$ctrl = new Base_Controller($model);
$view = new About_View($model, $ctrl, 'MVC Lister', 'about');

$view->render();