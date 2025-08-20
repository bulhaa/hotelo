<?php

namespace backend\models;

use backend\models\query\BookingQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "booking".
 *
 * @property integer $id
 * @property datetime $arrival_date
 * @property datetime $departure_date
 * @property datetime $booking_date
 * @property decimal(10,0) $total_price
 * @property integer $meal
 * @property integer $adults
 * @property integer $children
 * @property integer $source
 * @property datetime $created_at
 * @property datetime $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status

 *
 * @property User                $author
 * @property User                $updater
 * @property BookingCategory     $category
 */
class Booking extends ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT     = 0;

    /**
     * @var array
     */
    public $attachments;

    /**
     * @var array
     */
    public $thumbnail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bookings}}';
    }

    /**
     * @return BookingQuery
     */
    public static function find()
    {
        return new BookingQuery(get_called_class());
    }

    /**
     * @return array statuses list
     */
    public static function statuses()
    {
        return [
            self::STATUS_DRAFT => Yii::t('common', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('common', 'Published'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            // [
            //     'class' => SluggableBehavior::class,
            //     'attribute' => 'title',
            //     'immutable' => true,
            // ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total_price'], 'string'],
            [['meal'], 'integer'],
            [['adults'], 'integer'],
            [['children'], 'integer'],
            [['source'], 'integer'],
            [['status'], 'integer'],

        ];
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
     * Get the user that owns the booking.
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['' => 'created_by']);
    }

    // /**
    //  * Get the bookings for the user.
    //  */
    // public function getBookings()
    // {
    //     return $this->hasMany(Booking::className(), ['created_by' => '']);
    // }

    /**
     * Get the user that owns the booking.
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['' => 'updated_by']);
    }

    // /**
    //  * Get the bookings for the user.
    //  */
    // public function getBookings()
    // {
    //     return $this->hasMany(Booking::className(), ['updated_by' => '']);
    // }



}
