<?php
require_once 'base.view.php';

if(!class_exists('Login_View')) {

    class Login_View extends Base_View {

        protected $page_id;

        public function __construct($model, $controller, $title, $page_id) {
            $this->page_id = $page_id;
            parent::__construct($model, $controller, $title, $page_id);
        }

        public function render() {
            include '../application/templates/head.html';

            $html = '' . "\n";
            $html .= $this->buildHeader($this->page_id);
            $html .= '<div id="presentation">' . "\n";
            $html .= '<p>A simple, basic and free list making application!</p>' . "\n";
            $html .= '<p>Create, update and share your lists where ever you go! <a href="about.php">Read more about Lister!</a></p>' . "\n";
            $html .= '</div> <!-- end #presentation -->' . "\n";
            $html .= $this->buildLoginForm();

            echo $html;

            include '../application/templates/footer.html';
        }

        public function buildLoginForm() {
            $username = $this->fetchUsername();

            $html = '';
            $html .= '<div id="login">' . "\n";

            if(count($_SESSION['errors']) >= 1) {
                $html .= $this->buildErrors($_SESSION['errors']);
            }

            $html .= '<form name="login_form" action="' . $_SERVER['PHP_SELF'] . '" method="POST">' . "\n";
            $html .= '<label for="username">Username:</label><input name="username" id="username" type="text" value="'. $username . '" required>' . "\n";
            $html .= '<label for="password">Password:</label><input name="password" id="password" type="password" required>' . "\n";
            $html .= '<input type="submit" name="submit" value="Login">' . "\n";
            $html .= '</form>' . "\n";

            $html .= '<p>Or <a href="register.php">register</a></p>' . "\n";
            $html .= '</div> <!-- end #login -->' . "\n";

            return $html;
        }

        public function fetchUsername() {

            if(isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
            } else {
                $username = '';
            }

            return $username;
        }

    }
}
?>