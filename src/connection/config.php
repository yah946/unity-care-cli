<?php
class Config{
    Private $servername = 'localhost';
    Private $username = 'root';
    Private $passwd = '';
    public $db_name = 'backoffice unity cc';
    public $table = 'patient';
    private $conn;
    public function __construct(){
        try{
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->db_name",$this->username,$this->passwd);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getConnection(){
        return $this->conn;
    }
}
$obj = new Config();
$conn = $obj->getConnection();

// $query="SELECT COLUMN_NAME
//         FROM INFORMATION_SCHEMA.COLUMNS
//         WHERE TABLE_SCHEMA = :dbName
//         AND TABLE_NAME = :tableName";
//         $stm= $conn->prepare("SELECT COLUMN_NAME
//         FROM INFORMATION_SCHEMA.COLUMNS
//         WHERE TABLE_SCHEMA = ?
//         AND TABLE_NAME = ?
//         ORDER BY ORDINAL_POSITION;");
//      $stm->bindParam(':dbName', $obj->db_name);
// $stm->bindParam(':tableName', $obj->table);
//         $stm->execute();
//         $result = $stm->fetchAll(PDO::FETCH_ASSOC);