<?php
namespace app\main\models
{

    use core\application\BaseModel;

    class ModelCategory extends BaseModel
    {
        public function __construct()
        {
            parent::__construct('main_category', 'id_category');
        }
    }
}