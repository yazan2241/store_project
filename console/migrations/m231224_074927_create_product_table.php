<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m231224_074927_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            
            'product_id' => $this->string(16)->notNull(),
            'title' => $this->string(512)->notNull(),
            'description' => $this->text(),
            'status' => $this->integer(1),
            'image_name' => $this->string(512),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
        ]);

        $this->addPrimaryKey('PK_product_id' , '{{%product}}' , 'product_id');

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-product-created_by}}',
            '{{%product}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product-created_by}}',
            '{{%product}}',
            'created_by',
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
            '{{%fk-product-created_by}}',
            '{{%product}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-product-created_by}}',
            '{{%product}}'
        );

        $this->dropTable('{{%product}}');
    }
}
