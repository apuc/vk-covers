<?php

use yii\db\Migration;

/**
 * Handles the creation of table `covers`.
 */
class m180116_203236_create_covers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('covers', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'owner_id' => $this->integer(11)->notNull(),
            'title' => $this->string(255)->notNull(),
            'dt_add' => $this->integer(11)->defaultValue(null),
            'img' => $this->string(255)->defaultValue(null),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('covers');
    }
}
