<?php
session_start();

require_once '../application/libs/config.php';

$model = new Login_Model();
$ctrl = new Login_Controller($model);
$view = new Login_View($model, $ctrl, 'MVC Lister', 'login');

$_SESSION['errors'] = array();

if(isset($_POST['submit'])) {
    $ctrl->login($_POST['username'], $_POST['password']);
    header('Location: member.php');
    exit();
}

$view->render();