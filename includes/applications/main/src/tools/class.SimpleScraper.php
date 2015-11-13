<?php
namespace app\main\src\tools
{

    use core\tools\Request;

    class SimpleScraper
    {
        private $content;

        private $title;
        private $description;
        private $images;
        private $base_url;
        private $url;

        public function __construct($pUrl)
        {
            $this->url = $pUrl;
            $this->content = Request::load($pUrl);
            $this->parse();
        }

        private function parse()
        {
            $this->parseBaseUrl();
            $this->parseTitle();
            $this->parseDescription();
            $this->extractImages();
        }

        private function parseBaseUrl()
        {

        }

        private function parseTitle()
        {

            if(preg_match('/<title[^>]*>([^<]+)/', $this->content, $matches))
            {
                $this->title = $matches[1];
            }
            else
            {
                if(preg_match('<h1[^>]*>(.*)<\/h1>', $this->content, $matches))
                {
                    $this->title = $matches[1];
                }
            }
        }

        private function parseDescription()
        {
            if(preg_match('/<meta\s*name="description"\s*content="([^"]+)/', $this->content, $matches))
            {
                $this->description = $matches[1];
            }
            else
            {
                $this->description = $this->title;
            }
        }

        private function extractImages()
        {
            $this->images = array();
            if(preg_match_all('/src=(\'|")([^\'"]+\.(jpg|png|jpeg|gif))(\'|")/', $this->content, $matches))
            {
                $this->images = array_unique($matches[2]);
            }

            if(preg_match('/<meta property="og:image" content="([^"]+)/', $this->content, $matches))
            {
                array_unshift($this->images, $matches[1]);
            }
        }

        public function getTitle()
        {
            return $this->title;
        }

        public function getDescription()
        {
            return $this->description;
        }

        public function getImages()
        {
            return $this->images;
        }
    }
}