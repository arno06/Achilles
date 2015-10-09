<?php
namespace app\main\controllers\front
{

    use app\main\src\application\AchillesController;
    use core\application\Application;
    use core\application\Go;
    use core\tools\form\Form;
    use core\utils\Logs;

    class user extends AchillesController
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function register()
        {
            //todo redirect if logged

            $f = new Form('register');

            if($f->isValid())
            {
                trace("I should really consider register this user");
            }
            else
            {
                trace("aaaah");
                trace($f->getError());
                $this->addContent('error', $f->getError());
            }

            $this->addForm('register', $f);
        }

        public function sign_in()
        {
            //todo redirect if logged

            $authHandler = Application::getInstance()->authenticationHandler;

            $f = new Form('signin');

            if($f->isValid())
            {
                $data = $f->getValues();
                $authHandlerInst = call_user_func_array(array($authHandler, 'getInstance'), array());
                if($authHandlerInst->setUserSession($data["login"], $data["mdp"]))
                {
                    Go::to();
                }
                else
                {
                    Logs::write("Tentative de connexion au front <".$data["login"].":".$data["mdp"].">", Logs::WARNING);
                    $this->addContent("error", "Le login ou le mot de passe est incorrect");
                }
            }
            else
            {
                trace("aaaah");
                trace($f->getError());
                $this->addContent('error', $f->getError());
            }

            $this->addForm('sign_in', $f);
        }

        public function sign_out()
        {
            //todo handle session then redirect
        }
    }
}