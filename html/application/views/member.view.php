<?php
if(!class_exists('Member_View')) {

    class Member_View extends Base_View {

        protected $model;
        protected $page_id;

        public function __construct(Member_Model $model, Member_Controller $controller, $title, $page_id) {
            $this->model = $model;
            $this->page_id = $page_id;
            parent::__construct($model, $controller, $title, $page_id);
        }

        public function render() {
            include 'application/templates/head.html';

            $html = "\n";
            $html .= $this->buildHeader($this->page_id);
            $html .= $this->buildLists($_SESSION['user_id']) . "\n";
            $html .= $this->buildItems() . "\n";
            echo $html;

            include 'application/templates/footer.html';
        }

        public function buildLists($user_id) {
            $lists = $this->model->getLists($user_id);

            //TODO refactor to controller setCurrentList
            if(isset($_SESSION['chosen'])) {
                $chosen = $_SESSION['chosen'];
            } else {
                $chosen = reset($this->model->getLists($user_id));
            }

            $html = '' . "\n";
            $html .= '<div id="lists">' . "\n";
            $html .= '<h2>My lists:</h2>' . "\n";

            if(count($lists) >= 1) {
                $html .= '<form name="load_list" action="' . $_SERVER['PHP_SELF'] . '" method="POST">' . "\n";
                $html .= '<p>' . "\n";
                $html .= '<select name="chosen">' . "\n";

                foreach($lists as $list_id => $title) {
                    if($title == $chosen) {
                        $html .= '<option value="' . $title . '" selected>' . ucfirst($title) . '</option>' . "\n";
                    } else {
                        $html .= '<option value="' . $title . '">' . ucfirst($title) . '</option>' . "\n";
                    }
                }

                $html .= '</select>' . "\n";
                $html .= '</p>' . "\n";
                $html .= '</form>' . "\n";
                $html .= '<button id="toggle_add_list">+</button>' . "\n";
            } else {
                $html .= '<p>You haven\'t made any lists yet</p>';
                $html .= '<button id="toggle_add_list">+</button>' . "\n";
            }

            $html .= '</div> <!-- end #lists -->' . "\n";

            $html .= '<div id="add_list_form">' . "\n";
            $html .= '<form name="add_list" method="POST" action="' . $_SERVER['PHP_SELF'] . '">' . "\n";
            $html .= '<label for="title">Title: </label>';
            $html .= '<input type="text" name="title" maxlength="30">' . "\n";
            $html .= '<input type="submit" name="submit_list" value="Add list">' . "\n";
            $html .= '</form>' . "\n";
            $html .= '</div> <!-- end #add_list_form -->' . "\n";

            return $html;
        }

        public function buildItems() {

            //TODO refactor to controller setCurrentList
            if(isset($_SESSION['chosen'])) {
                $chosen = $_SESSION['chosen'];
            } else {
                $chosen = reset($this->model->getLists($_SESSION['user_id']));
            }

            $items = $this->model->getItems($chosen);

            $html = '';

            $html .= '<div id="items">' . "\n";
            $html .= '<h2>Items in ' . $chosen . ':</h2>' . "\n";

            if(count($items) >= 1) {
                $html .= '<table>' . "\n";
                $html .= '<tr><td>Item</td><td></td></tr>' . "\n";

                foreach($items as $item) {
                    if($item['tapped'] == 1) {
                        $class_name = 'tapped';
                    } else {
                        $class_name = 'untapped';
                    }
                    $html .= '<tr><td class="item_name ' . $class_name . '">' . ucfirst($item['name']) . '</td>';
                    $html .= '<td><button class="remove_item">Remove</button></td></tr>' . "\n";
                }

                $html .= '</table>' . "\n";
            } else {
                $html .= '<p>You haven\'t added any items yet';
            }

            $html .= '<form name="add_item" action="' . $_SERVER['PHP_SELF'] . '" method="POST">' . "\n";
            $html .= '<label for="new_item">Item: </label><input name="new_item" type="text" maxlength="30">' . "\n";
            $html .= '<input name="submit_item" type="submit" value="Add item">' . "\n";
            $html .= '</form>' . "\n";

            $html .= '</div> <!-- end #items -->' . "\n";

            return $html;
        }

    }

}