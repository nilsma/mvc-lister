<?php
if(!class_exists('Edit_Lists_View')) {

    class Edit_Lists_View extends Base_View {

        protected $page_id;

        public function __construct($model, $ctrl, $title, $page_id) {
            $this->page_id = $page_id;
            parent::__construct($model, $ctrl, $title, $page_id);
        }

        public function render() {
            include '../application/templates/head.html';

            $html = "\n";
            $html .= $this->buildHeader($this->page_id);
            $html .= $this->buildListsOverview();
            $html .= $this->buildEditListOverview();

            echo $html;

            include '../application/templates/footer.html';
        }

        public function buildListsOverview() {
            $html = '';

            if(isset($_SESSION['errors']) && count($_SESSION['errors']) >= 1) {
                $html .= $this->buildErrors($_SESSION['errors']);
                $_SESSION['errors'] = false;
                unset($_SESSION['errors']);
            }

            $html .= '<div id="add_list">' . "\n";
            $html .= '<form name="add_list" method="POST" action="' . $_SERVER['PHP_SELF'] . '">' . "\n";
            $html .= '<label for="title">Title: </label>';
            $html .= '<input type="text" name="title" maxlength="30">' . "\n";
            $html .= '<input type="submit" name="submit_list" value="Add list">' . "\n";
            $html .= '</form>' . "\n";
            $html .= '</div> <!-- end #add_list -->' . "\n";

            return $html;
        }

        public function buildEditListOverview() {
            $lists = $this->model->getOwnLists($_SESSION['user_id']);

            $html = '';
            $html .= '<div id="lists_overview">' . "\n";
            $html .= '<table>' . "\n";

            foreach($lists as $list_id => $user_id) {
                $list_title = $this->model->getListTitle($list_id);

                $html .= '<tr>' . "\n";
                $html .= '<td>' . ucfirst($list_title) . '</td>' . "\n";
                $html .= '<td>' . "\n";
                $html .= '<form name="edit_list" method="POST" action="' . $_SERVER['PHP_SELF'] . '">' . "\n";
                $html .= '<input name="edit_list" type="hidden" value="' . $list_title . '">' . "\n";
                $html .= '<input type="submit" value="Edit">' . "\n";
                $html .= '</form>' . "\n";
                $html .= '</td>' . "\n";
                $html .= '<td><button class="remove_list">Remove</button></td>' . "\n";
                $html .= '</tr>' . "\n";
            }

            $html .= '</table>' . "\n";
            $html .= '</div> <!-- end #lists_overview -->' . "\n";

            return $html;
        }

    }

}