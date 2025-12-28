<?php
require_once __DIR__ . "/../connection/config.php";
abstract class BaseModel{
    protected $conn;
    protected $table;
    public function __construct() {
        $this->table = $this->getTableName();
    }
    abstract public function getTableName():string;
    public function select(){
        global $conn,$choice;
        $stm = $conn->prepare("select * from $this->table");
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        //Header of table:
        $stmt= $conn->prepare("SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ?
        AND TABLE_NAME = ?
        ORDER BY ORDINAL_POSITION;");
        $stmt->execute(['backoffice unity cc',$this->table]);
        $headers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //header
        for($i=0;$i<count($headers);$i++){
            echo $headers[$i]['COLUMN_NAME'] . " | ";
        }
        echo "\n";
        //body
        for($i=0;$i<count($result);$i++){
            for($j=0;$j<count($headers);$j++){
                echo $result[$i][$headers[$j]['COLUMN_NAME']] . " | ";
            }
            echo "\n";
        }
        $choice=6;
    }
    public function delete(){
        global $conn,$choice;
        $answere = '';
        // Chose the id of patient/doctor/deparetement:
        $id = readline("Enter the $this->table\'s Id You Want to Delete: ");
        // Vrfy the id (exist or not):
        $stm = $conn->prepare("select id from $this->table");
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        for($i=0;$i<count($result);$i++){
            if($id==$result[$i]['id']){
                $answere = readline("Do you confirm this operation? (Y/N)");
            }
        }
        // Not Found
        if(!$answere){
            echo "not found!\n";
        }
        // Remove The Patient Or Cancel the operation
        else if($answere==='y' || $answere==='Y'){
            $stm = $conn->prepare("delete from $this->table where id=:id");
            $stm->bindParam(':id',$id,PDO::PARAM_INT);
            $stm->execute();
            echo "The $this->table has been Deleted\n";
        }
        $choice=6;
    }
    public function search(){
        global $conn,$choice;
        $find = false;
        $search = 'Unknown';
        $search2 = 'Unknown';
        // Search by:
        $stmt= $conn->prepare("SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ?
        AND TABLE_NAME = ?
        ORDER BY ORDINAL_POSITION;");
        $stmt->execute(['backoffice unity cc',$this->table]);
        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Chose the id of patient:
        echo "Do you want to search by ". $options[1]['COLUMN_NAME'] . "(1) or ". $options[2]['COLUMN_NAME'] ."(2)?\n";
        // vrfy user enter 1 or 2:
        $i=1;
        do{
            if($i==1){
                $multiChoice=readline('Your Answer: ');
            }else if($i>=2){
                $multiChoice=readline('Please Answer by <1> or <2>: ');
            }
            $i++;
        }while($multiChoice!=1 &&  $multiChoice!=2);
        $opt1 = $options[1]['COLUMN_NAME'];
        $opt2 = $options[2]['COLUMN_NAME'];
        $stm = $conn->prepare("select $opt1, $opt2 from $this->table");
        $stm->execute();
        $Archive = $stm->fetchAll(PDO::FETCH_ASSOC);
        if($multiChoice==1){
        $search = readline("Enter the $opt1: ");
        for($i=0;$i<count($Archive);$i++){
            if($search==$Archive[$i][$opt1]){
                echo "The Pattern=$search: Find!\n";
                $find=true;
            }
        }
        }else{
            $search2 = readline("Enter the $opt2: ");
            for($i=0;$i<count($Archive);$i++){
                if($search2==$Archive[$i][$opt2]){
                    echo "The Pattern=$search2: Find!\n";
                    $find=true;
                }
            }
        }
        // Not Found
        if(!$find){
            echo "not found!\n";
        }else if($find){
            $stm = $conn->query("select * from $this->table where $opt1=\"$search\" Or $opt2=\"$search2\"");
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            //header
            for($i=0;$i<count($options);$i++){
                echo $options[$i]['COLUMN_NAME'] . " | ";
            }
            echo "\n";
            //body
            for($i=0;$i<count($result);$i++){
                for($j=0;$j<count($options);$j++){
                    echo $result[$i][$options[$j]['COLUMN_NAME']] . " | ";
                }
                echo "\n";
            }
        }
        $choice=6;
    }
    public function insert($regex){
        global $conn,$choice;
        $isvalid = true;
        $placeholders = '';
        $arr=[];
        $keys = array_keys($regex);
        $values = array_values($regex);
        //Inputs of table:
        for($e=0 ; $e<count($keys);$e++){
            $arr[$e]=readline("Enter the $this->table ".$keys[$e].": " );
            if(!preg_match($values[$e],$arr[$e])) $isvalid=false;
            $placeholders .= "?, ";
        }
        
        $columns = implode(", ", $keys);
        $placeholders = rtrim($placeholders, ", ");
        if(!$isvalid)echo"Fill in again invalid Input:\n";
        else{
            $stm = $conn->prepare("insert into $this->table ($columns) values ($placeholders)");
            $stm->execute($arr);
            echo "++++++++++++++++++++++++++\n";
            echo "$this->table has been added\n";
        }
        $choice=6;
    }
    public function update($regex){
        global $conn,$choice;
        $isvalid = true;
        $find = false;
        $arr=[];
        $keys = array_keys($regex);
        $values = array_values($regex);
        // Chose the id of patient:
        $id = readline("Enter the $this->table's Id You Want to Update: ");
        // Vrfy the id (exist or not):
        $stm = $conn->prepare("select id from $this->table");
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        for($i=0;$i<count($result);$i++){
            if($id==$result[$i]['id']){
                echo "id=$id: Find!\n";
                $find=true;
            }
        }
        // Not Found
        if(!$find){
            echo "not found!\n";
        }else if($find){
            //Inputs of table:
            for($e=0 ; $e<count($keys);$e++){
                $arr[$e]=readline("Enter the $this->table ".$keys[$e].": " );
                if(!preg_match($values[$e],$arr[$e])) $isvalid=false;
            }
        }
        $columns = implode("=?, ", $keys)."=? ";
        echo $columns."<br>";
        print_r($arr);
        if(!$isvalid)echo"Fill in again invalid Input:\n";
        else{
            $stm = $conn->prepare("Update $this->table set $columns where=$id");
            $stm->execute($arr);
            echo "++++++++++++++++++++++++++\n";
            echo "$this->table has been changed\n";
        }
        $choice=6;
    }

}