<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%car}}`.
 */
class m220215_121740_drop_photo_column_from_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%car}}', 'photo');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%car}}', 'photo', $this->string());
    }
}
