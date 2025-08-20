<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace backend\models\query;

use backend\models\Source;
use backend\models\SourceCategory;
use yii\db\ActiveQuery;

class SourceQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['{{%source}}.[[status]]' => Source::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%source}}.[[published_at]]', time()]);
        return $this;
    }

    public function getFullArchive()
    {
        $this->innerJoin('{{%source_category}}', '{{%source_category}}.[[id]] = {{%source}}.[[category_id]]');
        $this->select([
            'YEAR(FROM_UNIXTIME({{%source}}.[[published_at]])) AS [[year]]',
            'MONTH(FROM_UNIXTIME({{%source}}.[[published_at]])) AS [[month]]',
            'COUNT(*) AS [[count]]'
        ]);
        $this->published();
        $this->andWhere(['{{%source_category}}.[[status]]' => SourceCategory::STATUS_ACTIVE]);
        $this->groupBy('[[year]], [[month]]');
        $this->orderBy('[[year]] DESC, [[month]] DESC');
        return $this;
    }
}
