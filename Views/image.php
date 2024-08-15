<?php

namespace Views;

use Helpers\DatabaseHelper;

date_default_timezone_set('Asia/Tokyo');

// imagesテーブルのaccessed_atとview_countを更新する
DatabaseHelper::updateImage($image['post_path']);

// deleteExpiredPosts.phpを実行する(フルパスで指定)
// $cronJob = '* * * */1 * /usr/bin/php /home/ubuntu/web/noratter/Helpers/deleteExpiredPosts.php';
$cronJob = '*/1 * * * * /usr/bin/php /home/vboxuser/dev/noratter/Helpers/deleteExpiredPosts.php';

// 既存のcronジョブを取得
$output = [];
$return_var = 0;
exec('crontab -l', $output, $return_var);

// 既存のcronジョブに同じジョブがないか確認
if (!in_array($cronJob, $output)) {
    $output[] = $cronJob; // 新しいジョブを追加
    // 一時ファイルを作成し、新しいcronジョブリストを書き込む
    // cronジョブの定義は行ごとに解析されるため、末尾に改行を入れないと定義がまだ完了していないとみなされる
    $tempFile = tempnam(sys_get_temp_dir(), 'cron');
    file_put_contents($tempFile, implode(PHP_EOL, $output) . PHP_EOL);

    // 新しいcronジョブリストを設定
    exec("crontab $tempFile", $output, $return_var);
    if ($return_var !== 0) {
        error_log("Cron setting failed.");
    }
} else {
    error_log("Cron job already exists.");
}

var_dump($output);


?>
<script type="text/javascript">
    var image = <?php
    echo json_encode($image);
    ?>;
</script>

<div class="d-flex flex-column p-4 m-3 w-50 border border-secondary rounded post-area">
    <h3><?php echo htmlspecialchars($image['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
        <div id="preview" class="pb-3 preview">
            <img id="preview-img" src="<?php echo htmlspecialchars($image['image_path'], ENT_QUOTES, 'UTF-8'); ?>"
                alt="preview image">
        </div>
        <p>Description<br /><?php echo htmlspecialchars($image['description'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p>Views: <?php echo htmlspecialchars($image['view_count'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p>Post Date: <?php echo htmlspecialchars($image['created_at'], ENT_QUOTES, 'UTF-8'); ?></p>
        <a id="delete" class="btn btn-danger"
            href="/delete/<?php echo htmlspecialchars($image['delete_path'], ENT_QUOTES, 'UTF-8'); ?>">
            DELETE
        </a>
</div>

<!-- <script src="../public/js/app_image.js"></script> -->