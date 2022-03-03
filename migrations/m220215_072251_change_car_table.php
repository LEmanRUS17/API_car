<?php

use yii\db\Migration;

/**
 * Class m220215_072251_change_car_table
 */
class m220215_072251_change_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('car', 'contacts', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('car', 'contacts', $this->string()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220215_072251_change_car_table cannot be reverted.\n";

        return false;
    }
    */
}
