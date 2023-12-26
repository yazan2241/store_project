<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_cart}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 * - `{{%user}}`
 */
class m231224_202715_create_product_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_cart}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->string(16)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(11),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-product_cart-product_id}}',
            '{{%product_cart}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-product_cart-product_id}}',
            '{{%product_cart}}',
            'product_id',
            '{{%product}}',
            'product_id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-product_cart-user_id}}',
            '{{%product_cart}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product_cart-user_id}}',
            '{{%product_cart}}',
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
        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-product_cart-product_id}}',
            '{{%product_cart}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-product_cart-product_id}}',
            '{{%product_cart}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-product_cart-user_id}}',
            '{{%product_cart}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-product_cart-user_id}}',
            '{{%product_cart}}'
        );

        $this->dropTable('{{%product_cart}}');
    }
}
