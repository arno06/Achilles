<?php
namespace app\main\controllers\front
{

    use app\main\models\ModelPost;
    use app\main\src\application\AchillesController;
    use core\application\Core;

    class index extends AchillesController
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            $cat = null;
            if(Core::checkRequiredGetVars('cat'))
                $cat = $_GET['cat'];
            $this->setTitle('Achilles');

            $m = new ModelPost();

            $this->addContent('posts', $m->getPostsByDay($cat));
        }
    }
}