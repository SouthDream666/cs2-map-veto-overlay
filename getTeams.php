<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/config.php';

try {
    $pdo = getPdo();
    $stmt = $pdo->query('SELECT team1, team2, match_format FROM teams WHERE id = 1 LIMIT 1');
    $row = $stmt->fetch();

    if (!$row) {
        echo json_encode(['team1' => '', 'team2' => '', 'matchFormat' => 'BO3']);
        exit;
    }

    echo json_encode([
        'team1' => (string)$row['team1'],
        'team2' => (string)$row['team2'],
        'matchFormat' => (string)$row['match_format'],
    ]);
} catch (Throwable $e) {
    echo json_encode(['team1' => '', 'team2' => '', 'matchFormat' => 'BO3']);
}
