<?php
namespace app\main\models
{
    use core\application\BaseModel;
    use core\tools\Request;

    class ModelPost extends BaseModel
    {
        public function __construct()
        {
            parent::__construct("main_post", "id_post");
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

            return $data;
        }
    }
}