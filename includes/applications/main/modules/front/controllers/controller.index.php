<?php
namespace app\main\controllers\front
{

    use app\main\src\application\AchillesController;

    class index extends AchillesController
    {
        public function __construct()
        {

        }

        public function index()
        {
            $this->setTitle('Achilles demo - \o/');
        }
    }
}