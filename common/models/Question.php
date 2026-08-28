<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property int $category_id
 * @property string $question_text
 * @property string|null $difficulty
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Category $category
 * @property QuestionOption[] $questionOptions
 * @property QuizAnswer[] $quizAnswers
 */
class Question extends \yii\db\ActiveRecord
{


    public const TYPE_OPEN = 'open';
    public const TYPE_CHOICE = 'choice';

    public const DIFFICULTY_EASY = 'easy';
    public const DIFFICULTY_MEDIUM = 'medium';
    public const DIFFICULTY_HARD = 'hard';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['difficulty', 'created_at', 'updated_at', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_option'], 'default', 'value' => null],
            [['type'], 'default', 'value' => self::TYPE_OPEN],
            [['status'], 'default', 'value' => 1],
            [['category_id', 'question_text'], 'required'],
            [['category_id', 'status'], 'integer'],
            [['question_text', 'answer'], 'string'],
            [['type'], 'in', 'range' => [self::TYPE_OPEN, self::TYPE_CHOICE]],
            [['correct_option'], 'in', 'range' => ['A', 'B', 'C', 'D', 'a', 'b', 'c', 'd']],
            [['option_a', 'option_b', 'option_c', 'option_d'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['difficulty'], 'string', 'max' => 20],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Kategoriya',
            'type' => 'Savol turi',
            'question_text' => 'Savol matni',
            'option_a' => 'A varianti',
            'option_b' => 'B varianti',
            'option_c' => 'C varianti',
            'option_d' => 'D varianti',
            'correct_option' => 'To\'g\'ri variant (A, B, C, D)',
            'difficulty' => 'Qiyinlik darajasi',
            'status' => 'Holati',
            'created_at' => 'Yaratilgan sana',
            'updated_at' => 'Yangilangan sana',
            'answer' => 'Zakovat javobi / Izoh',
        ];
    }

    /**
     * Savol turi nomini olish
     */
    public function getTypeLabel(): string
    {
        return $this->type === self::TYPE_CHOICE ? 'Variantli test (A,B,C,D)' : 'Zakovat (Ochiq savol)';
    }

    /**
     * Qiyinlik darajasi nomini olish
     */
    public function getDifficultyLabel(): string
    {
        $diff = strtolower((string)$this->difficulty);
        if ($diff === 'easy' || $diff === 'oson') {
            return 'Oson';
        } elseif ($diff === 'hard' || $diff === 'qiyin') {
            return 'Qiyin';
        }
        return 'O\'rta';
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }


}
