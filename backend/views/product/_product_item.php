<?php

use yii\helpers\StringHelper;

?>

<div class="media text-center">
    <img src="<?php echo $model->getImageSrc() ?>" height="160px" alt="" class="mr-3">
    <div class="media-body text-center">
        <h5 class="mt-0"><?php echo $model->title ?></h5>
        <!-- <?php echo StringHelper::truncateWords($model->description , 10) ?> -->
    </div>
</div>