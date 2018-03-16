<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dishes".
 *
 * @property int $id
 * @property string $name
 *
 * @property DishIngredient[] $dishIngredients
 */
class Dish extends \yii\db\ActiveRecord
{
    public $matchIngredients = 'lol';
    public $ingredient_ids = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dishes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['ingredient_ids'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ingredient_ids' => 'Ingredients',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['id' => 'ingredient_id'])->viaTable('dish_ingredient', ['dish_id' => 'id']);
    }

    public function saveIngredients()
    {
        DishIngredient::deleteAll(['dish_id' => $this->id]);
        if (is_array($this->ingredient_ids)) {
            foreach($this->ingredient_ids as $ingredient_id) {
                $di = new DishIngredient();
                $di->dish_id = $this->id;
                $di->ingredient_id = $ingredient_id;
                $di->save();
            }
        }
    }

    public function loadIngredients()
    {
        $this->ingredient_ids = [];
        if (!empty($this->id)) {
            $rows = DishIngredient::find()
                ->select(['ingredient_id'])
                ->where(['dish_id' => $this->id])
                ->asArray()
                ->all();
            foreach($rows as $row) {
                $this->ingredient_ids[] = $row['ingredient_id'];
            }
        }
    }
}
