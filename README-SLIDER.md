# Solution pour les problèmes d'images sur le site RHDP

## Problème

Le site rencontrait des problèmes avec l'affichage des images en raison de l'erreur "Too many levels of symbolic links" dans NGINX. Cette erreur se produisait car NGINX ne pouvait pas suivre correctement les liens symboliques entre `public/storage` et `storage/app/public`.

## Solution mise en place

### 1. Suppression du lien symbolique problématique

Le lien symbolique `public/storage` qui pointait vers `storage/app/public` a été supprimé et remplacé par une copie directe des fichiers.

### 2. Système de synchronisation automatique

Un système de synchronisation a été mis en place pour maintenir les fichiers à jour entre `storage/app/public` et `public/storage` :

- **Observateurs** : Des observateurs Laravel ont été créés pour les modèles Media et Slide, qui synchronisent automatiquement les fichiers lorsqu'ils sont créés, modifiés ou supprimés.
- **Script de synchronisation** : Un script `sync-storage.php` a été créé pour synchroniser manuellement tous les fichiers.

### 3. URLs directes

Tous les templates ont été mis à jour pour utiliser des URLs directes (`/storage/...`) au lieu de fonctions comme `asset('storage/...')` ou `Storage::url('public/...')`.

## Maintenance

### Synchronisation manuelle

Si vous constatez que certaines images ne s'affichent pas, vous pouvez exécuter le script de synchronisation :

```bash
php sync-storage.php
```

### Ajout de nouveaux types de médias

Si vous ajoutez de nouveaux types de médias au site, vous devrez peut-être créer des observateurs supplémentaires pour ces modèles.

## Recommandations pour NGINX

Pour une solution plus propre à long terme, vous pourriez configurer NGINX pour servir directement les fichiers de `storage/app/public` sans passer par un lien symbolique. Voici un exemple de configuration :

```nginx
server {
    # ... autres configurations ...

    # Servir les fichiers de storage directement
    location /storage {
        alias /home/zertos/htdocs/www.zertos.online/storage/app/public;
        try_files $uri =404;
    }

    # ... autres configurations ...
}
```

Cette configuration permettrait d'éviter complètement les problèmes de liens symboliques.