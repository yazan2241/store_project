<?php

use common\models\product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'content' => function ($model) {
                    return $this->render('_product_item', ['model' => $model]);
                }
            ],
            [
                'attribute' => 'description',
                'content' => function ($model) {
                    return StringHelper::truncateWords($model->description, 10);
                }
            ],
            'image_name',
            'created_at:datetime',
            'updated_at:datetime',
            //'created_by',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'product_id' => $model->product_id]);
                },
                // 'buttons' => [
                //     'delete' => function ($url) {
                //         return HTML::a('Delete', $url , [
                //             'data-method' => 'post',
                //             'data-confirm' => 'Are you sure?'
                //         ]);
                //     }
                // ]
            ],
        ],
    ]); ?>


</div>