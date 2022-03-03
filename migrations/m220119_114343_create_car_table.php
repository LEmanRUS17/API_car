<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car}}`.
 */
class m220119_114343_create_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car}}', [
            'id'         => $this->primaryKey(),
            'title'      => $this->string()->notNull(),
            'decoration' => $this->text()->notNull(),
            'price'      => $this->float()->notNull(),
            'photo'      => $this->string()->notNull(),
            'contacts'   => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car}}');
    }
}
