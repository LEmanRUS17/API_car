<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%car}}`.
 */
class m220215_121825_drop_contacts_column_from_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%car}}', 'contacts');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%car}}', 'contacts', $this->string());
    }
}
