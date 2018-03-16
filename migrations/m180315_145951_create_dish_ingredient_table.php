<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dish_ingredient`.
 * Has foreign keys to the tables:
 *
 * - `dishes`
 * - `ingredients`
 */
class m180315_145951_create_dish_ingredient_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dish_ingredient', [
            'id' => $this->primaryKey(),
            'dish_id' => $this->integer()->notNull(),
            'ingredient_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `dish_id`
        $this->createIndex(
            'idx-dish_ingredient-dish_id',
            'dish_ingredient',
            'dish_id'
        );

        // add foreign key for table `dishes`
        $this->addForeignKey(
            'fk-dish_ingredient-dish_id',
            'dish_ingredient',
            'dish_id',
            'dishes',
            'id',
            'CASCADE'
        );

        // creates index for column `ingredient_id`
        $this->createIndex(
            'idx-dish_ingredient-ingredient_id',
            'dish_ingredient',
            'ingredient_id'
        );

        // add foreign key for table `ingredients`
        $this->addForeignKey(
            'fk-dish_ingredient-ingredient_id',
            'dish_ingredient',
            'ingredient_id',
            'ingredients',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `dishes`
        $this->dropForeignKey(
            'fk-dish_ingredient-dish_id',
            'dish_ingredient'
        );

        // drops index for column `dish_id`
        $this->dropIndex(
            'idx-dish_ingredient-dish_id',
            'dish_ingredient'
        );

        // drops foreign key for table `ingredients`
        $this->dropForeignKey(
            'fk-dish_ingredient-ingredient_id',
            'dish_ingredient'
        );

        // drops index for column `ingredient_id`
        $this->dropIndex(
            'idx-dish_ingredient-ingredient_id',
            'dish_ingredient'
        );

        $this->dropTable('dish_ingredient');
    }
}
