<?php

namespace backend\models;

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
    public $bookingname;
    public $email;
    public $password;
    public $status;
    public $roles;

    private $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // ['bookingname', 'filter', 'filter' => 'trim'],
            // ['bookingname', 'required'],
            // ['bookingname', 'unique', 'targetClass' => Booking::class, 'filter' => function ($query) {
            //     if (!$this->getModel()->isNewRecord) {
            //         $query->andWhere(['not', ['id' => $this->getModel()->id]]);
            //     }
            // }],
            ['bookingname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            // ['email', 'email'],
            // ['email', 'unique', 'targetClass' => Booking::class, 'filter' => function ($query) {
            //     if (!$this->getModel()->isNewRecord) {
            //         $query->andWhere(['not', ['id' => $this->getModel()->id]]);
            //     }
            // }],

            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],

            [['status'], 'integer'],
            [['roles'], 'each',
                'rule' => ['in', 'range' => ArrayHelper::getColumn(
                    Yii::$app->authManager->getRoles(),
                    'name'
                )]
            ],
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
            'bookingname' => Yii::t('common', 'Bookingname'),
            'email' => Yii::t('common', 'Email'),
            'status' => Yii::t('common', 'Status'),
            'password' => Yii::t('common', 'Password'),
            'roles' => Yii::t('common', 'Roles')
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
            // $model->bookingname = $this->bookingname;
            // $model->email = $this->email;
            // $model->status = $this->status;
            // if ($this->password) {
            //     $model->setPassword($this->password);
            // }
            if (!$model->save()) {
                throw new Exception('Model not saved');
            }
            if ($isNewRecord) {
                $model->afterSignup();
            }
            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->getId());

            if ($this->roles && is_array($this->roles)) {
                foreach ($this->roles as $role) {
                    $auth->assign($auth->getRole($role), $model->getId());
                }
            }

            return !$model->hasErrors();
        }
        return null;
    }
}
