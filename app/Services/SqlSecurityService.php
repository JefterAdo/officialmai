<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SqlSecurityService
{
    /**
     * Liste des mots-clés SQL potentiellement dangereux
     * 
     * @var array
     */
    protected static $sqlKeywords = [
        'SELECT', 'INSERT', 'UPDATE', 'DELETE', 'DROP', 'ALTER', 'TRUNCATE',
        'UNION', 'JOIN', 'FROM', 'WHERE', 'HAVING', 'GROUP BY', 'ORDER BY',
        'EXEC', 'EXECUTE', 'DECLARE', 'CAST', 'OR', 'AND', '--', '/*', '*/',
        'WAITFOR', 'DELAY', 'BENCHMARK', 'SLEEP', 'INFORMATION_SCHEMA',
        'TABLE_SCHEMA', 'LOAD_FILE', 'OUTFILE', 'DUMPFILE'
    ];

    /**
     * Vérifie si une chaîne contient des tentatives d'injection SQL
     *
     * @param string $input
     * @return bool
     */
    public static function containsSqlInjection(string $input): bool
    {
        // Normaliser l'entrée
        $normalizedInput = self::normalizeInput($input);
        
        // Vérifier les motifs d'injection SQL courants
        $patterns = [
            '/\b(union\s+all|union\s+select)\b/i',  // UNION SELECT/ALL
            '/\b(select\s+.*\s+from)\b/i',          // SELECT FROM
            '/\b(insert\s+into)\b/i',               // INSERT INTO
            '/\b(drop\s+table)\b/i',                // DROP TABLE
            '/\b(alter\s+table)\b/i',               // ALTER TABLE
            '/\b(delete\s+from)\b/i',               // DELETE FROM
            '/\b(update\s+.*\s+set)\b/i',           // UPDATE SET
            '/\b(exec\s+xp_|exec\s+sp_)\b/i',       // EXEC stored procedures
            '/;\s*(\w+\s*=|\w+\s*\()/i',            // Command chaining
            '/--.*$/m',                             // SQL comments
            '/\/\*.*\*\//Us',                       // Multi-line comments
            '/\bor\s+[\'"0-9=]/i',                  // OR-based injections
            '/\band\s+[\'"0-9=]/i',                 // AND-based injections
            '/\bwaitfor\s+delay\b/i',               // Time-based attacks
            '/\bbenchmark\s*\(/i',                  // MySQL benchmark
            '/\bsleep\s*\(/i',                      // MySQL sleep
            '/\bif\s*\(\s*[\w\s=\'"\(\)]+,\s*[\w\s]+,\s*[\w\s]+\)/i', // IF statements
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $normalizedInput)) {
                Log::warning('Tentative potentielle d\'injection SQL détectée', [
                    'input' => $input,
                    'pattern' => $pattern,
                    'ip' => request()->ip()
                ]);
                return true;
            }
        }
        
        // Vérifier les mots-clés SQL suspects
        // Nous vérifions uniquement les mots-clés complets pour éviter les faux positifs
        $words = preg_split('/\W+/', $normalizedInput);
        foreach ($words as $word) {
            $word = strtoupper($word);
            if (in_array($word, self::$sqlKeywords)) {
                // Vérifier le contexte pour éviter les faux positifs
                // Si le mot-clé est entouré de caractères non alphanumériques, c'est suspect
                $pattern = '/[^\w]' . preg_quote($word, '/') . '[^\w]/i';
                if (preg_match($pattern, $normalizedInput)) {
                    Log::warning('Mot-clé SQL suspect détecté', [
                        'input' => $input,
                        'keyword' => $word,
                        'ip' => request()->ip()
                    ]);
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Normalise l'entrée pour la détection d'injection SQL
     *
     * @param string $input
     * @return string
     */
    public static function normalizeInput(string $input): string
    {
        // Convertir en minuscules
        $input = strtolower($input);
        
        // Supprimer les espaces multiples
        $input = preg_replace('/\s+/', ' ', $input);
        
        // Normaliser les guillemets
        $input = str_replace(["'", '"', '`'], "'", $input);
        
        // Normaliser les commentaires
        $input = str_replace(['--', '#'], '--', $input);
        
        // Normaliser les caractères d'échappement
        $input = str_replace(['\\\\', '\\\'', '\\"'], '\\', $input);
        
        return $input;
    }
    
    /**
     * Sécurise une valeur pour une utilisation dans une requête SQL
     *
     * @param mixed $value
     * @return mixed
     */
    public static function sanitizeValue($value)
    {
        if (is_string($value)) {
            // Vérifier si la chaîne contient une tentative d'injection SQL
            if (self::containsSqlInjection($value)) {
                Log::error('Tentative d\'injection SQL bloquée', [
                    'value' => $value,
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'user_id' => auth()->id()
                ]);
                
                // Journaliser la tentative d'accès non autorisée
                SecurityService::logUnauthorizedAccess('sql_injection_attempt', null, request());
                
                // Retourner une valeur sécurisée
                return '';
            }
            
            // Échapper les caractères spéciaux
            return DB::connection()->getPdo()->quote($value);
        }
        
        return $value;
    }
    
    /**
     * Sécurise un nom de colonne pour une utilisation dans une requête SQL
     *
     * @param string $column
     * @return string
     */
    public static function sanitizeColumnName(string $column): string
    {
        // Vérifier si le nom de colonne contient des caractères non autorisés
        if (!preg_match('/^[a-zA-Z0-9_\.]+$/', $column)) {
            Log::warning('Tentative d\'utilisation d\'un nom de colonne non sécurisé', [
                'column' => $column,
                'ip' => request()->ip()
            ]);
            
            // Retourner un nom de colonne par défaut
            return 'id';
        }
        
        return $column;
    }
    
    /**
     * Sécurise un nom de table pour une utilisation dans une requête SQL
     *
     * @param string $table
     * @return string
     */
    public static function sanitizeTableName(string $table): string
    {
        // Vérifier si le nom de table contient des caractères non autorisés
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
            Log::warning('Tentative d\'utilisation d\'un nom de table non sécurisé', [
                'table' => $table,
                'ip' => request()->ip()
            ]);
            
            // Retourner un nom de table par défaut
            return 'users';
        }
        
        return $table;
    }
    
    /**
     * Sécurise une liste de valeurs pour une utilisation dans une clause IN
     *
     * @param array $values
     * @return array
     */
    public static function sanitizeInClause(array $values): array
    {
        $sanitizedValues = [];
        
        foreach ($values as $value) {
            if (is_string($value)) {
                // Vérifier si la chaîne contient une tentative d'injection SQL
                if (self::containsSqlInjection($value)) {
                    continue;
                }
                
                // Échapper les caractères spéciaux
                $sanitizedValues[] = DB::connection()->getPdo()->quote($value);
            } elseif (is_numeric($value)) {
                $sanitizedValues[] = $value;
            }
        }
        
        return $sanitizedValues;
    }
    
    /**
     * Sécurise un ordre de tri pour une utilisation dans une clause ORDER BY
     *
     * @param string $direction
     * @return string
     */
    public static function sanitizeSortDirection(string $direction): string
    {
        $direction = strtoupper($direction);
        
        if (!in_array($direction, ['ASC', 'DESC'])) {
            Log::warning('Tentative d\'utilisation d\'une direction de tri non sécurisée', [
                'direction' => $direction,
                'ip' => request()->ip()
            ]);
            
            // Retourner une direction par défaut
            return 'ASC';
        }
        
        return $direction;
    }
    
    /**
     * Crée une requête sécurisée avec des paramètres liés
     *
     * @param string $table
     * @param array $conditions
     * @return \Illuminate\Database\Query\Builder
     */
    public static function secureQuery(string $table, array $conditions = []): Builder
    {
        // Sécuriser le nom de la table
        $table = self::sanitizeTableName($table);
        
        // Créer la requête de base
        $query = DB::table($table);
        
        // Ajouter les conditions sécurisées
        foreach ($conditions as $column => $value) {
            $column = self::sanitizeColumnName($column);
            
            if (is_array($value)) {
                // Sécuriser les valeurs pour une clause IN
                $sanitizedValues = self::sanitizeInClause($value);
                $query->whereIn($column, $sanitizedValues);
            } else {
                // Utiliser des paramètres liés pour éviter les injections SQL
                $query->where($column, '=', $value);
            }
        }
        
        return $query;
    }
}
