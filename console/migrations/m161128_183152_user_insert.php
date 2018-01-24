<?php

use yii\db\Migration;

class m161128_183152_user_insert extends Migration
{
    public function up()
    {
        $this->insert('user',
            [
                'id' => 1,
                'username' =>  'admin',
                'email' => 'admin@admin.ru',
                'password_hash' => '$2y$12$Qj1MzU/j3OFeTLb5U.d4veVIRHdmzYovEaH4F58wXQujXVGdjcV7u',
                'auth_key' => '$2y$12$E3NBtaTvpLo1EzUQtLTlJuZon',
                'confirmed_at' => '1459498710',
                'created_at' => '1459498710',
                'updated_at' => '1459498710',
                'flags' => 0,
            ]);

        $this->insert('auth_item',
            [
                'name' => 'admin',
                'type' => 1,
            ]);


        $this->insert('auth_assignment',
            [
                'item_name' => 'admin',
                'user_id' => 1,
            ]);
    }

    public function down()
    {
        /*$this->truncateTable('social_account');
        $this->truncateTable('user');*/
        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
