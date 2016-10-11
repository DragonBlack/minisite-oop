<?php

class Component {
    public function __set($name, $value) {
        if(property_exists($this, $name)){
            $this->$name = $value;
        }
        else{
            $method = 'set'.$this->toUpperCamelCase($name);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
            else{
                throw new Exception('Property "'.$name.'" not found');
            }
        }
    }

    public function __get($name) {
        if(property_exists($this, $name)){
            return $this->$name;
        }

        $method = 'get'.$this->toUpperCamelCase($name);
        if(method_exists($this, $method)){
            return $this->$method();
        }

        throw new Exception('Property "'.$name.'" not found');
    }

    public function init(){
        
    }

    final protected function toUpperCamelCase($str){
        $parts = explode('_', $str);
        $parts = array_filter($parts);
        $parts = array_map('ucfirst', $parts);
        return implode('', $parts);
    }
}