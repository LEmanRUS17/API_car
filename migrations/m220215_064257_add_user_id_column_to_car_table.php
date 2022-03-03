<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%car}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220215_064257_add_user_id_column_to_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%car}}', 'user_id', $this->integer());

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-car-user_id}}',
            '{{%car}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-car-user_id}}',
            '{{%car}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-car-user_id}}',
            '{{%car}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-car-user_id}}',
            '{{%car}}'
        );

        $this->dropColumn('{{%car}}', 'user_id');
    }
}
