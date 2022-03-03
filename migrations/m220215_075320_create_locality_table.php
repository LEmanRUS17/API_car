<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%locality}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%region}}`
 */
class m220215_075320_create_locality_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%locality}}', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
        ]);

        // creates index for column `region_id`
        $this->createIndex(
            '{{%idx-locality-region_id}}',
            '{{%locality}}',
            'region_id'
        );

        // add foreign key for table `{{%region}}`
        $this->addForeignKey(
            '{{%fk-locality-region_id}}',
            '{{%locality}}',
            'region_id',
            '{{%region}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%region}}`
        $this->dropForeignKey(
            '{{%fk-locality-region_id}}',
            '{{%locality}}'
        );

        // drops index for column `region_id`
        $this->dropIndex(
            '{{%idx-locality-region_id}}',
            '{{%locality}}'
        );

        $this->dropTable('{{%locality}}');
    }
}
