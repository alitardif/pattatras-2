---
name: php-lint-psr
description: Vérifier et corriger le lint PHP/Symfony et les conventions PSR-1, PSR-4 et PSR-12 du projet Pattatras. À utiliser pour les demandes de lint, de formatage ou de conformité PSR du code PHP.
---

# Lint PHP et conventions PSR

## Objectif

Contrôler la syntaxe et les conventions du projet sans modifier son comportement métier. Expliquer en français les corrections et distinguer les contrôles exécutés des recommandations issues d'une lecture manuelle.

## Contexte du projet

- Application Symfony avec PHP 8.4 minimum ; vérifier les contraintes actuelles dans `composer.json`.
- Le parcours officiel utilise Docker Compose : ne pas demander d'installation locale de PHP.
- Autoload PSR-4 : `App\` correspond à `src`, et `App\Tests\` à `tests`.
- Respecter `.editorconfig` : UTF-8, fins de ligne LF, quatre espaces et saut de ligne final.
- Ne pas analyser ou reformater `vendor`, `var`, les métadonnées Git ni les fichiers générés, notamment `config\reference.php`.

## Procédure

1. Lire les instructions du projet, `composer.json`, `.editorconfig` et les éventuelles configurations PHP_CodeSniffer ou PHP-CS-Fixer.
2. Consulter `git status --short` et le diff pour préserver les modifications existantes. Limiter par défaut les corrections aux fichiers concernés par la demande.
3. Vérifier la disponibilité de Docker et du service `app` avec `docker compose ps`. Si nécessaire, proposer le démarrage documenté dans le README. Ne pas arrêter ou reconstruire un environnement existant sans nécessité.
4. Exécuter les contrôles adaptés au périmètre ci-dessous. Arrêter et signaler un échec au lieu de le masquer.
5. Si un outil de style est déjà installé, l'utiliser en mode vérification avant toute correction. Ne pas ajouter de dépendance ni de configuration de formatage sans demande ou accord explicite.
6. Après correction, relancer les contrôles concernés, puis examiner le diff pour vérifier l'absence de changement fonctionnel.

## Commandes de vérification

Lancer ces commandes depuis le dossier contenant `compose.yaml`. Les chemins passés à PHP dans le conteneur utilisent la syntaxe Linux.

### Syntaxe PHP

Pour un fichier modifié, par exemple :

```powershell
docker compose exec -T app php -l src/Service/PattatrasService.php
```

Répéter ce contrôle pour chaque fichier PHP concerné, y compris les nouveaux fichiers et les tests. `php -l` vérifie uniquement la syntaxe : ce n'est ni un contrôle PSR ni une analyse de types.

### Configuration Symfony

Exécuter les commandes correspondant aux fichiers ou services touchés :

```powershell
docker compose exec -T app php bin/console lint:yaml config --parse-tags
docker compose exec -T app php bin/console lint:twig templates
docker compose exec -T app php bin/console lint:container
```

### Composer et tests

Si l'autoload ou les dépendances sont concernés :

```powershell
docker compose exec -T app composer validate --strict
docker compose exec -T app composer check-platform-reqs
```

Exécuter les tests ciblés après les corrections ; pour un changement transversal :

```powershell
docker compose exec -T app php bin/phpunit
```

### Style automatisé, uniquement si disponible

Réutiliser en priorité les scripts Composer et la configuration existante. À défaut de configuration, si PHP_CodeSniffer est déjà installé, une vérification PSR-12 peut être lancée sur les répertoires applicatifs :

```powershell
docker compose exec -T app php vendor/bin/phpcs --standard=PSR12 src tests
```

Ne pas présenter cette commande comme disponible par défaut : PHP_CodeSniffer n'est pas déclaré dans le manifeste actuel. Ne pas utiliser un correcteur automatique sans vérifier les fichiers ciblés et les règles actives ; désactiver les règles risquées de PHP-CS-Fixer sauf demande explicite.

## Points à contrôler

### PSR-1

- Balises `<?php`, encodage UTF-8 sans BOM et absence de balise fermante dans les fichiers PHP purs.
- Classes et enums en PascalCase, méthodes en camelCase, constantes en majuscules avec underscores.
- Éviter les effets de bord dans les fichiers déclarant des classes.

### PSR-4

- Correspondance exacte entre namespace, nom de classe et emplacement, y compris la casse sous Linux.
- Exemple : `App\Enum\ResultType` doit se trouver dans `src\Enum\ResultType.php`.
- Respecter également le préfixe `App\Tests\` dans les tests.

### PSR-12

- Indentation de quatre espaces, sans tabulations ni espaces de fin de ligne.
- Organisation du fichier : déclaration stricte éventuelle, namespace, imports puis déclaration.
- Accolades de classes et méthodes à la ligne ; accolades des structures de contrôle sur la même ligne.
- Visibilité explicite des méthodes et propriétés ; espacement cohérent des opérateurs et signatures.
- Respecter les règles de longueur de ligne sans découper artificiellement les chaînes.
- Pour les constructions PHP récentes, suivre l'outil configuré compatible avec la version PHP du projet ; ne pas inventer de règle PSR.

### Conventions complémentaires PHP/Symfony

Ces pratiques ne sont pas des obligations PSR :

- Préserver et utiliser `declare(strict_types=1);` dans le code applicatif concerné lorsque cela est compatible avec les appels existants.
- Conserver les types explicites, les enums métier, l'injection de dépendances et la séparation contrôleur/service.
- Éviter les casts qui masquent des erreurs, les exceptions ignorées et les valeurs de repli silencieuses.
- Documenter les contrats et les décisions non évidentes ; ne pas ajouter de PHPDoc répétant les types natifs.
- Ne pas introduire de base de données, cache, authentification ou abstraction sans rapport avec le besoin.

## Restitution

Résumer les fichiers corrigés et la raison des changements. Signaler les violations restantes avec fichier et ligne.

Si Docker, PHP ou un outil de style est indisponible, indiquer clairement que le contrôle n'a pas été exécuté. Une lecture manuelle ou un lint syntaxique ne permet pas de déclarer une conformité PSR automatisée ni la réussite des tests.
