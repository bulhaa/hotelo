<?php

use backend\models\Status;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model backend\models\StatusForm */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="status-form">
    <?php $form = ActiveForm::begin() ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->field($model, 'name') ?>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
