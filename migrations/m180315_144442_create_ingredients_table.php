<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ingredients`.
 */
class m180315_144442_create_ingredients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ingredients', [
            'id' => $this->primaryKey(),
			'name' => $this->string()->notNull(),
			'available' => "ENUM('1', '0') NOT NULL",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ingredients');
    }
}
