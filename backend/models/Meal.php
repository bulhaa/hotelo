<?php

namespace backend\models;

use backend\models\query\MealQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "meal".
 *
 * @property integer $id
 * @property string $name

 *
 * @property User                $author
 * @property User                $updater
 * @property MealCategory     $category
 */
class Meal extends ActiveRecord
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
        return '{{%meals}}';
    }

    /**
     * @return MealQuery
     */
    public static function find()
    {
        return new MealQuery(get_called_class());
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
            // [
            //     'class' => UploadBehavior::class,
            //     'attribute' => 'attachments',
            //     'multiple' => true,
            //     'uploadRelation' => 'mealAttachments',
            //     'pathAttribute' => 'path',
            //     'baseUrlAttribute' => 'base_url',
            //     'orderAttribute' => 'order',
            //     'typeAttribute' => 'type',
            //     'sizeAttribute' => 'size',
            //     'nameAttribute' => 'name',
            // ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',

        ];
    }



}
