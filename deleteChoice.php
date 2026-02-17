<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/config.php';

// 接收并验证数据
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => '缺少必要参数']);
    exit;
}

$id = (int)$data['id'];

try {
    $pdo = getPdo();
    
    // 使用预处理语句，提高安全性和性能
    $stmt = $pdo->prepare('DELETE FROM choices WHERE id = :id');
    $stmt->execute([':id' => $id]);
    
    echo json_encode(['success' => true, 'message' => '删除成功']);
} catch (PDOException $e) {
    // 记录错误日志
    error_log('Database error in deleteChoice: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => '数据库操作失败']);
} catch (Throwable $e) {
    // 记录错误日志
    error_log('General error in deleteChoice: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => '服务器内部错误']);
}