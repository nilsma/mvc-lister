<?php
session_start();

if(!isset($_SESSION['auth'])) {
    header('Location: index.php');
}

require_once '../application/libs/config.php';

$model = new Edit_List_Model();
$ctrl = new Edit_List_Controller($model);
$view = new Edit_List_View($model, $ctrl, 'MVC Lister', 'edit-list');

if(isset($_POST['remove_member'])) {
    $ctrl->removeMembership($_POST['remove_member']);
}

if(isset($_POST['submit_edit'])) {
    $ctrl->updateListTitle($_POST['new_title']);
    header('Location: edit-list.php');
    exit();
}

$view->render();