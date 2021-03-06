<?php
date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai'   亚洲/上海

class sqlhelper{
    private $mysqli;
    private static $host="localhost";
    private static $user="root";
    private static $pwd="root";
    private static $db="softwork";
    public function  __construct()
    {
        $this->mysqli= new  mysqli(self::$host,self::$user,self::$pwd,self::$db);
        if($this->mysqli->connect_error){
            die("链接失败".$this->mysqli->connect_error);
        }
        $this->mysqli->query("set names utf8");
    }
    public function execute_dql($sql){
        $res=$this->mysqli->query($sql) ;
        return $res;
    }
    public function execute_dml($sql){
        $res=$this->mysqli->query($sql) ;
        if(!$res){
            return 0;
        }else{
            if($this->mysqli->affected_rows>0){
                return 1;
            }else{
                return 2;
            }
        }
    }
    public function close_sql(){
        $this->mysqli->close();
    }
}
?>