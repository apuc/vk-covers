<?php

use yii\db\Migration;

/**
 * Handles adding members to table `vk_user_groups`.
 */
class m180113_123833_add_members_column_to_vk_user_groups_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('vk_user_groups', 'prod_count', $this->integer(5)->defaultValue(0));
        $this->addColumn('vk_user_groups', 'members_count', $this->integer(11)->defaultValue(0));
        $this->addColumn('vk_user_groups', 'last_update', $this->integer(11)->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('vk_user_groups', 'prod_count');
        $this->dropColumn('vk_user_groups', 'members_count');
        $this->dropColumn('vk_user_groups', 'last_update');
    }
}
