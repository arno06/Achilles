<?php
namespace app\main\src\application{

    use core\application\Authentication\AuthenticationHandler;
    use core\application\DefaultController;

    class AchillesController extends DefaultController
    {
        public function __construct()
        {

        }

        public function render($pDisplay = true)
        {
            $this->addContent('user_data', AuthenticationHandler::$data);
            return parent::render($pDisplay);
        }


    }
}