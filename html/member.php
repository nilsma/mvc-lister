<?php
session_start();

if(!isset($_SESSION['auth'])) {
    header('Location: index.php');
}

require_once '../application/libs/config.php';

$model = new Member_Model();
$ctrl = new Member_Controller($model);
$view = new Member_View($model, $ctrl, 'MVC Lister', 'member');

$_SESSION['user_id'] = $ctrl->getCurrentUserId();
$_SESSION['email'] = $ctrl->getUserEmail();

if(!isset($_SESSION['chosen'])) {
    $lists = $ctrl->getAllLists($_SESSION['user_id']);
    $_SESSION['chosen'] = key($lists);
    $owner_id = reset($lists);
    $ctrl->setCurrentList($_SESSION['chosen'], $owner_id);
}

if(isset($_POST['check_updates'])) {
    $updates = $view->buildItems($_SESSION['chosen']);
    header('Content-type: application/json');
    echo json_encode($updates);
    exit();
}

if(isset($_POST['load_list']) && isset($_POST['list_owner'])) {
    $ctrl->setCurrentList($_POST['load_list'], $_POST['list_owner']);
    header('Location: member.php');
    exit();
}

if(isset($_POST['submit_list'])) {
    $ctrl->addList($_POST['title']);
    $ctrl->setCurrentList($_POST['title'], $_SESSION['username']);
    header('Location: member.php');
    exit();
}

if(isset($_POST['submit_item'])) {
    $ctrl->addItem($_SESSION['chosen'], htmlspecialchars($_POST['new_item']));
    header('Location: member.php');
    exit();
}

if(isset($_POST['item_name'])) {
    $ctrl->removeItem($_SESSION['chosen'], $_POST['item_name']);
    header('Location: member.php');
    exit();
}

if(isset($_POST['toggle_item'])) {
    $ctrl->toggleItem($_SESSION['chosen'], Utils::washInput($_POST['toggle_item']));
    header('Location: member.php');
    exit();
}

$view->render();