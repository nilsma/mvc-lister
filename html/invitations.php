<?php
session_start();

if(!isset($_SESSION['auth'])) {
    header('Location: index.php');
}

require_once 'application/libs/config.php';

$model = new Invitations_Model();
$ctrl = new Invitations_Controller($model);
$view = new Invitations_View($model, $ctrl, 'MVC Lister', 'invitations');

if(isset($_POST['submit_invite'])) {
    $_SESSION['invite_list_title'] = $_POST['invite_list_title'];
    $ctrl->inviteUser($_POST['invite_username'], $_POST['invite_list_title']);
    header('Location: invitations.php');
    exit();
}

$view->render();