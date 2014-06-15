<?php
if(!class_exists('Edit_Lists_Controller')) {

    class Edit_Lists_Controller extends Base_Controller {

        public $model;

        public function __construct(Edit_Lists_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function removeList($list_name) {
            $list_name = Utils::washInput($list_name);
            $list_id = $this->model->getListId($list_name);
            $this->model->deleteList($_SESSION['user_id'], $list_id);
        }

    }

}