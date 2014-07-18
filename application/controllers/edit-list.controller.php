<?php
if(!class_exists('Edit_List_Controller')) {

    class Edit_List_Controller extends Base_Controller {

        public $model;

        public function __construct(Edit_List_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function removeMembership($member_name) {
            $member_name = trim($member_name);

            if(!empty($member_name)) {
                $member_id = $this->model->getUserId($member_name);
                $list_id = $this->model->getListId($_SESSION['list_to_edit']);
                $owner_id = $_SESSION['user_id'];
                $this->model->deleteMembership($owner_id, $list_id, $member_id);
            }
        }

        public function updateListTitle($new_title) {
            $errors = array();

            $current_title = $_SESSION['list_to_edit'];

            $new_title = trim($new_title);

            if(empty($new_title)) {
                $errors[] = 'You must enter a new name for the list';
            }

            if($new_title == $current_title){
                $errors[] = 'You cant rename it to the same name';
            }

            if($this->model->listExists($new_title)) {
                $errors[] = 'You already have a list with that name';
            }

            if(count($errors) >= 1) {
                $_SESSION['errors'] = $errors;
            } else {
                $list_id = $this->model->getListId($current_title);
                $this->model->setListTitle($list_id, $new_title);
                $_SESSION['list_to_edit'] = $new_title;
            }
        }

    }

}