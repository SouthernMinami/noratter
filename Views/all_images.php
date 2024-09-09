<?php

namespace Views;

define('IMAGES_PER_PAGE', 6);
define('PAGE_COUNT', ceil(count($images) / IMAGES_PER_PAGE));

// 閲覧数の多い順にクイックソート(usort())
usort($images, function ($a, $b) {
    return $b['view_count'] - $a['view_count'];
});

$currPage = isset($_GET['page']) ? $_GET['page'] : 1;
$indexOfLastImage = $currPage * IMAGES_PER_PAGE;
$indexOfFirstImage = $indexOfLastImage - IMAGES_PER_PAGE;

$currImages = array_slice($images, $indexOfFirstImage, $indexOfLastImage);

?>

<div class="my-4 title-container">
    <h1 class="page-title">ALL IMAGES</h1>
</div>

<div class="row cards-container">
    <?php foreach ($currImages as $image): ?>
        <div class="col-md-4 col-sm-6 mb-2">
            <div class="card post-card">
                <a href="/image/<?php echo htmlspecialchars($image['post_path'], ENT_QUOTES, 'UTF-8'); ?>">
                    <img src="<?php echo htmlspecialchars($image['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="preview image" class="img-fluid img-thumbnail">
                </a>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($image['title'], ENT_QUOTES, 'UTF-8'); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($image['description'], ENT_QUOTES, 'UTF-8'); ?></p>    
                    <p class="card-text">Views: <?php echo htmlspecialchars($image['view_count'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="card-text">Post Date: <?php echo htmlspecialchars($image['created_at'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="pagination">
    <?php foreach (range(1, PAGE_COUNT) as $page):
        $isCurrPage = $page == $currPage;
        $bgColor = $isCurrPage ? 'bg-gray' : 'bg-skyblue';

        echo '<a href="?page=' . $page . '" class="pagination-btn ' . $bgColor . ' ' . '">' . $page . '</a>';
    endforeach; ?>
</div>