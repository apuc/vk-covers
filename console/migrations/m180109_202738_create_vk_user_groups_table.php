<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vk_user_groups`.
 */
class m180109_202738_create_vk_user_groups_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('vk_user_groups', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'domain' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'owner_id' => $this->integer(11)->notNull(),
            'photo' => $this->string(255)->notNull(),
            'status' => 'tinyint(1) null default null',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('vk_user_groups');
    }
}
