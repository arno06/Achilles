<?php
namespace app\main\src\application{

    use app\main\models\ModelCategory;
    use core\application\Application;
    use core\application\authentication\AuthenticationHandler;
    use core\application\DefaultController;
    use core\db\Query;

    class AchillesController extends DefaultController
    {
        public function __construct()
        {
            /** @var AuthenticationHandler $auth */
            $auth = Application::getInstance()->authenticationHandler;
            $auth::getInstance();
            $this->addContent('user_data', AuthenticationHandler::$data);
            $m = new ModelCategory();
            $this->addContent('categories', $m->all(Query::condition()->order('name_category', 'ASC')));
        }

        public function not_found()
        {
            $this->setTemplate(null, null, 'template.404.tpl');
        }
    }
}