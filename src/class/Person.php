<?php
class Person{
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
}
$p = new Person('Youssef','Chakir','youssef@gamil.com','072332323');
