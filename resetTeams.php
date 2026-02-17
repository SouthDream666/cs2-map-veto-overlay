<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/config.php';

try {
    $pdo = getPdo();
    $stmt = $pdo->prepare('DELETE FROM teams WHERE id = 1');
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Throwable $e) {
    echo json_encode(['success' => false]);
}
