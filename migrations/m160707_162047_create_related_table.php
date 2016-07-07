<?php

use yii\db\Migration;

/**
 * Handles the creation for table `related`.
 */
class m160707_162047_create_related_table extends Migration
{
	
    /**
     * @inheritdoc
     */
    public function up()
    {
	    $tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		    $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
	    }
        $this->createTable('{{%related_objects}}', [
            'id' => $this->primaryKey(),
            'model' => $this->string(255),
            'model_id' => $this->integer(),
            'related_id' => $this->integer(),
            'sort' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%related_objects}}');
    }
}
