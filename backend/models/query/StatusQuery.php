<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace backend\models\query;

use backend\models\Status;
use backend\models\StatusCategory;
use yii\db\ActiveQuery;

class StatusQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['{{%status}}.[[status]]' => Status::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%status}}.[[published_at]]', time()]);
        return $this;
    }

    public function getFullArchive()
    {
        $this->innerJoin('{{%status_category}}', '{{%status_category}}.[[id]] = {{%status}}.[[category_id]]');
        $this->select([
            'YEAR(FROM_UNIXTIME({{%status}}.[[published_at]])) AS [[year]]',
            'MONTH(FROM_UNIXTIME({{%status}}.[[published_at]])) AS [[month]]',
            'COUNT(*) AS [[count]]'
        ]);
        $this->published();
        $this->andWhere(['{{%status_category}}.[[status]]' => StatusCategory::STATUS_ACTIVE]);
        $this->groupBy('[[year]], [[month]]');
        $this->orderBy('[[year]] DESC, [[month]] DESC');
        return $this;
    }
}
