<?php

use yii\db\Migration;

class m170412_010904_brand extends Migration
{
    public function up()
    {
       $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%brand}}', [
            'id' => $this->primaryKey(),
            'brand_name' => $this->string()->notNull()->unique(),
            'brand_img' => $this->string(64)->notNull(),
            'brand_smallimg' => $this->string(64)->notNull(),  
        ], $tableOptions);

    }

    public function down()
    {
        echo "m170412_010904_brand cannot be reverted.\n";

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
