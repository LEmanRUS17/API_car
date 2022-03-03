<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_option}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%car}}`
 * - `{{%option}}`
 */
class m220127_060539_create_car_option_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_option}}', [
            'car_id' => $this->integer()->notNull(),
            'option_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `car_id`
        $this->createIndex(
            '{{%idx-car_option-car_id}}',
            '{{%car_option}}',
            'car_id'
        );

        // add foreign key for table `{{%car}}`
        $this->addForeignKey(
            '{{%fk-car_option-car_id}}',
            '{{%car_option}}',
            'car_id',
            '{{%car}}',
            'id',
            'CASCADE'
        );

        // creates index for column `option_id`
        $this->createIndex(
            '{{%idx-car_option-option_id}}',
            '{{%car_option}}',
            'option_id'
        );

        // add foreign key for table `{{%option}}`
        $this->addForeignKey(
            '{{%fk-car_option-option_id}}',
            '{{%car_option}}',
            'option_id',
            '{{%option}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%car}}`
        $this->dropForeignKey(
            '{{%fk-car_option-car_id}}',
            '{{%car_option}}'
        );

        // drops index for column `car_id`
        $this->dropIndex(
            '{{%idx-car_option-car_id}}',
            '{{%car_option}}'
        );

        // drops foreign key for table `{{%option}}`
        $this->dropForeignKey(
            '{{%fk-car_option-option_id}}',
            '{{%car_option}}'
        );

        // drops index for column `option_id`
        $this->dropIndex(
            '{{%idx-car_option-option_id}}',
            '{{%car_option}}'
        );

        $this->dropTable('{{%car_option}}');
    }
}
