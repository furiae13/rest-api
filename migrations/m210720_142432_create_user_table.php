<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210720_142432_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->null(),
            'status' => $this->smallInteger(6)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()'),
            'verification_token' =>  $this->string()->null(),
        ]);

        $this->createIndex(
            'email',
            'user',
            'email'
        );

        $this->createIndex(
            'password_reset_token',
            'user',
            'password_reset_token'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('email', 'user');
        $this->dropIndex('password_reset_token', 'user');
        $this->dropTable('user');
    }
}
