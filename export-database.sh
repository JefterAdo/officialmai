#!/bin/bash
# Script pour exporter la base de données MySQL depuis Docker

echo "==== Script d'export de base de données MySQL pour RHDP Officiel ===="

# Variables de configuration - correspond à ce qui est dans votre docker-compose.yml
DB_NAME="database"
DB_USER="data"
DB_PASSWORD="password"
DB_PORT="3307"
DB_HOST="127.0.0.1"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="./database_backups"
BACKUP_FILE="${BACKUP_DIR}/rhdp_backup_${TIMESTAMP}.sql"

echo "🔍 Vérification des conteneurs Docker en cours d'exécution..."
docker ps

# Vérifier si un conteneur MySQL spécifique pour RHDP est en cours d'exécution
DB_CONTAINER="rhdp_mysql_local"

if [ -z "$DB_CONTAINER" ]; then
    echo "⚠️ Aucun conteneur MySQL détecté en cours d'exécution."
    echo "📊 Tentative d'export direct depuis localhost:3307..."
    
    # Vérifier si mysqldump est installé
    if ! command -v mysqldump &> /dev/null; then
        echo "❌ La commande mysqldump n'est pas installée. Installation nécessaire."
        exit 1
    fi
    
    # Méthode alternative: utiliser mysqldump en local
    USE_DOCKER=false
else
    echo "✅ Conteneur MySQL trouvé: $DB_CONTAINER"
    USE_DOCKER=true
fi

# Créer le répertoire de sauvegarde s'il n'existe pas
mkdir -p "$BACKUP_DIR"

echo "🔄 Exportation de la base de données '$DB_NAME' vers '$BACKUP_FILE'..."

# Fonction pour vérifier le succès de l'exportation
check_export_success() {
    if [ $? -eq 0 ] && [ -s "$BACKUP_FILE" ]; then
        echo "✅ L'exportation de la base de données a réussi!"
        echo "📂 Fichier de sauvegarde: $BACKUP_FILE"
        echo "📊 Taille du fichier: $(du -h "$BACKUP_FILE" | cut -f1)"
        
        # Option pour compresser le fichier
        read -p "Voulez-vous compresser le fichier de sauvegarde? (o/n): " choice
        if [ "$choice" = "o" ] || [ "$choice" = "O" ]; then
            gzip "$BACKUP_FILE"
            echo "✅ Fichier compressé: ${BACKUP_FILE}.gz"
            BACKUP_FILE="${BACKUP_FILE}.gz"
        fi
        
        echo "
👍 Export réussi! Utilisez ce fichier pour importer la base de données sur Hostinger."
        return 0
    else
        echo "❌ L'exportation de la base de données a échoué."
        return 1
    fi
}

# Méthode d'export en fonction de la disponibilité de Docker
if [ "$USE_DOCKER" = true ]; then
    echo "📦 Utilisation de Docker pour l'export..."
    docker exec "$DB_CONTAINER" /usr/bin/mysqldump -u "$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" > "$BACKUP_FILE"
    check_export_success
    export_status=$?
else
    echo "📡 Connexion directe à MySQL sur le port $DB_PORT..."
    # Premier essai avec la configuration standard
    mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" > "$BACKUP_FILE" 2>/dev/null
    
    if [ $? -ne 0 ] || [ ! -s "$BACKUP_FILE" ]; then
        echo "⚠️ Première tentative échouée. Essai avec des options supplémentaires..."
        # Deuxième essai avec des options supplémentaires
        mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASSWORD" --protocol=TCP --column-statistics=0 "$DB_NAME" > "$BACKUP_FILE" 2>/dev/null
    fi
    
    check_export_success
    export_status=$?
    
    # Si l'export échoue toujours, proposer une méthode interactive
    if [ $export_status -ne 0 ]; then
        echo "
⚙️ Configuration interactive de l'export MySQL:"
        echo "Les tentatives automatiques ont échoué. Essayons avec vos paramètres."
        
        read -p "Hôte MySQL (défaut: $DB_HOST): " custom_host
        read -p "Port MySQL (défaut: $DB_PORT): " custom_port
        read -p "Nom d'utilisateur MySQL (défaut: $DB_USER): " custom_user
        read -p "Mot de passe MySQL (défaut: $DB_PASSWORD): " custom_password
        read -p "Nom de la base de données (défaut: $DB_NAME): " custom_db
        
        DB_HOST=${custom_host:-$DB_HOST}
        DB_PORT=${custom_port:-$DB_PORT}
        DB_USER=${custom_user:-$DB_USER}
        DB_PASSWORD=${custom_password:-$DB_PASSWORD}
        DB_NAME=${custom_db:-$DB_NAME}
        
        echo "🔄 Tentative avec les nouveaux paramètres..."
        mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASSWORD" --protocol=TCP "$DB_NAME" > "$BACKUP_FILE"
        check_export_success
    fi
fi

echo "==== Fin du script d'export ===="
