<?php

use backend\models\Meal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\MealForm */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="meal-form">
    <?php $form = ActiveForm::begin() ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->field($model, 'name') ?>

                <?php echo $form->field($model, 'status')->dropDownList(Meal::statuses()) ?>
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
