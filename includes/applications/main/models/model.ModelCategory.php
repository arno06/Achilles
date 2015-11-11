<?php
namespace app\main\models
{

    use core\application\BaseModel;
    use core\application\routing\RoutingHandler;
    use core\db\Query;

    class ModelCategory extends BaseModel
    {
        public function __construct()
        {
            parent::__construct('main_category', 'id_category');
        }

        public function prepareCategories($pTags)
        {
            if(empty($pTags))
            {
                return array();
            }
            $ids = array();
            foreach($pTags as $t)
            {
                if(Query::count($this->table, Query::condition()->andWhere('name_category', Query::EQUAL, $t)))
                    continue;
                $permalink = RoutingHandler::sanitize($t);
                $this->insert(array('name_category'=>$t, 'permalink_category'=>$permalink));
                $ids[] = $this->getInsertId();
            }
            return $ids;
        }
    }
}