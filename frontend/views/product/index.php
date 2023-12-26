<?php
/** @var yii\web\View $this */

use yii\widgets\ListView;

?>

<?php 

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_product_item',
    'layout' => '<div class="d-flex flex-wrap row">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false,
    ],
])

?>
