<?php

namespace Helpers;

require_once '../vendor/autoload.php';

use Helpers\ValidationHelper;

$title = ValidationHelper::string(isset($_POST['title']) && $_POST['title'] !== '' ? $_POST['title'] : 'untitled');
$description = ValidationHelper::string(isset($_POST['description']) && $_POST['description'] !== '' ? $_POST['description'] : '...');
$date = ValidationHelper::string(date('Y-m-d H:i:s'));
$imageFile = $_FILES['file'];

// imageFileを元にハッシュ値を生成し、一意の閲覧用URLと削除用URLを生成
$postPath = ValidationHelper::string(hash('md5', $imageFile['name'] . $date));
$deletePath = ValidationHelper::string(hash('md5', $imageFile['name'] . $date . 'delete'));
// 投稿したユーザーのデバイスのIPアドレスを取得
$ipAddress = ValidationHelper::string($_SERVER['REMOTE_ADDR']);
$fileSize = $imageFile['size'];

// 画像ファイルを一時ディレクトリに保存
$imagePath = '../Temps/' . $imageFile['name'];
if (move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
    $dataStr = implode(',', [$title, $description, $imagePath, $postPath, $deletePath, $ipAddress, $fileSize]);
    $command = sprintf('php ../console seed --data "%s"', escapeshellarg($dataStr));
    exec($command, $output, $return_var);

    if($return_var !== 0) {
        http_response_code(500);
        echo 'Seed execution failed.';
        exit();
    }
} else {
    http_response_code(500);
    echo 'Failed to post the image.';
    exit();
}

$resData = array( 'postPath' => $postPath, 'deletePath' => $deletePath,
);
print(json_encode($resData));
