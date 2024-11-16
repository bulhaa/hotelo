<?php

namespace backend\models\query;

use common\models\Booking;
use yii\db\ActiveQuery;

/**
 * Class BookingQuery
 * @package common\models\query
 * @author Eugene Terentev <eugene@terentev.net>
 */
class BookingQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function notDeleted()
    {
        $this->andWhere(['!=', 'status', Booking::STATUS_DELETED]);
        return $this;
    }

    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => Booking::STATUS_ACTIVE]);
        return $this;
    }
}