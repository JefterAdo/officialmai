# Instructions de déploiement - RHDP Officiel

Ce document contient les instructions pour déployer le site RHDP sur Hostinger en utilisant un repository Git.

## Prérequis

- Un compte Hostinger avec un plan PHP
- Accès SSH au serveur Hostinger
- Accès Git au repository du projet
- Un domaine configuré (rhdpofficiel.ci)

## 1. Préparation locale

### 1.1 Configuration de l'environnement de production

Créez un fichier `.env.production` à la racine du projet avec les variables d'environnement de production :

```
APP_NAME="RHDP Officiel"
APP_ENV=production
APP_KEY=base64:votre_clé_app
APP_DEBUG=false
APP_URL=https://rhdpofficiel.ci

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_db_production
DB_USERNAME=votre_user_db
DB_PASSWORD=votre_mot_de_passe_db

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contact@rhdpofficiel.ci
MAIL_PASSWORD=votre_mot_de_passe_mail
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contact@rhdpofficiel.ci
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### 1.2 Optimisation des fichiers

Exécutez les commandes suivantes pour optimiser l'application :

```bash
# Optimisation des autoloader
composer install --optimize-autoloader --no-dev

# Compilation des assets (si vous utilisez Laravel Mix)
npm ci
npm run production

# Mise en cache de la configuration
php artisan config:cache

# Mise en cache des routes
php artisan route:cache

# Mise en cache des vues
php artisan view:cache
```

### 1.3 Préparation des fichiers à ignorer

Assurez-vous que votre fichier `.gitignore` contient les éléments suivants :

```
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
docker-compose.override.yml
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/.idea
/.vscode
```

## 2. Configuration sur Hostinger

### 2.1 Création de la base de données

1. Connectez-vous à votre panneau de contrôle Hostinger
2. Accédez à la section "Bases de données MySQL"
3. Créez une nouvelle base de données et notez les informations suivantes :
   - Nom de la base de données
   - Nom d'utilisateur
   - Mot de passe
   - Hôte de la base de données (généralement localhost)

### 2.2 Configuration du domaine et du SSL

1. Dans le panneau de contrôle Hostinger, accédez à "Domaines" → "rhdpofficiel.ci"
2. Assurez-vous que les enregistrements DNS pointent vers votre hébergement Hostinger
3. Activez le SSL gratuit via Let's Encrypt pour votre domaine

### 2.3 Configuration de Git sur Hostinger

1. Connectez-vous à votre serveur Hostinger via SSH :
```bash
ssh u123456789@hostname.hostinger.com
```

2. Configurez Git sur le serveur :
```bash
git config --global user.name "Votre Nom"
git config --global user.email "votre@email.com"
```

3. Créez un dossier temporaire pour cloner le repository :
```bash
mkdir ~/git-tmp
cd ~/git-tmp
```

## 3. Déploiement via Git

### 3.1 Configuration du répertoire web

1. Connectez-vous à votre compte Hostinger via SSH
2. Naviguez vers le répertoire public_html :
```bash
cd ~/public_html
# Sauvegardez les fichiers existants si nécessaire
mkdir backup
mv * backup/ 2>/dev/null
```

### 3.2 Clonage du repository

```bash
git clone https://github.com/votre-username/rhdp-officiel.git .
```

### 3.3 Configuration de l'environnement sur le serveur

1. Créez le fichier .env sur le serveur :
```bash
cp .env.production .env
```

2. Générez une nouvelle clé d'application (si nécessaire) :
```bash
php artisan key:generate --force
```

3. Créez le lien symbolique pour le stockage :
```bash
php artisan storage:link
```

### 3.4 Installation des dépendances

```bash
composer install --optimize-autoloader --no-dev
```

### 3.5 Configuration des permissions

```bash
# Définir les bonnes permissions pour les dossiers de stockage
find storage bootstrap/cache -type d -exec chmod 755 {} \;
find storage bootstrap/cache -type f -exec chmod 644 {} \;
```

### 3.6 Migration de la base de données

```bash
php artisan migrate --force
# Exécuter les seeders si nécessaire
php artisan db:seed --force
```

## 4. Configuration du serveur web

### 4.1 Configuration du point d'entrée

Créez ou modifiez le fichier `.htaccess` à la racine du site :

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 4.2 Configuration PHP

Assurez-vous que les extensions PHP suivantes sont activées dans votre hébergement Hostinger :

- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- Exif
- GD (pour le traitement des images)

## 5. Mise à jour future du site

Pour les futures mises à jour, suivez ce processus :

```bash
# Connectez-vous au serveur via SSH
ssh u123456789@hostname.hostinger.com

# Allez dans le répertoire du site
cd ~/public_html

# Sauvegardez la base de données (optionnel mais recommandé)
mysqldump -u USER -p DATABASE_NAME > backup_$(date +%Y%m%d).sql

# Mettez le site en mode maintenance
php artisan down

# Récupérez les derniers changements du repository
git pull origin main

# Installez/mettez à jour les dépendances
composer install --optimize-autoloader --no-dev

# Migrez la base de données
php artisan migrate --force

# Effacez les caches
php artisan optimize:clear

# Recréez les caches pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Sortez du mode maintenance
php artisan up
```

## 6. Vérification post-déploiement

Après le déploiement, vérifiez les points suivants :

1. Le site est accessible via HTTPS (https://rhdpofficiel.ci)
2. Toutes les pages fonctionnent correctement
3. Les médias (images, vidéos, etc.) s'affichent correctement
4. Les formulaires fonctionnent (adhésion, contact, etc.)
5. L'administration Filament est accessible et fonctionnelle

## 7. Dépannage courant

### 7.1 Problèmes de permission

Si vous rencontrez des problèmes de permission, exécutez :

```bash
# Assurez-vous que le répertoire de stockage est accessible en écriture
chmod -R 755 storage bootstrap/cache
```

### 7.2 Erreurs 500

Vérifiez les logs dans `storage/logs/laravel.log` pour plus d'informations.

### 7.3 Problèmes avec les images/uploads

Vérifiez que le lien symbolique de stockage est correctement configuré :

```bash
php artisan storage:link
```

## Support

Pour toute question ou problème, contactez l'équipe de développement à [votre-email@example.com].
