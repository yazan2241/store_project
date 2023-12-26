<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
?>


<div class='cart-item-wrapper'>
    <img src="<?php echo $model->getImageSrc() ?>" width="100px" alt='item' />
    <span><?php echo $model->product->title ?></span>
    <a href="<?php echo Url::to(['/cart/delete' , 'id' => $model->id]) ?>">Delete</a>
</div>