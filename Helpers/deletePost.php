<?php

namespace Helpers;

require_once '../vendor/autoload.php';

use Helpers\ValidationHelper;
use Database\MySQLWrapper;

// deletePathのハッシュ値に合った投稿をテーブルから削除
$deletePath = ValidationHelper::string($_POST['deletePath']);

$db = new MySQLWrapper();

$query = "DELETE FROM images WHERE delete_path = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('s', $deletePath);

$resData = [];

if ($stmt->execute()) {
    // Tempsに保存してあるファイルを削除
    $imagePath = "../Temps/{$deletePath}";
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    http_response_code(200);
    $resData['status'] = "success";
    print (json_encode($resData));
    exit();
} else {
    http_response_code(500);
    $resData['status'] = "failed";
    print (json_encode($resData));
    exit();
}