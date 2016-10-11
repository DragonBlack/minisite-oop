<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 10.10.2016
 * Time: 21:22
 */

namespace db\mysql;


class Query {

    protected $_select = [];
    protected $_from;
    protected $_where;
    protected $_params = [];
    protected $_sql;
    protected $_isInsert;

    public function __construct() {
        $this->_sql = $this->_from = $this->_where = '';
        $this->_select = $this->_params = [];
        $this->_isInsert = false;
    }

    public function select($columns){
        if(is_string($columns)){
            $columns = explode(',', $columns);
            $columns = array_map('trim', $columns);
        }

        $this->_select = $columns;
        return $this;
    }

    public function from($tableName){
        $this->_from = (string)$tableName;
        return $this;
    }

    public function where($where, $params=null){
        $this->_where = (string)$where;
        $this->_params = $params ? : [];
        return $this;
    }

    public function insert($table, array $data){
        $this->_isInsert = true;
        $this->_sql = "INSERT INTO `$table` ";
        $fields = array_keys($data);

        $this->_sql .= '('.implode(', ', $fields).') ';
        $this->_sql .= 'VALUES (:'.implode(', :', $fields).')';
        var_dump($this->_sql);
        $this->_params = $data;
        return $this->exec();
    }

    public function getSql(){
        if(!$this->_isInsert){
            $this->_sql = 'SELECT '.implode(', ', $this->_select). ' FROM '.$this->_from;
            if($this->_where){
                $this->_sql .= ' WHERE '.$this->_where;
            }
        }
        return $this->_sql;
    }

    public function getParams(){
        return $this->_params;
    }
    
    public function isInsert(){
        return $this->_isInsert;
    }

    public function one(){
        $res = $this->exec();
        return empty($res) ? false : $res[0];
    }

    private function exec(){
        return \App::get('db')->execute($this);
    }
}