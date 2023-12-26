<?php

/** @var yii\web\View $this */

use common\models\ProductCart;
use yii\bootstrap5\Html;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\widgets\ListView;

?>

<h3 class="text-center font-bold mt-5">Favorate</h3>


<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_cart_item',
    'layout' => '<div class="flex mt-5 flex-col flex-wrap">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false,
    ],
])
?>