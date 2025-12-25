<?php
require_once '../class/Person.php';
class Doctor extends Person{
    private $specialization;
    public function __construct($n, $ln, $e, $t,$s){
        parent::__construct($n, $ln, $e, $t);
        $this->specialization=$s;
    }

}