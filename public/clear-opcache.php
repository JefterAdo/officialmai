<?php
// Vérifier si la fonction opcache_reset existe
if (function_exists('opcache_reset')) {
    // Réinitialiser le cache OPcache
    opcache_reset();
    echo "OPcache a été vidé avec succès.";
} else {
    echo "OPcache n'est pas activé ou la fonction opcache_reset n'est pas disponible.";
}
