<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_info}}`.
 */
class m210720_142534_create_user_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_info', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'phone_number' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'first_name',
            'user_info',
            'first_name'
        );

        $this->createIndex(
            'last_name',
            'user_info',
            'last_name'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('user_id', 'user_info');
        $this->dropIndex('first_name', 'user_info');
        $this->dropIndex('last_name', 'user_info');
        $this->dropTable('user_info');
    }
}
