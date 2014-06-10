<?php
if(!class_exists('Edit_Lists_View')) {

    class Edit_Lists_View extends Base_View {

        protected $page_id;

        public function __construct($model, $ctrl, $title, $page_id) {
            $this->page_id = $page_id;
            parent::__construct($model, $ctrl, $title, $page_id);
        }

        public function render() {
            include 'application/templates/head.html';

            $html = "\n";
            $html .= $this->buildHeader($this->page_id);
            $html .= $this->buildListsOverview();

            echo $html;

            include 'application/templates/footer.html';
        }

        public function buildListsOverview() {
            $lists = $this->model->getLists($_SESSION['user_id']);

            $html = '';
            $html .= '<div id="add_list">' . "\n";
            $html .= '<form name="add_list" method="POST" action="">' . "\n";
            $html .= '<label for="title">Title: </label>';
            $html .= '<input type="text" name="title" maxlength="30">' . "\n";
            $html .= '<input type="submit" name="submit_list" value="Add list">' . "\n";
            $html .= '</form>' . "\n";
            $html .= '</div> <!-- end #add_list -->' . "\n";
            $html .= '<div id="lists_overview">' . "\n";
            $html .= '<table>' . "\n";
            $html .= '<thead>' . "\n";
            $html .= '<tr><td>My Lists:</td><td></td><td></td></tr>' . "\n";
            $html .= '</thead>' . "\n";

            foreach($lists as $list) {
                $html .= '<tr><td>' . $list . '</td><td><button class="edit_list">Edit</button></td><td><button class="remove_list">Remove</button></td></tr>' . "\n";

            }

            $html .= '</table>' . "\n";
            $html .= '</div> <!-- end #lists_overview -->' . "\n";

            return $html;
        }

    }

}