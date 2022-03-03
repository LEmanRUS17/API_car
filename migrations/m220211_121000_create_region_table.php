<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%region}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%country}}`
 */
class m220211_121000_create_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%region}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
        ]);

        // creates index for column `country_id`
        $this->createIndex(
            '{{%idx-region-country_id}}',
            '{{%region}}',
            'country_id'
        );

        // add foreign key for table `{{%country}}`
        $this->addForeignKey(
            '{{%fk-region-country_id}}',
            '{{%region}}',
            'country_id',
            '{{%country}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%country}}`
        $this->dropForeignKey(
            '{{%fk-region-country_id}}',
            '{{%region}}'
        );

        // drops index for column `country_id`
        $this->dropIndex(
            '{{%idx-region-country_id}}',
            '{{%region}}'
        );

        $this->dropTable('{{%region}}');
    }
}
