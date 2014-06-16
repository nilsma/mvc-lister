<?php

if(!class_exists('Base_View')) {

    class Base_View {

        protected $model;
        private $ctrl;
        private $title;
        private $page_id;

        public function __construct(Base_Model $model, Base_Controller $ctrl, $title, $page_id) {
            $this->model = $model;
            $this->ctrl = $ctrl;
            $this->title = $title;
            $this->page_id = $page_id;
        }

        public function render() {

        }

        public function buildNavigation() {
            $nav = $this->model->getNavigation();

            $html = '';
            $html .= '<nav>' . "\n";
            $html .= '<ul id="nav_list">' . "\n";

            foreach($nav as $label => $url) {
                if($label == 'logout') {
                    $html .= '<li><a href="#" onclick="return confirmLogout()">' . ucwords($label) . '</a></li>' . "\n";
                } else {
                    $html .= '<li><a href="' . $url . '">' . ucwords($label) . '</a></li>' . "\n";
                }
            }

            $html .= '</ul>' . "\n";
            $html .= '</nav>' . "\n";

            return $html;
        }

        public function buildHeader($page_id) {
            $html = '';
            $html .= '<meta name="viewport" content="width=device-width, user-scalable=yes">' . "\n";
            $html .= '<link rel="stylesheet" href="../../public/css/main.css">' . "\n";
            $html .= '<link rel="stylesheet" href="../../public/css/navigation.css">' . "\n";
            $html .= '<link rel="stylesheet" href="../../public/css/' . $page_id . '.css">' . "\n";

            if(isset($_SESSION['auth'])) {
                $html .= '<script src="../../public/js/' . $page_id . '.js"></script>' . "\n";
            }

            $html .= '<title>Lister</title>' . "\n";
            $html .= '</head>' . "\n";
            $html .= '<body id="' . $page_id . '">' . "\n";
            $html .= '<div id="main_container">' . "\n";
            $html .= '<header>' . "\n";

            if(isset($_SESSION['auth'])) {
                $html .= '<div id="welcome">' . "\n";
                $html .= '<p>Logged in as <span>' . $_SESSION['username'] . '</span></p>' . "\n";
                $html .= '</div>' . "\n";
                $html .= '<div id="logo">' . "\n";
                $html .= '<h1><a href="member.php">Lister</a></h1>' . "\n";
                $html .= '<img id="hamburger" src="../../public/images/hamburger_black_small.png" alt="menu trigger image"/>' . "\n";
                $html .= '</div> <!-- end #logo -->' . "\n";
                $html .= $this->buildNavigation();
            } else {
                $html .= '<h1><a href="index.php">Lister</a></h1>' . "\n";
            }

            $html .= '</header>' . "\n";

            $html .= '<div id="inner_container" class="guv">' . "\n";

            return $html;
        }

        public function buildErrors($errors) {
            $html = '';
            $html .= '<div id="errors">' . "\n";
            $html .= '<p>The following errors occured: </p>' . "\n";
            $html .= '<ul>' . "\n";

            foreach($errors as $error) {
                $html .= '<li>' . $error . '</li>' . "\n";
            }

            $html .= '</ul>' . "\n";
            $html .= '</div> <!-- end #errors -->' . "\n";

            return $html;
        }

        public function buildSuccess($success) {
            $html = '';
            $html .= '<div id="success">' . "\n";
            $html .= '<ul>' . "\n";

            foreach($success as $succeed) {
                $html .= '<li>' . $succeed . '</li>' . "\n";
            }

            $html .= '</ul>' . "\n";
            $html .= '</div> <!-- end #success -->' . "\n";

            return $html;
        }

    }

}

?>