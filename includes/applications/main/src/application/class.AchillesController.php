<?php
namespace app\main\src\application{

    use core\application\Application;
    use core\application\authentication\AuthenticationHandler;
    use core\application\DefaultController;

    class AchillesController extends DefaultController
    {
        public function __construct()
        {
            /** @var AuthenticationHandler $auth */
            $auth = Application::getInstance()->authenticationHandler;
            $auth::getInstance();
            $this->addContent('user_data', AuthenticationHandler::$data);
        }

        public function not_found()
        {
            $this->setTemplate(null, null, 'template.404.tpl');
        }
    }
}