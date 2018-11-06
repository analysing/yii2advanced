<?php

use yii\db\Migration;

/**
 * Class m181105_111718_db_bak
 */
class m181105_111718_db_bak extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{sys_user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(20)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'character set utf8 collate utf8_unicode_ci engine innodb');
        $this->insert('{{sys_user}}', [
            'username' => 'admin',
            'auth_key' => 'Em0xFnOQf9llmoOhPEo3NlrpWaslaLi4',
            'password_hash' => '$2y$13$L74FFcJkefxiQLENmo3Ip.lQQsWukuwxBtBX.7qydWw45t1PlDxHm',
            'email' => 'admin@admin.com',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{sys_user}}', 'id = 1');
        $this->dropTable('{{sys_user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181105_111718_db_bak cannot be reverted.\n";

        return false;
    }
    */
}
