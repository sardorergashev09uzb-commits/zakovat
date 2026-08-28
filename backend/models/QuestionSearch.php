<?php

declare(strict_types=1);

namespace backend\models;

use common\models\Question;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * QuestionSearch represents the model behind the search form of `common\models\Question`.
 */
class QuestionSearch extends Question
{
    public $searchQuery;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'category_id', 'status'], 'integer'],
            [['question_text', 'difficulty', 'type', 'answer', 'searchQuery'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Question::find()->with('category');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Grid filtering conditions
        $query->andFilterWhere([
            'question.id' => $this->id,
            'question.category_id' => $this->category_id,
            'question.status' => $this->status,
            'question.type' => $this->type,
            'question.difficulty' => $this->difficulty,
        ]);

        $query->andFilterWhere(['like', 'question.question_text', $this->question_text])
            ->andFilterWhere(['like', 'question.answer', $this->answer]);

        if (!empty($this->searchQuery)) {
            $query->andWhere([
                'or',
                ['like', 'question.question_text', $this->searchQuery],
                ['like', 'question.answer', $this->searchQuery],
                ['like', 'question.option_a', $this->searchQuery],
                ['like', 'question.option_b', $this->searchQuery],
                ['like', 'question.option_c', $this->searchQuery],
                ['like', 'question.option_d', $this->searchQuery],
            ]);
        }

        return $dataProvider;
    }
}
