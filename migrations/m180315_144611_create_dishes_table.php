<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dishes`.
 */
class m180315_144611_create_dishes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dishes', [
            'id' => $this->primaryKey(),
			'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dishes');
    }
}
