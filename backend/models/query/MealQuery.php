<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace backend\models\query;

use backend\models\Meal;
use backend\models\MealCategory;
use yii\db\ActiveQuery;

class MealQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['{{%meal}}.[[status]]' => Meal::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%meal}}.[[published_at]]', time()]);
        return $this;
    }

    public function getFullArchive()
    {
        $this->innerJoin('{{%meal_category}}', '{{%meal_category}}.[[id]] = {{%meal}}.[[category_id]]');
        $this->select([
            'YEAR(FROM_UNIXTIME({{%meal}}.[[published_at]])) AS [[year]]',
            'MONTH(FROM_UNIXTIME({{%meal}}.[[published_at]])) AS [[month]]',
            'COUNT(*) AS [[count]]'
        ]);
        $this->published();
        $this->andWhere(['{{%meal_category}}.[[status]]' => MealCategory::STATUS_ACTIVE]);
        $this->groupBy('[[year]], [[month]]');
        $this->orderBy('[[year]] DESC, [[month]] DESC');
        return $this;
    }
}
