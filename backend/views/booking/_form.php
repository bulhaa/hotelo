<?php

use backend\models\Booking;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\Meal;
use backend\models\Source;
use backend\models\Status;


/* @var $this yii\web\View */
/* @var $model backend\models\BookingForm */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="booking-form">
    <?php $form = ActiveForm::begin() ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->field($model, 'arrival_date')->widget(DatePicker::class, [
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                ]); ?>
                <?php echo $form->field($model, 'departure_date')->widget(DatePicker::class, [
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                ]); ?>
                <?php echo $form->field($model, 'booking_date')->widget(DatePicker::class, [
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                ]); ?>
                <?= $form->field($model, 'total_price')->input('number', [
                    'min' => 0,
                    'step' => '0.01', // allows decimals, change to '1' if only integers
                ]) ?>
                <?= $form->field($model, 'meal')->widget(Select2::class, [
                    'data' => ArrayHelper::map(Meal::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Select a meal...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
                <?= $form->field($model, 'adults')->input('number', [
                    'min' => 0,
                    'step' => '0.01', // allows decimals, change to '1' if only integers
                ]) ?>
                <?= $form->field($model, 'children')->input('number', [
                    'min' => 0,
                    'step' => '0.01', // allows decimals, change to '1' if only integers
                ]) ?>
                <?= $form->field($model, 'source')->widget(Select2::class, [
                    'data' => ArrayHelper::map(Source::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Select a source...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
                <?= $form->field($model, 'status')->widget(Select2::class, [
                    'data' => ArrayHelper::map(Status::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Select a status...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
