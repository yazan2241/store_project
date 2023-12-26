<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-8">
            <?php echo $form->errorSummary($model) ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        </div>
        <div class="col-sm-4">
            
        <img src="<?php echo $model->getImageSrc() ?>" alt="" height="350px" width="400px" />
            
            <div class="mb-3">
                <div class="text-muted">Image Name</div>
                <?php echo $model->image_name ?>
            </div>

            <?= $form->field($model, 'status')->dropDownList($model->getStatusLabels()) ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>