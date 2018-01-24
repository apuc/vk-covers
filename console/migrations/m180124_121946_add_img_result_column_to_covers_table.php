<?php

use yii\db\Migration;

/**
 * Handles adding img_result to table `covers`.
 */
class m180124_121946_add_img_result_column_to_covers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('covers', 'img_result', $this->string(255)->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('covers', 'img_result');
    }
}
