# Pattatras

Pattatras est une petite application web Symfony qui affiche les résultats d’un parcours de **1 à 6457** :

| Règle | Résultat |
|---|---|
| Multiple de 3 et de 5 | `Pattatras` |
| Multiple de 3 | `Patte` |
| Multiple de 5 | `Tatras` |
| Sinon | Le nombre lui-même |

## Démarrer l’application

Vous n’avez pas besoin d’installer PHP, Composer ou Symfony sur votre ordinateur. Docker Desktop lance l’application dans des conteneurs.

### 1. Installer et démarrer Docker Desktop

Installez [Docker Desktop](https://www.docker.com/products/docker-desktop/) et démarrez-le. Attendez que Docker indique que son moteur est actif.

### 2. Récupérer le projet

Sur la page GitHub du projet, cliquez sur **Code**, puis **Download ZIP**. Décompressez l’archive. Vous pouvez aussi récupérer le projet avec Git si vous l’utilisez.

Ouvrez PowerShell (Windows) ou un terminal (macOS/Linux) dans le dossier `pattatras`, celui qui contient le fichier `compose.yaml`.

### 3. Installer et lancer

Exécutez cette commande :

```bash
docker compose up --build -d
```

Au premier lancement, Docker télécharge les composants nécessaires et construit l’application ; cela peut prendre quelques minutes. Une fois la commande terminée, ouvrez **http://localhost:8080** dans votre navigateur.

La page affiche tous les résultats. Saisissez un nombre compris entre 1 et 6457 pour afficher son résultat, ou cliquez sur **Réinitialiser** pour retrouver la liste complète.

### 4. Arrêter l’application

Dans le même dossier, exécutez :

```bash
docker compose down
```

Cette commande arrête et supprime les conteneurs ; elle ne supprime pas les fichiers du projet.

## En cas de problème

- Si `docker` n’est pas reconnu, démarrez Docker Desktop puis ouvrez un nouveau terminal.
- Si le navigateur n’arrive pas à joindre l’application, vérifiez que Docker Desktop est actif et que les conteneurs sont démarrés avec `docker compose ps`.
- Si le port 8080 est déjà utilisé, modifiez la ligne `8080:80` dans `compose.yaml` en `8081:80`, relancez `docker compose up --build -d`, puis ouvrez **http://localhost:8081**.
- Pour voir les messages de démarrage, exécutez `docker compose logs -f app nginx`. Faites `Ctrl+C` pour quitter l’affichage des journaux ; cela ne stoppe pas l’application.

## Commandes facultatives

Afficher les résultats dans le terminal :

```bash
docker compose exec app php bin/console app:pattatras
```

Lancer les tests :

```bash
docker compose exec app php bin/phpunit
```

## Où trouver les éléments principaux ?

- `src/Service/PattatrasService.php` — règles de transformation des nombres
- `src/Controller/PattatrasController.php` — page web et filtrage
- `src/Command/PattatrasCommand.php` — commande console
- `templates/pattatras/index.html.twig` — contenu de la page
- `public/styles.css` — mise en forme de la page

## Technologies

PHP 8.4, Symfony 7.4, Twig, Docker Compose, PHP-FPM et Nginx.
