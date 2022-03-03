<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%car}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%locality}}`
 */
class m220215_075326_add_locality_column_to_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%car}}', 'locality', $this->integer());

        // creates index for column `locality`
        $this->createIndex(
            '{{%idx-car-locality}}',
            '{{%car}}',
            'locality'
        );

        // add foreign key for table `{{%locality}}`
        $this->addForeignKey(
            '{{%fk-car-locality}}',
            '{{%car}}',
            'locality',
            '{{%locality}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%locality}}`
        $this->dropForeignKey(
            '{{%fk-car-locality}}',
            '{{%car}}'
        );

        // drops index for column `locality`
        $this->dropIndex(
            '{{%idx-car-locality}}',
            '{{%car}}'
        );

        $this->dropColumn('{{%car}}', 'locality');
    }
}
