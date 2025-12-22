# Unity Care CLI

Unity Care CLI est la version console orientée objet du système **Unity Care Clinic**. Cette application PHP 8 permet de gérer rapidement les patients, médecins et départements via une interface en ligne de commande (CLI), tout en offrant des statistiques et une navigation intuitive.

---

## Table des matières

* [Objectifs](#objectifs)
* [Fonctionnalités](#fonctionnalités)
* [Architecture](#architecture)
* [Installation](#installation)
* [Utilisation](#utilisation)
* [Statistiques](#statistiques)
* [Validation des données](#validation-des-données)
* [User Stories](#user-stories)

---

## Objectifs

* Refactoriser la logique métier en architecture orientée objet PHP 8
* Structurer le projet en classes métiers avec encapsulation, héritage et interfaces
* Implémenter une couche d'accès aux données via MySQLi en approche OOP
* Créer une interface console interactive pour les opérations CRUD
* Produire des statistiques via des méthodes statiques

---

## Fonctionnalités

### Classes principales

* **Personne** (classe mère)

  * Enfants : `Patient`, `Doctor`
* **Patient** (hérite de `Personne`)
* **Doctor** (hérite de `User`)
* **Department**

Chaque classe contient :

* Propriétés privées (encapsulation)
* Getters et setters avec validation via `Validator`
* Méthode `__toString()` pour au moins une classe
* Méthodes utilitaires (ex. `getFullName()`)

### Validator

Classe statique pour la validation et la sanitation des données :

```php
Validator::isValidEmail(string $email): bool
Validator::isValidPhone(string $phone): bool
Validator::isValidDate(string $date): bool
Validator::isNotEmpty(string $input): bool
Validator::sanitize(string $input): string
```

### Menu console interactif

Menu principal :

```
=== Unity Care CLI ===
1. Gérer les patients
2. Gérer les médecins
3. Gérer les départements
4. Statistiques
5. Quitter
```

Exemple sous-menu Patients :

```
=== Gestion des Patients ===
1. Lister tous les patients
2. Rechercher un patient
3. Ajouter un patient
4. Modifier un patient
5. Supprimer un patient
6. Retour
```

Toutes les entités disposent des opérations CRUD.

### Statistiques

Méthodes statiques fournissant des statistiques clés :

* `Patient::calculateAverageAge(): float`
* `Doctor::calculateAverageYearsOfService(): float`
* `Department::getMostPopulated(): Department`
* `Patient::countByDepartment(): array`

Affichage formaté via tableaux ASCII.

### Affichage ASCII

Classe utilitaire `ConsoleTable` pour afficher les données :

```
+----+------------+-----------+------------+
| ID | Prénom     | Nom       | Département|
+----+------------+-----------+------------+
| 1  | Mohammed   | Alami     | Cardiologie|
| 2  | Fatima     | Bennis    | Pédiatrie  |
+----+------------+-----------+------------+
```

---

## Architecture

* Approche orientée objet
* Encapsulation, héritage, interfaces
* Couche d'accès aux données via MySQLi OOP
* Méthodes statiques pour les statistiques
* Classes métiers séparées pour faciliter la maintenance et l'extensibilité

---

## Installation

1. Cloner le projet :

```bash
git clone <URL_DU_PROJET>
```

2. Configurer la base de données MySQL et mettre à jour le fichier de configuration (`config.php`) avec vos identifiants.

3. Exécuter l’application :

```bash
php main.php
```

---

## Utilisation

* Naviguer via le menu principal en entrant le numéro correspondant à l'action désirée
* Chaque sous-menu propose les opérations CRUD adaptées à l'entité sélectionnée
* Les messages d'erreur sont clairs et informatifs grâce à la validation intégrée

---

## Validation des données

La classe `Validator` assure que toutes les saisies respectent les règles :

* Email valide
* Numéro de téléphone correct
* Date valide
* Champs non vides
* Sanitation pour éviter les injections