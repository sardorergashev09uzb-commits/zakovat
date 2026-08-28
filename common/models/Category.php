<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $icon
 * @property string|null $difficulty
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Question[] $questions
 * @property QuizAttempt[] $quizAttempts
 */
class Category extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'icon', 'difficulty', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['name', 'slug'], 'required'],
            [['description'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 50],
            [['difficulty'], 'string', 'max' => 20],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'icon' => 'Icon',
            'difficulty' => 'Difficulty',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[QuizAttempts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAttempts()
    {
        return $this->hasMany(QuizAttempt::class, ['category_id' => 'id']);
    }

}
