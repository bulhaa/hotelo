<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace backend\models\query;

use backend\models\Booking;
use backend\models\BookingCategory;
use yii\db\ActiveQuery;

class BookingQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['{{%booking}}.[[status]]' => Booking::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%booking}}.[[published_at]]', time()]);
        return $this;
    }

    public function getFullArchive()
    {
        $this->innerJoin('{{%booking_category}}', '{{%booking_category}}.[[id]] = {{%booking}}.[[category_id]]');
        $this->select([
            'YEAR(FROM_UNIXTIME({{%booking}}.[[published_at]])) AS [[year]]',
            'MONTH(FROM_UNIXTIME({{%booking}}.[[published_at]])) AS [[month]]',
            'COUNT(*) AS [[count]]'
        ]);
        $this->published();
        $this->andWhere(['{{%booking_category}}.[[status]]' => BookingCategory::STATUS_ACTIVE]);
        $this->groupBy('[[year]], [[month]]');
        $this->orderBy('[[year]] DESC, [[month]] DESC');
        return $this;
    }
}
