<?php
session_start();

require_once 'application/libs/config.php';

$model = new Edit_Member_Model();
$ctrl = new Edit_Member_Controller($model);
$view = new Edit_Member_View($model, $ctrl, 'MVC Lister', 'edit-member');

if(!isset($_SESSION['auth'])) {
    header('Location: index.php');
}

if(isset($_POST['change_password'])) {
    $ctrl->changePassword($_POST['current_password'], $_POST['new_password'], $_POST['repeat_password']);
    header('Location: edit-member.php');
    exit();
}

if(isset($_POST['change_email'])) {
    $ctrl->changeEmail($_POST['new_email'], $_POST['repeat_email']);
    header('Location: edit-member.php');
    exit();
}

$view->render();