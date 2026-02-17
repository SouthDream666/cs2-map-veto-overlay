<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['team1']) || !isset($data['team2'])) {
    echo json_encode(['success' => false]);
    exit;
}

$team1 = (string)$data['team1'];
$team2 = (string)$data['team2'];
$matchFormat = isset($data['matchFormat']) ? (string)$data['matchFormat'] : 'BO3';

try {
    $pdo = getPdo();

    $stmt = $pdo->prepare(
        'INSERT INTO teams (id, team1, team2, match_format)
         VALUES (1, :team1, :team2, :match_format)
         ON DUPLICATE KEY UPDATE
            team1 = VALUES(team1),
            team2 = VALUES(team2),
            match_format = VALUES(match_format)'
    );

    $stmt->execute([
        ':team1' => $team1,
        ':team2' => $team2,
        ':match_format' => $matchFormat,
    ]);

    echo json_encode(['success' => true]);
} catch (Throwable $e) {
    echo json_encode(['success' => false]);
}
