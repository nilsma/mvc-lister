<?php
session_start();

require_once 'config.php';
require_once 'application/models/model.class.php';
require_once 'application/controllers/controller.class.php';
require_once 'application/views/view.class.php';

$model = new Model();
$ctrl = new Controller($model);
$view = new View($model, $ctrl, 'MVC Lister', 'index');

$head = array();
$head[] = '<meta charset="UTF-8">' . "\n";
$head[] = '<link rel="stylesheet" href="public/css/main.css">' . "\n";
$head[] = '<script type="text/javascript" src="public/js/main.js"></script>' . "\n";

$table = $ctrl->buildUsersTable();

$body = '';
$body = $body . '<div id="main-container">' . "\n";
$body = $body . '<h1>My List Application</h1>' . "\n";
$body = $body . '<p>lkdf jlskdfj slkdfj slkdfj sldkfj slkdfj sldkfj slkdfj slkdjf lskdfj slkdfj</p>' . "\n";
$body = $body . '<p>lkdf jlskdfj slkdfj slkdfj sldkfj slkdfj sldkfj slkdfj slkdjf lskdfj slkdfj</p>' . "\n";
$body = $body . '<p>lkdf jlskdfj slkdfj slkdfj sldkfj slkdfj sldkfj slkdfj slkdjf lskdfj slkdfj</p>' . "\n";
$body = $body . '<h2>List of members</h2>' . "\n";
$body = $body . $table;
$body = $body . '</div> <!-- end #main-cotainer -->' . "\n";

$footer = '';
$footer = '<h2>Some footer content here ...</h2>' . "\n";
$footer = '<h2>Some more footer content ...</h2>' . "\n";

$view->render($head, $body, $footer);

?>