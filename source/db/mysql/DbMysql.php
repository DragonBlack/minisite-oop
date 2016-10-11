<?php
namespace db\mysql;

class DbMysql extends \Component {
    protected $_dbuser;
    protected $_dbname;
    protected $_dbpassword;
    protected $_dbhost;
    private $_connection;

    public function setDbuser($value){
        $this->_setProperty('_dbuser', $value);
    }

    public function setDbpassword($value){
        $this->_setProperty('_dbpassword', $value);
    }

    public function setDbname($value){
        $this->_setProperty('_dbname', $value);
    }

    public function setDbhost($value){
        $this->_setProperty('_dbhost', $value);
    }

    public function getConnection(){
        if($this->_connection === null){
            $this->_connection = new \PDO("mysql:host={$this->_dbhost};dbname={$this->_dbname}", $this->_dbuser, $this->_dbpassword);
        }
        return $this->_connection;
    }

    public function execute(Query $query){
        $stmt = $this->getConnection()->prepare($query->getSql());
        foreach ($query->getParams() as $key => $value){
            $k = strpos($key, ':') !== 0 ? ":$key" : $key;
            $stmt->bindValue($k, $value);
        }

        $res = $stmt->execute();
        if($res === false){
            $err = $stmt->errorInfo();
            throw new DbMysqlException($err[2]);
        }
        if($query->isInsert()){
            return $res;
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function _setProperty($name, $value){
        if($this->$name === null){
            $this->$name = $value;
        }
        else{
            throw new \Exception('Property "'.$name.'" can\'t be redeclared');
        }
    }
}