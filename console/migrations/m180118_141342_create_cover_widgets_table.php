<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cover_widgets`.
 */
class m180118_141342_create_cover_widgets_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cover_widgets', [
            'id' => $this->primaryKey(),
            'cover_id' => $this->integer(11)->notNull(),
            'widget_name' => $this->string(255)->notNull(),
            'widget_rus_name' => $this->string(255)->notNull(),
            'widget_settings' => $this->text()->defaultValue(null),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cover_widgets');
    }
}
