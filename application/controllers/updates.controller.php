<?php
session_start();

if(!isset($_SESSION['auth'])) {
    header('Location: index.php');
}

require_once 'application/libs/config.php';

$model = new Member_Model();
$ctrl = new Member_Controller($model);
$view = new Member_View($model, $ctrl, 'MVC Lister', 'member');

