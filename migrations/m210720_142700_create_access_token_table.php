<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%access_token}}`.
 */
class m210720_142700_create_access_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('access_token', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'consumer' => $this->string()->null(),
            'token' => $this->string()->notNull(),
            'access_given' => $this->text()->null(),
            'used_at' => $this->integer()->null(),
            'expire_at' => $this->integer()->null(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()'),
        ]);

        $this->createIndex(
            'token',
            'access_token',
            'token'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('token', 'access_token');
        $this->dropTable('access_token');
    }
}
