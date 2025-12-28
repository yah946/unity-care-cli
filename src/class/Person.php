<?php
require_once __DIR__ . "/./BaseModel.php";
class Person extends BaseModel{
    protected $f_name='Unknown';
    protected $l_name='Unknown';
    protected $email='example@example.com';
    protected $tel='+212 600000000';
    public function __construct(){
        parent::__construct();
    }
    public function getTableName(): string{
        throw new Exception("Not Implemented", 1);
    }
}