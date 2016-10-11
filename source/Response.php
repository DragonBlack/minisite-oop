<?php
class Response extends Component {
    private $_statusCode;
    
    public function redirect($url, $code=301){
        header('Location: '.$url, true, $code);
        exit(0);
    }
}