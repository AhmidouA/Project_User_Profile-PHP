# Projet de Réinitialisation de Mot de Passe

Ce projet PHP permet aux utilisateurs de réinitialiser leur mot de passe en cas d'oubli. Il utilise PHPMailer pour envoyer des e-mails pour la confirmation et la réinitialisation du mot de passe.

## Table des matières

- [Fonctionnalités](#fonctionnalités)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Contribuer](#contribuer)
- [Licence](#licence)

## Fonctionnalités

- Envoi d'un e-mail de confirmation pour valider l'adresse e-mail.
- Réinitialisation du mot de passe via un lien envoyé par e-mail.

## Prérequis

- PHP (avec la bibliothèque PHPMailer)
- Serveur SMTP (utilisation de smtp.outlook.com dans cet exemple)
- Base de données MySQL (supposée dans le code, assurez-vous de configurer votre fichier `db.php` correctement)

## Installation

1. Clonez le référentiel.
2. Installez les dépendances avec `composer install`.
3. Configurez les variables d'environnement dans un fichier `.env`.
4. Assurez-vous que votre serveur web est configuré pour servir le dossier du projet.
5. Assurez-vous que la base de données est configurée avec le fichier `db.php`.

## Utilisation

1. Accédez à l'application via votre navigateur.
2. Cliquez sur "Forgot password" pour réinitialiser votre mot de passe.
3. Suivez les étapes envoyées par e-mail pour confirmer et réinitialiser votre mot de passe.

## Contribuer

Si vous souhaitez contribuer, veuillez ouvrir une demande d'extraction ou signaler des problèmes sur la page GitHub du projet.

## Licence

Ce projet est distribué sous la licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.
