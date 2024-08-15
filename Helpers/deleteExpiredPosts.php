<?php

namespace Helpers;

// crontabから読み込めるようにフルパスで指定（本番環境用）
// require_once '/home/ubuntu/web/noratter/vendor/autoload.php';
require_once '/home/vboxuser/dev/noratter/vendor/autoload.php';

use Database\MySQLWrapper;


$db = new MySQLWrapper();

// １分以上経過した投稿のdelete_pathを取得し、投稿を削除（デプロイ後は30日に変更）
// DATE_SUB() ... 指定した日付からINTERVALで指定した期間を引いた日付を取得
$query = "SELECT delete_path FROM images WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
$deleteQuery = "DELETE FROM images WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 MINUTE)";

$stmt = $db->prepare($query);
$deleteStmt = $db->prepare($deleteQuery);

$deletePaths = [];
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($deletePath);
while ($stmt->fetch()) {
    $deletePaths[] = $deletePath;
}

$resData = [];

if ($deleteStmt->execute() && $deletePaths !== []) {
    // Tempsに保存してあるファイルを削除
    foreach ($deletePaths as $deletePath) {
        $imagePath = "../Temps/{$deletePath}";
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    http_response_code(200);
    $resData['status'] = "success";
    print (json_encode($resData));
} else {
    http_response_code(500);
    $resData['status'] = "failed";
    print (json_encode($resData));
    exit();
}