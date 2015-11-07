<?php
namespace app\main\controllers\front
{

    use app\main\models\ModelPost;
    use app\main\src\application\AchillesController;
    use core\application\Application;
    use core\application\Authentication\AuthenticationHandler;
    use core\application\Autoload;
    use core\application\Core;
    use core\application\Go;
    use core\application\Header;
    use core\data\SimpleJSON;
    use core\tools\form\Form;

    class post extends AchillesController
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function submit()
        {
            Autoload::addComponent("Achilles.submit");
            $this->setTitle("Submit a link");
            /** @var AuthenticationHandler $auth */
            $auth = Application::getInstance()->authenticationHandler;
            if(!$auth::is(AuthenticationHandler::USER))
            {
                Go::to404();
            }

            $m = new ModelPost();

            $form = new Form("post_submit");
            if($form->isValid())
            {
                $v = $form->getValues();
                $insertedPermalink = $m->submit($v);
                Header::location('post/'.$insertedPermalink);
            }
            else
            {
                $this->addContent("error", $form->getError());
            }

            $this->addForm("submit", $form);
        }

        public function view()
        {
            if(!Core::checkRequiredGetVars("permalink"))
                Go::to404();

            $m = new ModelPost();
            $post = $m->oneByPermalink($_GET["permalink"]);

            $this->setTitle($post['title_post']);

            $this->addContent("post", $post);
        }

        public function scrap()
        {
            if(!isset($_POST) || !isset($_POST["url"]))
            {
                Core::performResponse(SimpleJSON::encode(array("error"=>"Url missing.")), "json");
            }

            $return = array("request"=>array("post"=>$_POST));

            $url = $_POST["url"];

            $m = new ModelPost();

            try
            {
                $return["data"] = $m->retrieveDataFrom($url);
            }
            catch(\Exception $e)
            {
                Core::performResponse(SimpleJSON::encode(array("error"=>"Unable to retrieve infos.", "details"=>$e->getMessage())), "json");
            }

            Core::performResponse(SimpleJSON::encode($return), "json");
        }

        public function out()
        {
            if(!Core::checkRequiredGetVars("permalink"))
                Go::to404();
        }
    }
}