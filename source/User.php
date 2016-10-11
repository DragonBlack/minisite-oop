<?php

class User extends Component {

    protected $_tableName = 'user';

    private $login;
    private $password;
    private $css;
    private $id;

    public function __construct($params = []){
        $this->load($params);
    }

    public function login($login, $pass){
        $res = (new \db\mysql\Query())->select(['id', 'login', 'css'])
            ->from($this->_tableName)
            ->where('login = :login AND password = :password', [
                ':login' => $login,
                ':password' => $pass
            ])
            ->one();

        $this->load($res);

        if($res){
            $uid = uniqid('sefseds');
            App::get('session')->set('uid', $uid);
            App::get('session')->setCookie('uid', $uid);
            return true;
        }
        return false;
    }

    public function load($params){
        if(!$params){
            return;
        }

        foreach($params as $prop=>$val){
            if(property_exists($this, $prop)){
                $this->$prop = $val;
            }
        }
    }
    
    public function isGuest(){
        return empty($this->id);
    }
}