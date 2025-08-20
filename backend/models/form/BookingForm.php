<?php

namespace backend\models\form;

use backend\models\Booking;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Create booking form
 */
class BookingForm extends Model
{
    public $id;
    public $arrival_date;
    public $departure_date;
    public $booking_date;
    public $total_price;
    public $meal;
    public $adults;
    public $children;
    public $source;
    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;
    public $status;


    private $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['arrival_date'], 'required'],
            // [['departure_date'], 'required'],
            // [['booking_date'], 'required'],
            // [['total_price'], 'required'],
            [['total_price'], 'string'],
            // [['meal'], 'required'],
            [['meal'], 'integer'],
            // [['adults'], 'required'],
            [['adults'], 'integer'],
            // [['children'], 'required'],
            [['children'], 'integer'],
            // [['source'], 'required'],
            [['source'], 'integer'],
            // [['status'], 'required'],
            [['status'], 'integer'],

        ];
    }

    /**
     * @return Booking
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new Booking();
        }
        return $this->model;
    }

    /**
     * @param Booking $model
     * @return mixed
     */
    public function setModel($model)
    {
        $this->bookingname = $model->bookingname;
        $this->email = $model->email;
        $this->status = $model->status;
        $this->model = $model;
        $this->roles = ArrayHelper::getColumn(
            Yii::$app->authManager->getRolesByBooking($model->getId()),
            'name'
        );
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'arrival_date' => 'Arrival Date',
            'departure_date' => 'Departure Date',
            'booking_date' => 'Booking Date',
            'total_price' => 'Total Price',
            'meal' => 'Meal',
            'adults' => 'Adults',
            'children' => 'Children',
            'source' => 'Source',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',

        ];
    }

    /**
     * Signs booking up.
     * @return Booking|null the saved model or null if saving fails
     * @throws Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $isNewRecord = $model->getIsNewRecord();

            $model->arrival_date = $this->arrival_date;
            $model->departure_date = $this->departure_date;
            $model->booking_date = $this->booking_date;
            $model->total_price = $this->total_price;
            $model->meal = $this->meal;
            $model->adults = $this->adults;
            $model->children = $this->children;
            $model->source = $this->source;
            $model->created_at = $this->created_at;
            $model->updated_at = $this->updated_at;
            $model->created_by = $this->created_by;
            $model->updated_by = $this->updated_by;
            $model->status = $this->status;

            // dd(array('$model->hasErrors(): ' => $model->hasErrors()));
            // dd(array('$model->save(): ' => $model->save()));
            // dd(array('$model: ' => $model));


            if (!$model->save()) {
                \Yii::error($model->errors, __METHOD__); // log errors
                throw new \Exception('Model not saved: ' . json_encode($model->errors));
                // throw new Exception('Model not saved');
            }

            return !$model->hasErrors();
        }
        return null;
    }
}
