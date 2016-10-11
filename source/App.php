<?php

class App {
    
    private static $_instance;
    private $_components = [];
    private $_properties = [];

    public static function instance(){
        if(self::$_instance === null){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public static function get($name){
        return self::instance()->$name;
    }
    
    public function config(array $config){
        if(!empty($config['components'])){
            foreach($config['components'] as $component=>$conf){
                if(empty($conf['class'])){
                    throw new InvalidConfigException('Component\'s declaration must have "class" key');
                }

                if(isset($this->_components[$component])){
                    continue;
                }

                $this->_components[$component] = new $conf['class'];
                unset($conf['class']);
                $this->init($this->_components[$component], $conf);
                $this->_components[$component]->init();
            }
            unset($config['components']);
        }

        foreach($config as $prop=>$val){
            if(!isset($this->_properties[$prop])){
                $this->_properties[$prop] = $val;
            }
        }
    }

    private function init($obj, array $params = []){
        if(empty($params)){
            return;
        }

        foreach($params as $name=>$value){
            $obj->$name = $value;
        }
    }
    public function run(){
        ob_start();
        
        /** @var User $user */
        $user = App::get('user');
        /** @var Response $response */
        $response = App::get('response');
        /** @var Request $request */
        $request = App::get('request');
        if($request->getCurrentPage() != 'feedback'){
            if($user->isGuest() && $request->getCurrentPage() != 'login'){
                $response->redirect('/?page=login');
            }

            if(!$user->isGuest() && $request->getCurrentPage() == 'login'){
                $response->redirect('/?page=page1');
            }

            if(
                $request->post('login')
                && $request->post('passw')
                && App::get('user')->login($request->post('login'), $request->post('passw'))
            ){
                $response->redirect('/?page=page1');
            }
        }

                
        $content = App::get('viewer')->render($request->getCurrentPage());
        App::get('viewer')->renderLayout($content);
        ob_end_flush();
    }

    public function __get($name) {
        if(isset($this->_components[$name])){
            return $this->_components[$name];
        }

        if(isset($this->_properties[$name])){
            return $this->_properties[$name];
        }

        throw new Exception('Property "'.$name.'" not found');
    }

    private function __construct(){}
    private function __sleep(){}
    private function __wakeup(){}
    private function __clone(){}
}