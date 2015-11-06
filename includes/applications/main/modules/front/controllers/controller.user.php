<?php
namespace app\main\controllers\front
{

    use app\main\src\application\AchillesController;
    use core\application\Application;
    use core\application\Authentication\AuthenticationHandler;
    use core\application\Core;
    use core\application\Go;
    use core\application\Header;
    use core\system\File;
    use core\tools\form\Form;
    use core\utils\Logs;

    class user extends AchillesController
    {

        const DEFAULT_AVATAR = "files/uploads/avatars/default.jpg";

        public function __construct()
        {
            parent::__construct();
        }

        public function register()
        {
            $this->setTitle("Register");
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
            $this->setTitle("Sign in");

            //todo redirect if logged

            $authHandler = Application::getInstance()->authenticationHandler;

            $f = new Form('signin');

            if($f->isValid())
            {
                $data = $f->getValues();
                $authHandlerInst = call_user_func_array(array($authHandler, 'getInstance'), array());
                if($authHandlerInst->setUserSession($data["login_user"], $data["password_user"]))
                {
                    Go::to();
                }
                else
                {
                    Logs::write("Tentative de connexion au front <".$data["login_user"].":".$data["password_user"].">", Logs::WARNING);
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
            /** @var AuthenticationHandler $auth */
            $auth = Application::getInstance()->authenticationHandler;
            $auth::getInstance()->unsetUserSession();
            Go::to();
        }

        public function avatar()
        {
            $mime = File::getMimeType(self::DEFAULT_AVATAR);
            Header::content_type($mime);
            echo file_get_contents(self::DEFAULT_AVATAR);
            Core::endApplication();
        }
    }
}