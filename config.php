<?php
declare(strict_types=1);

function dbConfig(): array
{
    return [
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'cs_map_veto',
        'user' => 'cs_map_veto',
        'pass' => 'DbAB75dRF2sjMkeF',
        'charset' => 'utf8mb4',
    ];
}

function getPdo(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $c = dbConfig();
    $dsn = "mysql:host={$c['host']};port={$c['port']};dbname={$c['name']};charset={$c['charset']}";

    $pdo = new PDO($dsn, $c['user'], $c['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}