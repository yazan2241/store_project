<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<div class="col-lg-4 col-sm-3">
    <div class='item-details1'>
        <img class="item-details-img" src="<?php echo $model->getImageSrc() ?>" alt='item' />
        <div class="item-details">
            <span class='item-span1'><?php echo $model->title ?></span>
            <span class='item-span2'><?php echo $model->description ?></span>
            <?php if ($model->like == '0') { ?>
                <?php Pjax::begin() ?>
                <a class='add-to-cart' href="<?php echo Url::to(['/product/like', 'id' => $model->product_id]) ?>" data-method='post' data-pjax='1'>
                    Add To Fav
                </a>
                <?php Pjax::end() ?>
            <?php } else {
            ?>
                <span class='added-to-cart'>Added</span>
            <?php
            } ?>
        </div>
    </div>
</div>