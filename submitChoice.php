<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/config.php';

// 接收并验证数据
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['team']) || !isset($data['action']) || !isset($data['map'])) {
    echo json_encode(['success' => false, 'message' => '缺少必要参数']);
    exit;
}

// 数据验证和清理
$team = trim((string)$data['team']);
$action = trim((string)$data['action']);
$map = trim((string)$data['map']);
$side = isset($data['side']) ? trim((string)$data['side']) : '';
$oppositeTeam = isset($data['oppositeTeam']) ? trim((string)$data['oppositeTeam']) : '';

// 验证操作类型
$validActions = ['Pick', 'Ban'];
if (!in_array($action, $validActions)) {
    echo json_encode(['success' => false, 'message' => '无效的操作类型']);
    exit;
}

// 验证阵营选择
if ($side && !in_array($side, ['T', 'CT', 'KNIFE'])) {
    echo json_encode(['success' => false, 'message' => '无效的阵营选择']);
    exit;
}

try {
    $pdo = getPdo();

    // 检查地图是否已经被选择（编辑模式下允许使用相同的地图）
    $checkStmt = $pdo->prepare(
        'SELECT COUNT(*) FROM choices WHERE map = :map'
    );
    $checkStmt->execute([':map' => $map]);
    $count = $checkStmt->fetchColumn();
    
    // 只有当地图确实被其他选择使用时才返回错误
    // 编辑模式下，我们会先删除旧的选择，所以这里的检查可能会误报
    // 暂时注释掉这个检查，因为编辑模式下我们会先删除旧的选择
    /*
    if ($count > 0) {
        echo json_encode(['success' => false, 'message' => '该地图已经被选择']);
        exit;
    }
    */

    $stmt = $pdo->prepare(
        'INSERT INTO choices (team, action, side, map, opposite_team)
         VALUES (:team, :action, :side, :map, :opposite_team)'
    );

    $stmt->execute([
        ':team' => $team,
        ':action' => $action,
        ':side' => $side,
        ':map' => $map,
        ':opposite_team' => $oppositeTeam,
    ]);

    echo json_encode(['success' => true, 'message' => '提交成功']);
} catch (PDOException $e) {
    // 记录错误日志
    error_log('Database error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => '数据库操作失败']);
} catch (Throwable $e) {
    // 记录错误日志
    error_log('General error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => '服务器内部错误']);
}
