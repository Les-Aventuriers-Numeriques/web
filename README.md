<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://team-lan.org/images/logo_full_dark.png">
    <img src="https://team-lan.org/images/logo_full_light.png">
  </picture>
</p>

# Les Aventuriers Numériques / Web

La plate-forme web de la team multigaming Les Aventuriers Numériques.

Il s'agit d'une réécriture de [deux](https://github.com/Les-Aventuriers-Numeriques/hub.team-lan.org) [projets](https://github.com/Les-Aventuriers-Numeriques/team-lan.org)
Python aux buts identiques, mais cette fois en utilisant [Laravel](https://laravel.com/). Elle fournit à la fois :

  - Le [site institutionnel](https://team-lan.org/). Il permet de mettre en avant la team sur le web
  - L'[intranet](https://hub.team-lan.org/). Il permet :
    - De nous aider à choisir les jeux principaux pour notre prochaine [LAN annuelle](https://team-lan.org/lan)
    - D'envoyer sur notre Discord des messages à propos de nos Chicken Dinner [PUBG](https://www.pubg.com/fr/main)
    - De nous aider à choisir le lieu de notre prochaine [LAN annuelle](https://team-lan.org/lan) (prochainement)

## Prérequis

  - Docker (+ WSL2 si développement sous Windows)
  - Un navigateur web moderne

## Installation

> [!NOTE]  
> Sous Windows, *toutes* les commandes doivent être exécutées à l'intérieur de WSL2.

  1. Cloner ce dépôt
  2. Copier le fichier des variables d'environnement par défaut : `cp .env.example .env`, et remplir les variables adéquates
  3. Définir la clef secrète applicative : `sail artisan key:generate`
  4. (Si besoin) Configurer Xdebug selon [ces instructions](https://laravel.com/docs/11.x/sail#debugging-with-xdebug)
  5. Installer les dépendances Composer en suivant [ces instructions](https://laravel.com/docs/11.x/sail#installing-composer-dependencies-for-existing-projects). Cela est à effectuer une seule fois à l'initialisation du projet
  6. Créer l'alias `sail` s'il n'existe pas déjà en suivant [ces instructions](https://laravel.com/docs/11.x/sail#configuring-a-shell-alias)
  7. Créer les entrées suivantes dans le fichier `hosts` sur l'hôte, qui redirigent toutes vers `127.0.0.1` : `team-lan.test`, `hub.team-lan.test`
  8. Lancer l'environnement de développement Docker : `sail up -d`. Cette commande est lente lors du premier lancement, ce qui est normal
  9. Créer les tables avec des données de test : `sail artisan migrate --seed`
  10. Lancer Vite : `sail npm run dev`

## Usage

Les commandes Laravel Sail doivent être utilisées afin d'interagir avec l'environnement de développement Laravel, voir
[sa documentation](https://laravel.com/docs/11.x/sail#executing-sail-commands).

Outre celles de Sail, voici des commandes permettant d'interagir avec des programmes qui ne sont pas officiellement
supportés par Sail :

  - Exécuter PHPStan : `sail bin phpstan analyse`.

Les mails sont configurés pour être envoyés à une instance locale [Mailpit](https://mailpit.axllent.org/) accessible
ici : http://localhost:8025.
