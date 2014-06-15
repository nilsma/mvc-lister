<?php
session_start();

if(!isset($_SESSION['auth'])) {
    header('Location: index.php');
}

require_once '../application/libs/config.php';

$model = new Invitations_Model();
$ctrl = new Invitations_Controller($model);
$view = new Invitations_View($model, $ctrl, 'MVC Lister', 'invitations');

if(isset($_POST['submit_invite'])) {
    $_SESSION['invite_list_title'] = $_POST['invite_list_title'];
    $ctrl->inviteUser($_POST['invite_username'], $_POST['invite_list_title']);
    header('Location: invitations.php');
    exit();
}

if(isset($_POST['accept_name']) && !empty($_POST['accept_name']) && !empty($_POST['accept_title']) && isset($_POST['accept_title'])) {
    $ctrl->acceptInvitation($_POST['accept_name'], $_POST['accept_title']);
    header('Location: invitations.php');
    exit();
}

if(isset($_POST['decline_name']) && !empty($_POST['decline_name']) && !empty($_POST['decline_title']) && isset($_POST['decline_title'])) {
    $ctrl->declineInvitation($_POST['decline_name'], $_POST['decline_title']);
    header('Location: invitations.php');
    exit();
}

if(isset($_POST['members_name']) && !empty($_POST['members_name']) && !empty($_POST['members_title']) && isset($_POST['members_title'])) {
    $ctrl->removeMembership($_POST['members_name'], $_POST['members_title']);
    header('Location: invitations.php');
    exit();
}

if(isset($_POST['cancel_name']) && !empty($_POST['cancel_name']) && !empty($_POST['cancel_title']) && isset($_POST['cancel_title'])) {
    $ctrl->cancelInvitation($_POST['cancel_name'], $_POST['cancel_title']);
    header('Location: invitations.php');
    exit();
}

$view->render();