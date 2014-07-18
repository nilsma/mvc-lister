<?php
session_start();

if(!isset($_SESSION['auth'])) {
    header('Location: index.php');
}

require_once '../application/libs/config.php';

$model = new Edit_Lists_Model();
$ctrl = new Edit_Lists_Controller($model);
$view = new Edit_Lists_View($model, $ctrl, 'MVC Lister', 'edit-lists');

if(isset($_POST['submit_list'])) {
    $ctrl->addList($_POST['title']);
    header('Location: edit-lists.php');
    exit();
}

if(isset($_POST['remove_list'])) {
    $_SESSION['list_to_remove'] = $_POST['remove_list'];
    $ctrl->removeList($_POST['remove_list']);
    header('Location: edit-lists.php');
    exit();
}

if(isset($_POST['edit_list'])) {
    $_SESSION['list_to_edit'] = $_POST['edit_list'];
    header('Location: edit-list.php');
    exit();
}

$view->render();