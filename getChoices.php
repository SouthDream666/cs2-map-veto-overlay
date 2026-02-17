<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once __DIR__ . '/config.php';

try {
    $pdo = getPdo();
    
    // 使用预处理语句，提高安全性和性能
            $stmt = $pdo->prepare('SELECT id, team, action, side, map, opposite_team AS oppositeTeam FROM choices ORDER BY id ASC');
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    echo json_encode($rows);
} catch (PDOException $e) {
    // 记录错误日志
    error_log('Database error in getChoices: ' . $e->getMessage());
    echo json_encode([]);
} catch (Throwable $e) {
    // 记录错误日志
    error_log('General error in getChoices: ' . $e->getMessage());
    echo json_encode([]);
}
