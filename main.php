<?php

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