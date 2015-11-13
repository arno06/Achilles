<?php
namespace app\main\models
{

    use app\main\src\tools\SimpleScraper;
    use core\application\Authentication\AuthenticationHandler;
    use core\application\BaseModel;
    use core\db\Query;
    use core\tools\Request;
    use core\utils\SimpleRandom;

    class ModelPost extends BaseModel
    {
        public function __construct()
        {
            parent::__construct("main_post", "id_post");
            $this->addJoinOnSelect('main_user');
        }

        public function oneByPermalink($pPermalink)
        {
            return $this->one(Query::condition()->andWhere("permalink_post", Query::EQUAL, $pPermalink));
        }

        public function share($pData)
        {
            $pData['added_date_post'] = "NOW()";
            $pData['id_user'] = AuthenticationHandler::$data['id_user'];
            $pData['status_post'] = 1;
            $pData['permalink_post'] = $this->generatePermalink();
            $id_tags = array();
            if(isset($pData['tags_post'])&&!empty($pData['tags_post']))
            {
                $tags = explode(",",$pData['tags_post']);
                foreach($tags as &$t)
                {
                    $t = trim($t);
                }
                $m = new ModelCategory();
                $id_tags = $m->prepareCategories($tags);
                unset($pData['tags_post']);
            }
            $this->insert($pData);
            $id = $this->getInsertId();
            foreach($id_tags as $i)
            {
                Query::insert(array('id_post'=>$id, 'id_category'=>$i))->into('post_category')->execute();
            }
            return $pData['permalink_post'];
        }

        public function generatePermalink()
        {
            $permalink = SimpleRandom::string(16);
            while($this->count(Query::condition()->andWhere('permalink_post', Query::EQUAL, $permalink)))
            {
                $permalink = SimpleRandom::string(16);
            }
            return $permalink;
        }

        public function retrieveDataFrom($pUrl)
        {
            $sc = new SimpleScraper($pUrl);

            $data = array(
                "title"=>$sc->getTitle(),
                "text"=>$sc->getDescription(),
                "images"=>$sc->getImages()
            );

            return $data;
        }

        public function getPostsByDay($pCat = null, $pDaysCount = 7, $pFirstDay = null)
        {
            if($pFirstDay == null)
                $pFirstDay = date('Y-m-d');

            $days = array();

            if(!is_null($pCat))
            {
                $this->addJoinOnSelect('post_category b', ' JOIN ', 'main_post.id_post = b.id_post');
                $this->addJoinOnSelect('main_category c', ' JOIN ', 'c.id_category = b.id_category');
            }

            for($i = 0; $i<$pDaysCount; $i++)
            {
                $ts = strtotime($pFirstDay) - ($i * 24 * 60 * 60);

                $cond = Query::condition()->andWhere('added_date_post', Query::LIKE, date('Y-m-d', $ts).'%')
                    ->andWhere('status_post', Query::EQUAL, 1)
                    ->order('added_date_post', 'DESC');

                if(!is_null($pCat))
                {
                    $cond->andWhere('c.permalink_category', Query::EQUAL, $pCat);
                }

                $date = date('l, dS F Y', $ts);
                $days[$date] = $this->all($cond, 'main_post.*');
            }

            return $days;
        }

        public function all($pCond = null, $pFields = "*")
        {
            $all = parent::all($pCond, $pFields);
            foreach($all as &$post)
            {
                $post['categories'] = Query::select('b.*', 'post_category a')
                                        ->join('main_category b', Query::JOIN_INNER, 'a.id_category=b.id_category')
                                        ->andWhere('a.id_post', Query::EQUAL, $post['id_post'])
                                        ->execute();
            }
            return $all;
        }


    }
}