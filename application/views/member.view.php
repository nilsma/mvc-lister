<?php
if(!class_exists('Member_View')) {

    class Member_View extends Base_View {

        protected $model;
        protected $ctrl;
        protected $page_id;

        public function __construct(Member_Model $model, Member_Controller $controller, $title, $page_id) {
            $this->model = $model;
            $this->ctrl = $controller;
            $this->page_id = $page_id;
            parent::__construct($model, $controller, $title, $page_id);
        }

        public function render() {
            include '../application/templates/head.html';

            $html = "\n";
            $html .= $this->buildHeader($this->page_id);
            $html .= $this->buildLists($_SESSION['user_id']) . "\n";

            $html .= '<div id="items">' . "\n";
            $html .= '<div id="items_container">' . "\n";
            $html .= $this->buildItems($_SESSION['chosen']) . "\n";
            $html .= '</div> <!-- end #items_container -->' . "\n";
            $html .= $this->buildAddItemsForm();
            $html .= '</div> <!-- end #items -->' . "\n";

            echo $html;

            include '../application/templates/footer.html';
        }

        public function buildLists() {
            $lists = $this->ctrl->getAllLists();

            $html = '' . "\n";

            if(isset($_SESSION['errors']) && count($_SESSION['errors']) >= 1) {
                $html .= $this->buildErrors($_SESSION['errors']);
                $_SESSION['errors'] = false;
                unset($_SESSION['errors']);
            }

            $html .= '<div id="lists">' . "\n";
            $html .= '<h2>My lists:</h2>' . "\n";

            if(count($lists) >= 1) {
                $html .= '<form name="load_list" action="' . $_SERVER['PHP_SELF'] . '" method="POST">' . "\n";
                $html .= '<p>' . "\n";
                $html .= '<select name="chosen">' . "\n";

                foreach($lists as $list_id => $owner_id) {
                    $title = $this->model->getListTitle($list_id);
                    $owner = $this->model->getUsername($owner_id);
                    $class = '';
                    if($owner_id == $_SESSION['user_id']) {
                        $class = 'owner';
                    } else {
                        $class = 'member';
                    }

                    if($list_id == $_SESSION['chosen']) {
                        $html .= '<option value="{\'user\':\'' . $owner . '\',\'title:\'' . $title . '\'}" class="' . $class . '" selected>' . ucfirst($title) . '</option>' . "\n";
                    } else {
                        $html .= '<option value="{\'user\':\'' . $owner . '\',\'title\':\''. $title . '\'}" class="' . $class . '">' . ucfirst($title) . '</option>' . "\n";
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

        public function buildItems($list_id) {
            $items = $this->model->getItems($list_id);

            $html = '';

            $html .= '<h2>Items in ' . $_SESSION['chosen'] . ':</h2>' . "\n";

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

            return $html;
        }

        public function buildAddItemsForm() {
            $html = '';

            $html .= '<form name="add_item" action="' . $_SERVER['PHP_SELF'] . '" method="POST">' . "\n";
            $html .= '<label for="new_item">Item: </label><input name="new_item" type="text" maxlength="30">' . "\n";
            $html .= '<input name="submit_item" type="submit" value="Add item">' . "\n";
            $html .= '</form>' . "\n";

            return $html;
        }

    }

}