<?php
namespace app\main\models
{
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
        }

        public function oneByPermalink($pPermalink)
        {
            return $this->one(Query::condition()->andWhere("permalink_post", Query::EQUAL, $pPermalink));
        }

        public function submit($pData)
        {
            $pData['added_date_post'] = "NOW()";
            $pData['id_user'] = AuthenticationHandler::$data['id_user'];
            $pData['status_post'] = 1;
            $pData['permalink_post'] = $this->generatePermalink();
            $this->insert($pData);
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
            $data = array(
                "title"=>"",
                "text"=>"",
                "images"=>array()
            );

            $html = Request::load($pUrl);

            if(preg_match('/<title[^>]*>([^<]+)/', $html, $matches))
            {
                $data["title"] = $matches[1];
            }
            else
            {
                if(preg_match('<h1[^>]*>(.*)<\/h1>', $html, $matches))
                {
                    $data["title"] = $matches[1];
                }
            }

            if(preg_match('/<meta\s*name="description"\s*content="([^"]+)/', $html, $matches))
            {
                $data["text"] = $matches[1];
            }
            else
            {
                $data["text"] = $data["title"];
            }

            if(preg_match_all('/<img src=(\'|")([^\'"]+\.(jpg|png|jpeg|gif))(\'|")/', $html, $matches))
            {
                $data["images"] = array_unique($matches[2]);
            }

            if(preg_match('/<meta property="og:image" content="([^"]+)/', $html, $matches))
            {
                array_unshift($data["images"],$matches[1]);
            }

            return $data;
        }

        public function getPostsByDay($pCat = null, $pDaysCount = 7, $pFirstDay = null)
        {
            if($pFirstDay == null)
                $pFirstDay = date('Y-m-d');

            $cond = Query::condition()->andWhere('added_date_post', Query::LOWER_EQUAL, $pFirstDay.' 23:59:59')
                ->andWhere('added_date_post', Query::UPPER, 'DATE_SUB("'.$pFirstDay.'", INTERVAL '.$pDaysCount.' DAY)', false)
                ->andWhere('status_post', Query::EQUAL, 1);

            if(!is_null($pCat))
            {
                $this->addJoinOnSelect('post_category b', ' JOIN ', 'main_post.id_post = b.id_post');
                $this->addJoinOnSelect('main_category c', ' JOIN ', 'c.id_category = b.id_category');
                $cond->andWhere('c.permalink_category', Query::EQUAL, $pCat);
            }

            $posts = $this->all($cond, 'main_post.*');

            $days = array();
            foreach($posts as $p)
            {
                $date = explode(' ', $p['added_date_post']);
                $date = $date[0];
                $date = date('l, dS F Y', strtotime($date));
                if(!isset($days[$date]))
                    $days[$date] = array();
                array_unshift($days[$date], $p);
            }

            for($i = 0; $i<$pDaysCount; $i++)
            {
                $ts = strtotime($pFirstDay) - ($i * 24 * 60 * 60);
                $date = date('l, dS F Y', $ts);
                if(!isset($days[$date]))
                    $days[$date] = array();
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