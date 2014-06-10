<?php
if(!class_exists('Invitations_View')) {

    class Invitations_View extends Base_View {

        public $page_id;

        public function __construct($model, $ctrl, $title, $page_id) {
            $this->page_id = $page_id;
            parent::__construct($model, $ctrl, $title, $page_id);
        }

        public function render() {
            include 'application/templates/head.html';

            $html = "\n";
            $html .= $this->buildHeader($this->page_id);
            $html .= $this->buildInviteForm();

            echo $html;

            include 'application/templates/footer.html';
        }

        public function buildInviteForm() {
            $lists = $this->model->getLists($_SESSION['user_id']);

            $html = '';

            $html .= '<div id="invite">' . "\n";

            if((isset($_SESSION['inv_errors'])) && (count($_SESSION['inv_errors']) >= 1)) {
                $inv_errors = $_SESSION['inv_errors'];
                $_SESSION['inv_errors'] = false;
                unset($_SESSION['inv_errors']);

                $html .= '<div id="errors">' . "\n";
                $html .= '<ul>' . "\n";

                foreach($inv_errors as $error) {
                    $html .= '<li>' . $error . '</li>' . "\n";
                }

                $html .= '</ul>' . "\n";
                $html .= '</div> <!-- end #invitation_errors -->' . "\n";
            }

            if(count($lists) >= 1) {
                $html .= '<form name="invite_form" action="" method="POST">' . "\n";
                $html .= '<select name="invite_list_title">' . "\n";

                foreach($lists as $list_id => $title) {
                    $html .= '<option value="' . $title . '">' . $title . '</option>' . "\n";
                }

                $html .= '</select>' . "\n";
                $html .= '<input type="text" name="invite_username" maxlength="30">' . "\n";
                $html .= '<input type="submit" name="submit_invite" value="Invite">' . "\n";
                $html .= '</form>' . "\n";
            } else {
                $html .= '<p>You haven\'t made any lists yet';
            }

            $html .= '</div> <!-- end #invite -->' . "\n";

            return $html;
        }

    }

}