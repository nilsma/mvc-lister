<?php
if(!class_exists('Base_Controller')) {

    class Base_Controller {

        public $model;

        public function __construct(Base_Model $model) {
            $this->model = $model;
        }

        public function addList($list_title) {
            $list_title = Utils::washInput(strtolower($list_title));
            if(!empty($list_title)) {
                $this->model->insertList($list_title);
            }
        }

    }

}
?>