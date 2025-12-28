<?php
require_once __DIR__ . "/../class/Person.php";
class Patient extends Person{
    private $gender='male';
    private $address='somewhere';
    public function getTableName(): string
    {
        return "patient";
    }
}