<?php

namespace backend\models\search;

use backend\models\Booking;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BookingSearch represents the model behind the search form about `common\models\Booking`.
 */
class BookingSearch extends Booking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['arrival_date'], 'safe'],
            [['arrival_date'], 'date'],
            // [['departure_date'], 'safe'],
            [['departure_date'], 'date'],
            // [['booking_date'], 'safe'],
            [['booking_date'], 'date'],
            // [['total_price'], 'safe'],
            // [['meal'], 'safe'],
            [['meal'], 'integer'],
            // [['adults'], 'safe'],
            [['adults'], 'integer'],
            // [['children'], 'safe'],
            [['children'], 'integer'],
            // [['source'], 'safe'],
            [['source'], 'integer'],
            // [['status'], 'safe'],
            [['status'], 'integer'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Booking::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', strtotime($this->created_at), strtotime($this->created_at) + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', strtotime($this->updated_at), strtotime($this->updated_at) + 3600 * 24]);
        }

        if ($this->logged_at !== null) {
            $query->andFilterWhere(['between', 'logged_at', strtotime($this->logged_at), strtotime($this->logged_at) + 3600 * 24]);
        }

        $query->andFilterWhere(['like', 'bookingname', $this->bookingname])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
