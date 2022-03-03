<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_car}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%car}}`
 */
class m220214_073323_create_user_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_car}}', [
            'user_id' => $this->integer()->notNull(),
            'car_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_car-user_id}}',
            '{{%user_car}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_car-user_id}}',
            '{{%user_car}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `car_id`
        $this->createIndex(
            '{{%idx-user_car-car_id}}',
            '{{%user_car}}',
            'car_id'
        );

        // add foreign key for table `{{%car}}`
        $this->addForeignKey(
            '{{%fk-user_car-car_id}}',
            '{{%user_car}}',
            'car_id',
            '{{%car}}',
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
            '{{%fk-user_car-user_id}}',
            '{{%user_car}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_car-user_id}}',
            '{{%user_car}}'
        );

        // drops foreign key for table `{{%car}}`
        $this->dropForeignKey(
            '{{%fk-user_car-car_id}}',
            '{{%user_car}}'
        );

        // drops index for column `car_id`
        $this->dropIndex(
            '{{%idx-user_car-car_id}}',
            '{{%user_car}}'
        );

        $this->dropTable('{{%user_car}}');
    }
}
