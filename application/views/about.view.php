<?php

require_once 'base.view.php';

if(!class_exists('About_View')) {

    class About_View extends Base_View {

        protected $page_id;

        public function __construct($model, $controller, $title, $page_id) {
            $this->page_id = $page_id;
            parent::__construct($model, $controller, $title, $page_id);
        }

        public function render() {
            include '../application/templates/head.html';

            $html = '';
            $html .= $this->buildHeader($this->page_id);
            $html .= '<div id="about">' . "\n";
            $html .= '<p>Lister is a simple and basic list making application ';
            $html .= 'to create and update your lists where ever you go.' . "\n";
            $html .= '<p>With Lister you can also share lists with friends, ';
            $html .= 'making it easy to make changes to the same list at the same time, ';
            $html .= 'and see the changes immidiately!</p>' . "\n";
            $html .= '<p>Lister is a personal programming project essentially made for programming practice, ';
            $html .= 'but anyone is welcome to try or use the application for free!</p>' . "\n";
            $html .= '<p>However, you should be aware that the application is subject to continual changes ';
            $html .= 'and I cannot guarantee uptime, backups, or longevity of the project.</p>' . "\n";
            $html .= '<p>So you would probably not want to rely on Lister as a permanent storage of ';
            $html .= 'your lists - not yet anyway</p>' . "\n";
            $html .= '<p>Any feedback about the application\'s <a href="#">code</a> in particular, ';
            $html .= 'or anything else, is most welcome at <a id="email" href="mailto:lister%40nima-design%2enet?subject=Web Design" title="Send me an email">lister@nima-design.net</a></p>';
            $html .= '<p><a href="register.php">Register</a> or <a href="login.php">login</a> to start using Lister.</p>' . "\n";
            $html .= '</div>' . "\n";

            echo $html;

            include '../application/templates/footer.html';
        }
    }
}