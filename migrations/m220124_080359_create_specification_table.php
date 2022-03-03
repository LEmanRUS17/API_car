<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%specifications}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%car}}`
 */
class m220124_080359_create_specification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%specification}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer()->notNull(),
            'brand' => $this->string()->notNull(),
            'model' => $this->string()->notNull(),
            'year_of_issue' => $this->integer(),
            'body' => $this->string(),
            'mileage' => $this->integer(),
        ]);

        // creates index for column `car_id`
        $this->createIndex(
            '{{%idx-specification-car_id}}',
            '{{%specification}}',
            'car_id'
        );

        // add foreign key for table `{{%car}}`
        $this->addForeignKey(
            '{{%fk-specification-car_id}}',
            '{{%specification}}',
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
            '{{%fk-specification-car_id}}',
            '{{%specification}}'
        );

        // drops index for column `car_id`
        $this->dropIndex(
            '{{%idx-specification-car_id}}',
            '{{%specification}}'
        );

        $this->dropTable('{{%specification}}');
    }
}
