<?php

class Session extends Component {
    public function __construct() {
        session_start();
    }

    public function set($key, $val){
        $_SESSION[$key] = $val;
    }

    public function get($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function setCookie($name, $value, $duration=null){
        setcookie($name, $value, $duration ? time()+(int)$duration : null);
    }

    public function getCookie($name){
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    public function deleteCookie($name){
        setcookie($name);
    }
}