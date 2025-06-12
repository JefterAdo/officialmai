#!/bin/bash

# Script de déploiement de la base de données RHDP
# Ce script automatise les étapes de déploiement de la base de données
# pour le projet RHDP

# Couleurs pour une meilleure lisibilité
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Fonction pour afficher les messages
print_message() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[ATTENTION]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERREUR]${NC} $1"
}

# Vérifier si le script est exécuté en tant que root
if [ "$(id -u)" -eq 0 ]; then
    print_warning "Ce script ne devrait pas être exécuté en tant que root. Continuez à vos risques."
    read -p "Voulez-vous continuer ? (o/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Oo]$ ]]; then
        exit 1
    fi
fi

# Vérifier si nous sommes dans le bon répertoire
if [ ! -f "artisan" ]; then
    print_error "Ce script doit être exécuté depuis le répertoire racine du projet Laravel."
    exit 1
fi

# Vérifier si le fichier .env existe
if [ ! -f ".env" ]; then
    print_error "Le fichier .env n'existe pas. Veuillez le créer avant de continuer."
    exit 1
fi

# Fonction pour créer une sauvegarde de la base de données
backup_database() {
    print_message "Création d'une sauvegarde de la base de données..."
    
    # Récupérer les informations de connexion depuis .env
    DB_CONNECTION=$(grep DB_CONNECTION .env | cut -d '=' -f2)
    DB_HOST=$(grep DB_HOST .env | cut -d '=' -f2)
    DB_PORT=$(grep DB_PORT .env | cut -d '=' -f2)
    DB_DATABASE=$(grep DB_DATABASE .env | cut -d '=' -f2)
    DB_USERNAME=$(grep DB_USERNAME .env | cut -d '=' -f2)
    DB_PASSWORD=$(grep DB_PASSWORD .env | cut -d '=' -f2)
    
    # Créer le répertoire de sauvegarde s'il n'existe pas
    mkdir -p backups
    
    # Nom du fichier de sauvegarde
    BACKUP_FILE="backups/rhdp_backup_$(date +%Y%m%d_%H%M%S).sql"
    
    # Créer la sauvegarde
    if [ "$DB_CONNECTION" = "mysql" ]; then
        mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" > "$BACKUP_FILE"
        if [ $? -eq 0 ]; then
            print_message "Sauvegarde créée avec succès: $BACKUP_FILE"
        else
            print_error "Échec de la création de la sauvegarde."
            exit 1
        fi
    else
        print_warning "Sauvegarde automatique non prise en charge pour $DB_CONNECTION."
    fi
}

# Fonction pour optimiser l'application
optimize_application() {
    print_message "Optimisation de l'application..."
    
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    print_message "Application optimisée avec succès."
}

# Fonction pour exécuter les migrations
run_migrations() {
    print_message "Exécution des migrations..."
    
    php artisan migrate --force
    
    if [ $? -eq 0 ]; then
        print_message "Migrations exécutées avec succès."
    else
        print_error "Échec de l'exécution des migrations."
        print_warning "Restauration de la sauvegarde recommandée."
        exit 1
    fi
}

# Fonction pour créer le lien symbolique de stockage
create_storage_link() {
    print_message "Création du lien symbolique pour le stockage..."
    
    php artisan storage:link
    
    if [ $? -eq 0 ]; then
        print_message "Lien symbolique créé avec succès."
    else
        print_warning "Échec de la création du lien symbolique. Il existe peut-être déjà."
    fi
}

# Menu principal
echo "===== Script de déploiement de la base de données RHDP ====="
echo "1. Créer une sauvegarde de la base de données"
echo "2. Exécuter les migrations"
echo "3. Optimiser l'application"
echo "4. Créer le lien symbolique de stockage"
echo "5. Exécuter toutes les étapes ci-dessus"
echo "0. Quitter"
echo "========================================================"

read -p "Choisissez une option: " option

case $option in
    1)
        backup_database
        ;;
    2)
        run_migrations
        ;;
    3)
        optimize_application
        ;;
    4)
        create_storage_link
        ;;
    5)
        backup_database
        run_migrations
        optimize_application
        create_storage_link
        print_message "Toutes les étapes ont été exécutées avec succès."
        ;;
    0)
        print_message "Au revoir!"
        exit 0
        ;;
    *)
        print_error "Option invalide."
        exit 1
        ;;
esac

exit 0
