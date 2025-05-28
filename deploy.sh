#!/bin/bash
# Script de déploiement automatisé pour RHDP Officiel
# À exécuter sur votre machine locale avant de pousser les changements vers le repository

echo "==== Script de déploiement pour RHDP Officiel ===="
echo "Préparation du déploiement sur Hostinger..."

# Vérifier si composer est installé
if ! command -v composer &> /dev/null; then
    echo "❌ Composer n'est pas installé. Veuillez l'installer et réessayer."
    exit 1
fi

# Vérifier si npm est installé
if ! command -v npm &> /dev/null; then
    echo "❌ npm n'est pas installé. Veuillez l'installer et réessayer."
    exit 1
fi

echo "✅ Vérification des outils réussie"

# Optimisation pour la production
echo "📦 Installation des dépendances composer..."
composer install --optimize-autoloader --no-dev

echo "📦 Installation des dépendances npm..."
npm ci

echo "🛠️ Compilation des assets pour la production..."
npm run production

echo "🔄 Optimisation du cache Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "📋 Vérification des migrations..."
php artisan migrate:status

# Créer le fichier .env.production si nécessaire
if [ ! -f .env.production ]; then
    echo "⚠️ Fichier .env.production non trouvé, création d'un modèle à partir de .env..."
    cp .env .env.production
    echo "⚙️ Veuillez modifier le fichier .env.production avec vos paramètres de production"
else
    echo "✅ Fichier .env.production trouvé"
fi

# Vérifier si git est installé et si c'est un repository
if command -v git &> /dev/null && [ -d .git ]; then
    echo "📝 Status git actuel:"
    git status
    
    read -p "Voulez-vous ajouter tous les fichiers et créer un commit? (o/n): " choice
    if [ "$choice" = "o" ] || [ "$choice" = "O" ]; then
        read -p "Message du commit: " commit_message
        git add .
        git commit -m "$commit_message"
        
        read -p "Voulez-vous pousser les changements vers le repository distant? (o/n): " push_choice
        if [ "$push_choice" = "o" ] || [ "$push_choice" = "O" ]; then
            git push
            echo "✅ Changements poussés avec succès"
        else
            echo "⏹️ Les changements n'ont pas été poussés"
        fi
    else
        echo "⏹️ Aucun commit créé"
    fi
else
    echo "⚠️ Git n'est pas configuré pour ce projet"
fi

echo "🎉 Préparation du déploiement terminée!"
echo "Suivez les instructions dans INSTRUCTIONS_DEPLOIEMENT.md pour finaliser le déploiement sur Hostinger."
