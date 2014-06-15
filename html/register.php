<?php
session_start();

require_once '../application/libs/config.php';

$model = new Register_Model();
$ctrl = new Register_Controller($model);
$view = new Register_View($model, $ctrl, 'MVC Lister', 'register');

if(isset($_POST['submit'])) {
    $ctrl->registerUser($_POST['username'], $_POST['email'], $_POST['password1'], $_POST['password2']);
}

$view->render();
