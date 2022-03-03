<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%car}}`
 */
class m220215_042552_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'photo' => $this->string()->notNull(),
            'car_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `car_id`
        $this->createIndex(
            '{{%idx-image-car_id}}',
            '{{%image}}',
            'car_id'
        );

        // add foreign key for table `{{%car}}`
        $this->addForeignKey(
            '{{%fk-image-car_id}}',
            '{{%image}}',
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
        // drops foreign key for table `{{%car}}`
        $this->dropForeignKey(
            '{{%fk-image-car_id}}',
            '{{%image}}'
        );

        // drops index for column `car_id`
        $this->dropIndex(
            '{{%idx-image-car_id}}',
            '{{%image}}'
        );

        $this->dropTable('{{%image}}');
    }
}
