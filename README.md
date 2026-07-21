# Pattatras

Application Symfony qui parcourt les nombres de **1 à 6457** et applique les règles suivantes :

| Condition | Affichage |
|-----------|-----------|
| Multiple de 3 et de 5 | `Pattatras` |
| Multiple de 3 | `Patte` |
| Multiple de 5 | `Tatras` |
| Sinon | le nombre lui-même |

## Prérequis

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) installé et démarré

Aucune installation de PHP n’est nécessaire sur la machine.

## Installation et lancement

Ouvrir un terminal dans le dossier du projet, puis exécuter :

```bash
docker compose up --build -d
```

Attendre que les conteneurs démarrent, puis ouvrir un navigateur à l’adresse :

**http://localhost:8080**

La page affiche l’ensemble des résultats.  
Un champ permet de saisir un nombre et d'afficher uniquement son résultat.  
Le bouton "Réinitialiser", permet d'afficher l'ensemble des résultats à nouveau.

### Arrêter l’application

```bash
docker compose down
```

## Commande console (optionnel)

Pour afficher les mêmes résultats dans le terminal :

```bash
docker compose exec app php bin/console app:pattatras
```

## Tests

```bash
docker compose exec app php bin/phpunit
```

## Structure utile

- `src/Service/PattatrasService.php` — règles métier
- `src/Controller/PattatrasController.php` — page web
- `src/Command/PattatrasCommand.php` — commande CLI
- `templates/pattatras/index.html.twig` — interface
- `public/styles.css` — styles (HTML/CSS, sans framework front)

## Stack

- PHP 8.4
- Symfony 7.4
- Twig
- Docker Compose (PHP-FPM + nginx)
