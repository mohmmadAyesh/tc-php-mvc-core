<?php
namespace app\Core;
use app\Core\db\Database;
use app\Core\db\DBModel;
class Application{
    public string $layout='main';
    public Router $router;
    public Request $request;
    public static string $ROOT_DIR;
    public string $userClass;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public View $view;
    public static Application $app;
    public ?Controller $controller=null;
    public function __construct($rootPath,array $config){
        $this->userClass=$config['userClass'];
        self::$ROOT_DIR=$rootPath;
        self::$app=$this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session=new Session();
        $this->router = new Router($this->request,$this->response);
        $this->view=new View();
        $this->db=new Database($config['db']);
        $primaryValue=$this->session->get('user');
        if($primaryValue){
            $primaryKey=(new $this->userClass())->primaryKey();
            $this->user=(new $this->userClass())->findOne([$primaryKey=>$primaryValue]);
        }else{
            $this->user=null;
        }
    }
    public function run(){
        try{
        echo $this->router->resolve();
        }catch(\Exception $e){
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error',[
                'exception' => $e
            ]);
        }
    }
    public function getController(){
        return $this->controller;
    }
    public function setController($controller){
        $this->controller = $controller;
    }
    public function login(UserModel $user){
        $this->user=$user;
        $primaryKey=$user->primaryKey();
        $primaryValue=$user->{$primaryKey};
        $this->session->set('user',$primaryValue);
        return true;
    }
    public function logout(){
        $this->user=null;
        $this->session->remove('user');

    }
    public static function isGuest(){
        return !self::$app->user;
    }
}