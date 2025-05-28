# Instructions de déploiement de la base de données RHDP

Ce document détaille les étapes nécessaires pour préparer et déployer la base de données du projet RHDP en production.

## Prérequis

- Accès au serveur de production
- Accès à la base de données MySQL sur le serveur de production
- Droits d'administration sur la base de données

## 1. Configuration de l'environnement de production

### 1.1 Créer le fichier .env de production

Créez un fichier `.env` sur le serveur de production avec les paramètres suivants (à adapter selon votre hébergement) :

```
APP_NAME="RHDP"
APP_ENV=production
APP_KEY=base64:UJKmHmsTeNkwZFVLNJonea6dpVPN2at1ZA6t3G5GZuM=
APP_DEBUG=false
APP_URL=https://rhdpofficiel.ci

APP_LOCALE=fr
APP_FALLBACK_LOCALE=fr

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=rhdp_production
DB_USERNAME=rhdp_user
DB_PASSWORD=votre_mot_de_passe_securise

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE=true

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database

CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=votre_serveur_smtp
MAIL_PORT=587
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="contact@rhdpofficiel.ci"
MAIL_FROM_NAME="RHDP"
```

### 1.2 Générer une nouvelle clé d'application (optionnel)

Si vous souhaitez générer une nouvelle clé d'application pour la production :

```bash
php artisan key:generate
```

## 2. Préparation de la base de données

### 2.1 Créer la base de données sur le serveur de production

Connectez-vous à MySQL sur le serveur de production :

```bash
mysql -u root -p
```

Créez la base de données et l'utilisateur :

```sql
CREATE DATABASE rhdp_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'rhdp_user'@'localhost' IDENTIFIED BY 'votre_mot_de_passe_securise';
GRANT ALL PRIVILEGES ON rhdp_production.* TO 'rhdp_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2.2 Exporter la base de données locale (optionnel)

Si vous souhaitez migrer les données existantes de votre environnement de développement :

```bash
# Dans votre environnement local
mysqldump -h 127.0.0.1 -P 3307 -u data -p database > rhdp_database_export.sql
```

### 2.3 Importer la base de données sur le serveur de production (optionnel)

```bash
# Sur le serveur de production
mysql -u rhdp_user -p rhdp_production < rhdp_database_export.sql
```

## 3. Migration et initialisation de la base de données

### 3.1 Exécuter les migrations

Sur le serveur de production, exécutez :

```bash
php artisan migrate --force
```

L'option `--force` permet d'exécuter les migrations en environnement de production.

### 3.2 Optimiser la configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3.3 Créer le lien symbolique pour le stockage

```bash
php artisan storage:link
```

## 4. Sécurisation de la base de données

### 4.1 Vérifier les permissions des utilisateurs

Assurez-vous que l'utilisateur de la base de données n'a que les permissions nécessaires :

```sql
REVOKE ALL PRIVILEGES ON *.* FROM 'rhdp_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, DROP ON rhdp_production.* TO 'rhdp_user'@'localhost';
FLUSH PRIVILEGES;
```

### 4.2 Configurer les sauvegardes automatiques

Mettez en place une sauvegarde quotidienne de la base de données :

```bash
# Exemple de script de sauvegarde à ajouter dans crontab
mysqldump -u rhdp_user -p'votre_mot_de_passe_securise' rhdp_production | gzip > /chemin/vers/sauvegardes/rhdp_backup_$(date +\%Y\%m\%d).sql.gz
```

Ajoutez ce script à crontab pour une exécution quotidienne :

```
0 2 * * * /chemin/vers/script_sauvegarde.sh
```

## 5. Vérification post-déploiement

### 5.1 Tester les fonctionnalités critiques

- Connexion à l'administration
- Création et modification de contenu
- Téléchargement de documents
- Envoi de formulaires

### 5.2 Vérifier les logs

Surveillez les logs pour détecter d'éventuelles erreurs :

```bash
tail -f /chemin/vers/storage/logs/laravel.log
```

## 6. Mise à jour future de la base de données

Pour les mises à jour futures, suivez ces étapes :

1. Sauvegardez la base de données de production
2. Exécutez les nouvelles migrations :

```bash
php artisan migrate --force
```

3. Vérifiez que tout fonctionne correctement
4. En cas de problème, restaurez la sauvegarde

## 7. Champs de sécurité ajoutés

La migration la plus récente (`2025_05_28_194500_add_security_fields_to_users_table`) a ajouté les champs suivants à la table `users` :

- `last_login_at` : Date et heure de la dernière connexion
- `last_login_ip` : Adresse IP de la dernière connexion
- `locked_until` : Date jusqu'à laquelle le compte est verrouillé
- `lock_reason` : Raison du verrouillage du compte
- `failed_login_attempts` : Nombre de tentatives de connexion échouées
- `password_changed_at` : Date et heure du dernier changement de mot de passe

Ces champs sont utilisés par les services de sécurité pour protéger l'application contre les attaques par force brute et autres menaces de sécurité.

## Notes importantes

- Assurez-vous que les paramètres de sécurité sont correctement configurés en production
- Utilisez HTTPS pour toutes les communications
- Configurez correctement les en-têtes de sécurité sur le serveur web
- Effectuez des sauvegardes régulières de la base de données
