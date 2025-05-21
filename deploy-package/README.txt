# Instructions de déploiement pour la solution d'images

Ce package contient tous les fichiers nécessaires pour résoudre définitivement les problèmes d'images sur le site RHDP.

## Contenu du package
- `fix-all-images.php` : Script principal qui corrige la structure des dossiers et met en place la solution
- `sync-storage.php` : Script de synchronisation des fichiers entre storage/app/public et public/storage
- `deploy-image-fix.php` : Script de déploiement automatisé
- `README-SLIDER.md` : Documentation détaillée de la solution
- `app/Observers/MediaObserver.php` : Observateur pour les médias
- `app/Observers/SlideObserver.php` : Observateur pour les slides

## Instructions de déploiement

1. Transférez tous les fichiers de ce package vers votre serveur de production en conservant la même structure de dossiers.

2. Connectez-vous à votre serveur de production via SSH ou tout autre moyen d'accès.

3. Exécutez le script de déploiement :
   ```bash
   cd /home/zertos/htdocs/www.zertos.online
   php fix-all-images.php
   ```

4. Vérifiez que les images s'affichent correctement sur votre site.

5. Configurez une tâche cron pour la synchronisation régulière des fichiers :
   ```
   */15 * * * * php /home/zertos/htdocs/www.zertos.online/sync-storage.php >> /home/zertos/htdocs/www.zertos.online/storage/logs/sync-storage.log 2>&1
   ```

## Vérification après déploiement

Après avoir exécuté le script, vérifiez que :
- Les images du slider s'affichent correctement
- Les images des actualités s'affichent correctement
- Les images dans l'interface d'administration s'affichent correctement

Si vous rencontrez des problèmes, consultez le fichier README-SLIDER.md pour plus d'informations.
