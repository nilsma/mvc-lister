<?php
if(!class_exists('Edit_List_View')) {

    class Edit_List_View extends Base_View {

        protected $page_id;

        public function __construct($model, $ctrl, $title, $page_id) {
            $this->page_id = $page_id;
            parent::__construct($model, $ctrl, $title, $page_id);
        }

        public function render() {
            include '../application/templates/head.html';

            $html = "\n";
            $html .= $this->buildHeader($this->page_id);
            $html .= $this->buildListEdit();
            $html .= $this->buildListMembers();

            echo $html;

            include '../application/templates/footer.html';
        }

        public function buildListEdit() {
            $html = '';
            $html .= '<div id="edit_list_title">' . "\n";

            if(isset($_SESSION['errors']) && count($_SESSION['errors']) >= 1) {
                $html .= $this->buildErrors($_SESSION['errors']);
                $_SESSION['errors'] = false;
                unset($_SESSION['errors']);
            }

            $html .= '<form name="update_list" method="POST" action="' . $_SERVER['PHP_SELF'] . '">' . "\n";
            $html .= '<label for="current_title">Current title: </label>';
            $html .= '<input type="text" name="current_title" value="' . $_SESSION['list_to_edit'] . '" disabled>' . "\n";
            $html .= '<label for="new_title">New title: </label>';
            $html .= '<input type="text" name="new_title" value="">' . "\n";
            $html .= '<input type="submit" name="submit_edit" value="Update">' . "\n";
            $html .= '</form>' . "\n";
            $html .= '</div>' . "\n";

            return $html;
        }

        public function buildListMembers() {
            $list_id = $this->model->getListId($_SESSION['list_to_edit']);
            $member_ids = $this->model->getListMembers($list_id);

            $html = '';
            $html .= '<div id="current_members">' . "\n";
            $html .= '<h2>Current members</h2>' . "\n";

            if(count($member_ids) < 1) {
                $html .= '<p>There are no members for this list yet</p>';
            } else {

                $html .= '<table>' . "\n";

                foreach($member_ids as $member_id) {
                    $member_name = $this->model->getUsername($member_id);

                    $html .= '<tr>' . "\n";
                    $html .= '<td>' . $member_name . '</td>' . "\n";
                    $html .= '<td><button class="remove_member">Remove</button></td>' . "\n";
                    $html .= '</tr>' . "\n";
                }

                $html .= '</table>' . "\n";

            }

            $html .= '</div>' . "\n";
            return $html;
        }

    }

}