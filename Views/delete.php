<?php

namespace Views;

use Helpers\DatabaseHelper;

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
    <p>Delete this post?</p>
    <a id="delete" onClick="deletePost()" class="btn btn-danger">YES</a>
    <a id="cancel" href="/image/<?php echo htmlspecialchars($image['post_path'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">NO</a>
</div>

<script src="../public/js/app_delete.js"></script>