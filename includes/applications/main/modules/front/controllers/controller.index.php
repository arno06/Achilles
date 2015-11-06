<?php
namespace app\main\controllers\front
{

    use app\main\models\ModelPost;
    use app\main\src\application\AchillesController;

    class index extends AchillesController
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            $this->setTitle('Achilles');

            $m = new ModelPost();

            $this->addContent('posts', $m->getPostsByDay());
        }
    }
}