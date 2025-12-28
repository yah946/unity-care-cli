<?php
class Doctor extends Person{
    private $specialization;
    public function getTableName(): string
    {
        return "doctor";
    }
    
}