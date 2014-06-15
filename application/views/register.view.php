<?php

require_once 'base.view.php';

if(!class_exists('Register_View')) {

    class Register_View extends Base_View {

        protected $page_id;

        public function __construct($model, $controller, $title, $page_id) {
            $this->page_id = $page_id;
            parent::__construct($model, $controller, $title, $page_id);
        }

        public function render() {
            include '../application/templates/head.html';

            $html = '' . "\n";

            $html .= $this->buildHeader($this->page_id);
            $html .= $this->buildRegistrationForm();

            echo $html;

            include '../application/templates/footer.html';
        }

        public function buildRegistrationForm() {
            $username = '';
            $email = '';

            $html = '';
            $html .= '<div id="registration">' . "\n";

            if(isset($_SESSION['errors']) && count($_SESSION['errors']) >= 1) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $html .= $this->buildErrors($_SESSION['errors']);
                $_SESSION['errors'] = false;
                unset($_SESSION['errors']);
            }

            $html .= '<form name="register_form" action="' . $_SERVER['PHP_SELF'] . '" method="POST">' . "\n";
            $html .= '<label for="username">Username:</label><input name="username" id="username" type="text" value="' . $username . '" required>' . "\n";
            $html .= '<label for="email">Email:</label><input name="email" id="email" type="email" value="' . $email . '" required>' . "\n";
            $html .= '<label for="password1">Password:</label><input name="password1" id="password1" type="password" required>' . "\n";
            $html .= '<label for="password2">Repeat:</label><input name="password2" id="password2" type="password" required>' . "\n";
            $html .= '<input type="submit" name="submit" value="Register">' . "\n";
            $html .= '</form>' . "\n";

            $html .= '<p>Or <a href="login.php">login</a></p></a>' . "\n";
            $html .= '</div> <!-- end #registration -->' . "\n";

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

        public function fetchEmail() {
            if(isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
            } else {
                $email = '';
            }

            return $email;
        }

    }

}

?>