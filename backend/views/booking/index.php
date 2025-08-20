<?php

use common\grid\EnumColumn;
use backend\models\Booking;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use rmrevin\yii\fontawesome\FAS;

/**
 * @var yii\web\View $this
 * @var backend\models\search\BookingSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */
$this->title = Yii::t('backend', 'Bookings');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header">
        <?php echo Html::a(FAS::icon('booking-plus').' '.Yii::t('backend', 'Add New {modelClass}', [
            'modelClass' => 'Booking',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card-body p-0">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'options' => [
                'class' => ['gridview', 'table-responsive'],
            ],
            'tableOptions' => [
                'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
            ],
            'columns' => [
                [
                    'attribute' => 'id',
                    'options' => ['style' => 'width: 5%'],
                ],
            'arrival_date',
            'departure_date',
            'booking_date',
            'total_price',
            'meal',
            'adults',
            'children',
            'source',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'status',

                [
                    'class' => EnumColumn::class,
                    'attribute' => 'status',
                    'enum' => Booking::statuses(),
                    'filter' => Booking::statuses()
                ],

                [
                    'class' => \common\widgets\ActionColumn::class,
                    'template' => '{login} {view} {update} {delete}',
                    'options' => ['style' => 'width: 140px'],
                    'buttons' => [
                        'login' => function ($url) {
                            return Html::a(
                                FAS::icon('sign-in-alt', ['aria' => ['hidden' => true], 'class' => ['fa-fw']]),
                                $url,
                                [
                                    'title' => Yii::t('backend', 'Login'),
                                    'class' => ['btn', 'btn-xs', 'btn-secondary']
                                ]
                            );
                        },
                    ],
                    'visibleButtons' => [
                        'login' => Yii::$app->user->can('administrator')
                    ]

                ],
            ],
        ]); ?>
    </div>

    <div class="card-footer">
        <?php echo getDataProviderSummary($dataProvider) ?>
    </div>
</div>
