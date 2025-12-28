<?php
require_once __DIR__ . "/./src/inheritance/Patient.php";
require_once __DIR__ . "/./src/inheritance/Doctor.php";
require_once __DIR__ . "/./src/inheritance/Deparetement.php";
require_once __DIR__ . "/./src/class/Statistic.php";
$s= new Statistic();
$p = new Patient();
$dr = new Doctor();
$d = new Deparetement();
//Regex
$regexPatient = [
    "firstName" => '/^[a-zA-Z]{2,15}(\s[a-zA-Z]{2,15})?$/',
    "lastName" => '/[a-zA-Z]{2,15}/',
    "gender" => '/male|female/',
    "dateOfBirth" => '/^(19|20)[0-9]{2}-(0?[1-9]|1[0-2])-(0?[1-9]|1[1-9]|2[1-9]|3[01])$/',
    "phoneNum" => '/^(\+212|0)[67]{1}[0-9]{8}$/',
    "email" => '/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+){0,15}@(gmail)\.(com)$/',
    "address" => '/^[0-9]{1,3}\s[a-zA-Z]{2,15}(?:\s[a-zA-Z]{2,15})?\s[a-zA-Z\']{2,15}$/u'
];
$regexDoctor = [
    "firstName" => '/^[a-zA-Z]{2,15}(\s[a-zA-Z]{2,15})?$/',
    "lastName" => '/[a-zA-Z]{2,15}/',
    "specialization" => '/[a-zA-Z]{2,15}/',
    "phoneNum" => '/^(\+212|0)[67]{1}[0-9]{8}$/',
    "email" => '/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+){0,15}@(gmail)\.(com)$/',
];
$regexDepartement = [
    "departementName" => '/[a-zA-Z]{2,15}/',
    "location" => '/^(Block)\s[A-Z]{1}$/'
];
do{
    $service = 0;
    $choice = 0;
    $choice_static = 0;
    echo "<=== Unity Care CLI ===>\n";
    echo "1. Gérer les patients\n";
    echo "2. Gérer les départements\n";
    echo "3. Gérer les médecins\n";
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
            if($choice == 1)$p->select();
            else if($choice == 2)$p->search();
            else if($choice == 3)$p->insert($regexPatient);
            else if($choice == 4)$p->update($regexPatient);
            else if($choice == 5)$p->delete();
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
            if($choice == 1)$d->select();
            else if($choice == 2)$d->search();
            else if($choice == 3)$d->insert($regexDepartement);
            else if($choice == 4)$d->update($regexDepartement);
            else if($choice == 5)$d->delete();
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
            if($choice == 1)$dr->select();
            else if($choice == 2)$dr->search();
            else if($choice == 3)$dr->insert($regexDoctor);
            else if($choice == 4)$dr->update($regexDoctor);
            else if($choice == 5)$dr->delete();
        break;
        case 4:
            echo "<=== Statistiques ===>\n";
            echo "1. L'âge moyen des patients\n";
            echo "3. département le plus peuplé\n";
            echo "4. la répartition des patients par département.\n";
            echo "5. Retour\n";
            $choice_static = readline('Choose a Service: ');
            if($choice_static == 1)$s->averageAge();
            else if($choice_static == 2)"not implemented yet";
            else if($choice_static == 3)"not implemented yet";
            else if($choice_static == 4)"not implemented yet";
        break;
        case 5:
        break;
    }
}while($service>7 || $service<0  || $choice==6 || $choice_static==5);