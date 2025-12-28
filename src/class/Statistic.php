<?php
require_once __DIR__ . "/../connection/config.php";
class Statistic {
    private $conn;
    public function averageAge(){
        global $conn,$choice;
        $SumPatientAge ="select Sum(DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(), dateOfBirth)), '%Y')) as sum from patient";
        $sum = $conn->query($SumPatientAge)->fetchAll(PDO::FETCH_ASSOC);
        $AllPatient = "select * from patient";
        $all = $conn->query($AllPatient);
        $result = $sum[0]['sum']/$all->rowCount();
        $choice = 6;
        echo (float) $result."\n";
    }
}