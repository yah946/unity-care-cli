<?php
require_once __DIR__ . "/../class/BaseModel.php";
class Deparetement extends BaseModel{
    private $name;
    private $location;
    public function getTableName(): string
    {
        return "departement";
    }
}