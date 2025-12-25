<?php
require_once '../class/Person.php';
require_once '../connection/config.php';
class Patient extends Person{
    private $gender='male';
    private $address='somewhere';
    public function __construct($n,$ln,$e,$t,$g,$a){
        parent::__construct($n,$ln,$e,$t);
        $this->gender = $g;
        $this->address = $a;
    }

}