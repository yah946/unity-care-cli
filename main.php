<?php
require_once "./src/connection/config.php";
//Regex
$fRx = '/^[a-zA-Z]{2,15}(\s[a-zA-Z]{2,15})?$/';
$lRx = '/[a-zA-Z]{2,15}/';
$gRx = '/male|female/';
$dRx = '/^(19|20)[0-9]{2}-(0?[1-9]|1[0-2])-(0?[1-9]|1[1-9]|2[1-9]|3[01])$/';
$tRx = '/^(\+212|0)[67]{1}[0-9]{8}$/';
$eRx = '/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+){0,15}@(gmail)\.(com)$/';
// NRue Quartier Ville
$aRx = '/^[0-9]{1,3}\s[a-zA-Z]{2,15}(?:\s[a-zA-Z]{2,15})?\s[a-zA-Z\']{2,15}$/u';
// Block A, B ...
$bRx = '/^(Block)[A-Z]{1}$/';
// End of My Zone
function search(){
    // Global variables:
    global $conn;
    global $choice;
    $find = false;
    $name = 'Unknown';
    $lname = 'Unknown';
    // Chose the id of patient:
    echo "Do you want to search by first name(fn) or last name(ln)?\n";
    $i=1;
    do{
        if($i==1){
            $multiChoice=readline('Your Answer: ');
        }else if($i>=2){
            $multiChoice=readline('Please Answer by <fn> or <ln>: ');
        }
        $i++;
    }while(!str_starts_with($multiChoice,'fn') && !str_starts_with($multiChoice,'ln'));
    $stm = $conn->prepare("select firstName,lastName from patient");
    $stm->execute();
    $Archive = $stm->fetchAll(PDO::FETCH_ASSOC);
    if($multiChoice==='fn'){
        $name = readline('Enter the Patient\'s First Name: ');
        for($i=0;$i<count($Archive);$i++){
            if($name==$Archive[$i]['firstName']){
                echo "First Name=$name: Find!\n";
                $find=true;
            }
        }
    }else{
        $lname = readline('Enter the Patient\'s Last Name: ');
        for($i=0;$i<count($Archive);$i++){
            if($lname==$Archive[$i]['lastName']){
                echo "Last Name=$lname: Find!\n";
                $find=true;
            }
        }
    }
    // Not Found
    if(!$find){
        echo "not found!\n";
    }else if($find){
        $stm = $conn->query("select * from patient where firstName=\"$name\" Or lastName=\"$lname\"");
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        //Header of table:
        echo "id" . " | ";
        echo 'First Name' ." | ";
        echo 'Last Name' ." | ";
        echo 'Gender' ." | ";
        echo 'Date Of Birth' ." | ";
        echo 'Phone Num' ." | ";
        echo 'Email' ." | ";
        echo 'Address' ."\n";
        for($i = 0 ; $i<$stm->rowCount();$i++){
            echo $result[$i]['id'] ." | ";
            echo $result[$i]['firstName'] ." | ";
            echo $result[$i]['lastName'] ." | ";
            echo $result[$i]['gender'] ." | ";
            echo $result[$i]['dateOfBirth'] ." | ";
            echo $result[$i]['phoneNum'] ." | ";
            echo $result[$i]['email'] ." | ";
            echo $result[$i]['address'] ."\n";
        }
    }
    $choice=6;
}
function update(){
    // Global variables:
    global $conn;
    global $choice;
    $find = false;
    // Chose the id of patient:
    $id = readline('Enter the Patient\'s Id You Want to Delete: ');
    // Vrfy the id (exist or not):
    $stm = $conn->prepare("select id from patient");
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    for($i=0;$i<count($result);$i++){
        if($id==$result[$i]['id']){
            echo("id=$id: Find!\n");
            $find=true;
        }
    }
    // Not Found
    if(!$find){
        echo "not found!\n";
    }else if($find){
        $f = readline('Enter the Patient\'s First Name: ');
        $l = readline('Enter the Patient\'s Last Name: ');
        $g = readline('Enter the Patient\'s Gender: ');
        $d = readline('Enter the Patient\'s Date Of Birth: ');
        $t = readline('Enter the Patient\'s Phone Number: ');
        $e = readline('Enter the Patient\'s Email: ');
        $a = readline('Enter the Patient\'s Address: ');
        $stm=$conn->prepare('update patient set firstName=?,lastName=?,gender=?,dateOfBirth=?,phoneNum=?,email=?,address=? where id=?');
        $stm->execute([$f,$l,$g,$d,$t,$e,$a,$id]);
        echo "+++++++++++++++++++++++++\n";
        echo "Data has Been changed\n";
    }
    $choice=6;
}
function delete(){
    // Global variables:
    global $conn;
    global $choice;
    $answere = '';
    // Chose the id of patient:
    $id = readline('Enter the Patient\'s Id You Want to Delete: ');
    // Vrfy the id (exist or not):
    $stm = $conn->prepare("select id from patient");
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
        $stm = $conn->prepare("delete from patient where id=:id");
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        echo "The Patient has been Deleted\n";
    }
    $choice=6;
}
function insert(){
    global $conn,$fRx,$lRx,$gRx,$dRx,$tRx,$eRx,$aRx,$choice;
    $i=1;
    do{
        if($i>1) echo"Fill in again invalid Input:\n";
        $f = readline('Enter the Patient\'s First Name: ');
        if(!preg_match($fRx,$f)) echo "Invalid first name! Ex: Achraf AbdAlhakim (Second opt)\n";
        $l = readline('Enter the Patient\'s Last Name: ');
        if(!preg_match($lRx,$l)) echo "Invalid last name! Ex: Saloua\n";
        $g = readline('Enter the Patient\'s Gender: ');
        if(!preg_match($gRx,$g)) echo "Invalid gender! Ex: male or female\n";
        $d = readline('Enter the Patient\'s Date Of Birth: ');
        if(!preg_match($dRx,$d)) echo "Invalid Date! Syntax: YYYY-MM-DD Ex: \n";
        $t = readline('Enter the Patient\'s Phone Number: ');
        if(!preg_match($tRx,$t)) echo "Invalid Number! Ex: +212 6000000000 or 0700000000\n";
        $e = readline('Enter the Patient\'s Email: ');
        if(!preg_match($eRx,$e)) echo "Invalid email! Ex: example@gmail.com\n";
        $a = readline('Enter the Patient\'s Address: ');
        if(!preg_match($aRx,$a)) echo "Invalid address! Syntax: <Number of Street> <Neighborhood> <City> Ex:20 Maghrib Arabi Qnitra\n";
        $i++;
    }while(!preg_match($fRx,$f) || !preg_match($lRx,$l) || !preg_match($gRx,$g) || !preg_match($dRx,$d) || !preg_match($tRx,$t)&&!preg_match($eRx,$e) || !preg_match($a,$aRx));
    $stm = $conn->prepare("insert into patient (firstName,lastName,gender,dateOfBirth,phoneNum,email,address) values (?,?,?,?,?,?,?)");
    $stm->execute([$f,$l,$g,/*$d,$t,$e,$a*/]);
    $choice=6;
}
function select(){
    global $conn;
    $stm = $conn->prepare("select * from patient");
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    //Header of table:
    echo "id" . " | ";
    echo 'First Name' ." | ";
    echo 'Last Name' ." | ";
    echo 'Gender' ." | ";
    echo 'Date Of Birth' ." | ";
    echo 'Phone Num' ." | ";
    echo 'Email' ." | ";
    echo 'Address' ."\n";
    for($i = 0 ; $i<$stm->rowCount();$i++){
        echo $result[$i]['id'] ." | ";
        echo $result[$i]['firstName'] ." | ";
        echo $result[$i]['lastName'] ." | ";
        echo $result[$i]['gender'] ." | ";
        echo $result[$i]['dateOfBirth'] ." | ";
        echo $result[$i]['phoneNum'] ." | ";
        echo $result[$i]['email'] ." | ";
        echo $result[$i]['address'] ."\n";
    }
}
do{
    $service = 0;
    $choice = 0;
    $choice_static = 0;
    echo "<=== Unity Care CLI ===>\n";
    echo "1. Gérer les patients\n";
    echo "2. Gérer les médecins\n";
    echo "3. Gérer les départements\n";
    echo "4. Statistiques\n";
    echo "5. Quitter\n";
    $service = readline('Choose a Service: ');
    switch ($service){
        case 1:
            echo "<=== Gestion des Patients ===>\n";
            echo "1. Lister tous les patients\n";
            echo "2. Rechercher un patient\n";
            echo "3. Ajouter un patient\n";
            echo "4. Modifier un patient\n";
            echo "5. Supprimer un patient\n";
            echo "6. Retour\n";
            $choice = (int) readline('Choose a Service: ');
            if($choice == 1)select();
            else if($choice == 2)search();
            else if($choice == 3)insert();
            else if($choice == 4)update();
            else if($choice == 5)delete();
        break;
        case 2:
            echo "<=== Gestion des Départements ===>\n";
            echo "1. Lister tous les départements\n";
            echo "2. Rechercher un département\n";
            echo "3. Ajouter un département\n";
            echo "4. Modifier un département\n";
            echo "5. Supprimer un département\n";
            echo "6. Retour\n";
            $choice = (int)readline('Choose a Service: ');
        break;
        case 3:
            echo "<=== Gestion des Médecins ===>\n";
            echo "1. Lister tous les médecins\n";
            echo "2. Rechercher un médecin\n";
            echo "3. Ajouter un médecin\n";
            echo "4. Modifier un médecin\n";
            echo "5. Supprimer un médecin\n";
            echo "6. Retour\n";
            $choice = readline('Choose a Service: ');
        break;
        case 4:
            echo "<=== Gestion des D ===>\n";
            echo "1. L’âge moyen des patients\n";
            echo "2. ancienneté moyenne des médecins\n";
            echo "3. département le plus peuplé\n";
            echo "4. la répartition des patients par département.\n";
            echo "5. Retour\n";
            $choice_static = readline('Choose a Service: ');
        break;
        case 5:
        break;
    }
}while($service>7 || $service<0  || $choice==6 || $choice_static==5);