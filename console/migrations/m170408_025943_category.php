<?php

use yii\db\Migration;

class m170408_025943_category extends Migration
{
    public function up()
    {
      
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'cat_name' => $this->string()->notNull()->unique(),
            'parent_id' => $this->integer()->notNull(),            
        ], $tableOptions);
        

    }

    public function down()
    {
        echo "m170408_025943_category cannot be reverted.\n";

        return false;
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
