<?php
require_once "./BaseModel.php";
class Person implements BaseModel{
    private $f_name='Unknown';
    private $l_name='Unknown';
    private $email='example@example.com';
    private $tel='+212 600000000';
    public function __construct($n,$ln,$e,$t){
       $this->f_name = $n;
       $this->l_name = $ln;
       $this->email = $e;
       $this->tel = $t;
    }
    public function delete(){
        throw new Exception("Not Implemented", 1);
        
    }
    public function update(){
        throw new Exception("Not Implemented", 1);
        
    }
    public function create(){
        throw new Exception("Not Implemented", 1);
        
    }
    public function select(){
        throw new Exception("Not Implemented", 1);
        
    }
    public function search(){
        throw new Exception("Not Implemented", 1);
        
    }
    public function vrfy(){
        throw new Exception("Not Implemented", 1);
        
    }
}