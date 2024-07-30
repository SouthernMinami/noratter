<?php

namespace Views;

use Helpers\DatabaseHelper;

// imagesテーブルのaccessed_atとview_countを更新する
DatabaseHelper::updateImage($image['post_path']);
?>

<script type="text/javascript">
    var image = <?php
        echo json_encode($image); 
    ?>;
</script>

<div class="d-flex flex-column p-4 m-3 w-50 border border-secondary rounded post-area">        
    <h3><?php echo htmlspecialchars($image['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
    <div id="preview" class="pb-3 preview">
        <img id="preview-img" src="<?php echo htmlspecialchars($image['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="preview image">
    </div>    
    <p>Description<br/><?php echo htmlspecialchars($image['description'], ENT_QUOTES, 'UTF-8'); ?></p>
    <p>Views: <?php echo htmlspecialchars($image['view_count'], ENT_QUOTES, 'UTF-8'); ?></p>
    <p>Post Date: <?php echo htmlspecialchars($image['created_at'], ENT_QUOTES, 'UTF-8'); ?></p>
    <a id="delete" class="btn btn-danger" 
        href="/delete/<?php echo htmlspecialchars($image['delete_path'], ENT_QUOTES, 'UTF-8'); ?>">
        DELETE
    </a>
</div>

<!-- <script src="../public/js/app_image.js"></script> -->