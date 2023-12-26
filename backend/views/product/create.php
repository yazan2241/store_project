<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\product $model */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="upload-icon">
            <i class="fa fa-upload"></i>
        </div>
        <p class="m-0">Drag and Drop your image</p>

        <?php ActiveForm::begin([
            'options' => ['encType' => 'multipart/form-data']
        ]) ?>

       

        <button class="btn btn-primary btn-file">
            Select file
            <input type="file" id="uploadFile" name="image" />
        </button>

        <?php ActiveForm::end() ?>

    </div>

</div>
