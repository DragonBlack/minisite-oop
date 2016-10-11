<?php

class Viewer extends Component {
    public $layout;
    public $viewPath;
    private $_layoutPath;
    private $_viewPath;
    
    public function init() {
        parent::init();
        $view = trim($this->viewPath, '/');
        $this->_viewPath = ROOT.DS.$view.DS;

        $layout = trim($this->layout, '/');
        $this->_layoutPath = $this->_viewPath.$layout.'.php';
    }

    public function render($view, $params=[]){
        extract($params);
        $file = $this->_viewPath.strtolower($view).'.php';
        ob_start();
        if(is_file($file)){
            include $file;
        }
        else{
            include $this->_viewPath.'404.php';
        }
        return ob_get_clean();
    }

    public function renderLayout($content){
        include $this->_layoutPath;
    }
}