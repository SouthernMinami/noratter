<?php
use Helpers\ValidationHelper;

spl_autoload_extensions(".php");
spl_autoload_register(function ($class) {
    $namespace = explode('\\', $class);
    $file = __DIR__ . '/' . implode('/', $namespace) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
// spl_autoload_register();

$DEBUG = true;

// ルーティング
$routes = include (__DIR__ . '/Routing/routes.php');

// リクエストURLを取得
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// 先頭のスラッシュを削除
$path = ltrim($path, '/');
// パスがimageもしくはdeleteから始まる場合、/{hash}の部分は除く
$path = ValidationHelper::path($path, 'image');
$path = ValidationHelper::path($path, 'delete');

if (isset($routes[$path])) {
    $renderer = $routes[$path]();
    try {
        // ヘッダーフィールドを設定
        foreach ($renderer->getFields() as $name => $value) {
            // ヘッダーに設定する値を無害なものにサニタイズ
            $sanitized_value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // サニタイズされた値がもとの値と一致する場合、ヘッダーに設定
            if ($sanitized_value === $value) {
                header("{$name}: {$value}");
            } else {
                // 一致しない場合、ログに記録するか処理する
                // エラー処理によっては例外をスローするか、デフォルトのまま続行
                http_response_code(500);
                if ($DEBUG) {
                    print ("Failed setting header - original value: '{$value}', sanitized value: '{$sanitized_value}'");
                }
                exit();
            }
        }
        print ($renderer->getContent());
    } catch (Exception $e) {
        http_response_code(500);
        print ("Internal error, please contact the admin. <br>");

        if ($DEBUG) {
            print ($e->getMessage());
        }
    }
} else {
    // 一致するルートがない場合、404 Not Foundページを表示
    http_response_code(404);
    include (__DIR__ . '/Views/layout/header.php');
    include (__DIR__ . '/Views/404.php');
    include (__DIR__ . '/Views/layout/footer.php');
}