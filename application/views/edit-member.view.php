<?php
if(!class_exists('Edit_Member_Vieww')) {

    class Edit_Member_View extends Base_View {

        protected $page_id;

        public function __construct($model, $ctrl, $title, $page_id) {
            $this->page_id = $page_id;
            parent::__construct($model, $ctrl, $title, $page_id);
        }

        public function render() {
            include '../application/templates/head.html';

            $html = '' . "\n";

            $html .= $this->buildHeader($this->page_id);
            $html .= $this->buildChangePasswordForm();
            $html .= $this->buildChangeEmailForm();

            echo $html;

            include '../application/templates/footer.html';
        }

        public function buildChangeEmailForm() {
            $html = '';

            if(isset($_SESSION['errors']) && count($_SESSION['errors']) >= 1) {
                $html .= $this->buildErrors($_SESSION['errors']);
                $_SESSION['errors'] = false;
                unset($_SESSION['errors']);
            }

            if(isset($_SESSION['success']) && count($_SESSION['success']) >= 1) {
                $html .= $this->buildSuccess($_SESSION['success']);
                $_SESSION['success'] = false;
                unset($_SESSION['success']);
            }

            $html .= '<div id="edit_email">' . "\n";
            $html .= '<form name="edit_email_form" action="' . $_SERVER['PHP_SELF'] . '" method="POST">' . "\n";
            $html .= '<label for="current_email">Current email:</label><input name="current_email" type="email" value="' . $_SESSION['email'] . '" disabled>' . "\n";
            $html .= '<label for="new_email">New email:</label><input name="new_email" type="email" maxlength="30">' . "\n";
            $html .= '<label for="repeat_email">Repeat email:</label><input name="repeat_email" type="email" maxlength="30">' . "\n";
            $html .= '<input name="change_email" type="submit" value="Change">' . "\n";
            $html .= '</form>' . "\n";
            $html .= '</div> <!-- end #edit_email -->' . "\n";

            return $html;
        }

        public function buildChangePasswordForm() {
            $html = '';

            if(isset($_SESSION['errors']) && count($_SESSION['errors']) >= 1) {
                $html .= $this->buildErrors($_SESSION['errors']);
                $_SESSION['errors'] = false;
                unset($_SESSION['errors']);
            }

            if(isset($_SESSION['success']) && count($_SESSION['success']) >= 1) {
                $html .= $this->buildSuccess($_SESSION['success']);
                $_SESSION['success'] = false;
                unset($_SESSION['success']);
            }

            $html .= '<div id="edit_password">' . "\n";
            $html .= '<form name="edit_password" action="' . $_SERVER['PHP_SELF'] . '" method="POST">' . "\n";
            $html .= '<label for="current_password">Current password:</label>';
            $html .= '<input name="current_password" type="password" required>' . "\n";
            $html .= '<label for="new_password">New password:</label>';
            $html .= '<input name="new_password" type="password" required>' . "\n";
            $html .= '<label for="repeat_password">Repeat password:</label>';
            $html .= '<input name="repeat_password" type="password">' . "\n";
            $html .= '<input name="change_password" type="submit" value="Change">' . "\n";
            $html .= '</form>' . "\n";
            $html .= '</div> <!-- end #edit_password -->' . "\n";

            return $html;
        }

    }

}