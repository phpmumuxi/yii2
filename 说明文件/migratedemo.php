<?php
//1、./yii migrate xxx_xx
//在表中插入某字段 ：

public function up()
    {$this->addColumn('{{application_service}}', 'auditor', 'INT(10) NOT NULL COMMENT "审核人" AFTER 'user_id', CHANGE COLUMN `status` `status` tinyint(4) NOT NULL COMMENT "绑定状态，0：解绑 1：绑定" AFTER 'auditor'');}

//修改表中某字段：

public function up()
    {$this->alterColumn('{{application_service}}', 'status', 'SMALLINT(4) NOT NULL DEFAULT 0 COMMENT       "绑定状态，0：解绑 1：未绑定 2:审核中 3:审核通过 4:审核拒绝 5：禁用"');}

//增加索引：

public function up()
    //$this->createIndex('索引名称','字段所在表',['要索引的字段'], 是否唯一);
    {$this->createIndex('created_at', "{{app_base}}", ['created_at'],true); }

//创建数据表：

public function up()
{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
          $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="菜单表"';
        }
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11)->defaultValue(0)->comment('父级菜单id'),
            'menu_name' => $this->string(100)->notNull()->comment('菜单名称'),
            'menu_type' => $this->string(100)->notNull()->comment('菜单类型(menu菜单，sub_menu子菜单)'),
            'menu_action' => $this->string(100)->notNull()->comment('菜单链接'),
            'menu_roles' => $this->string(100)->comment('角色'),
            'menu_depth' => $this->smallInteger(1)->defaultValue(0)->comment('菜单深度'),
            'menu_icon' => $this->text()->comment('ICON代码：图标'),
            'menu_des' => $this->text()->comment('菜单简介'),
            'menu_order' => $this->smallInteger(1)->defaultValue(0)->comment('显示顺序'),
            'menu_show' => $this->smallInteger(1)->defaultValue(0)->comment('是否显示（0：显示， 1：不显示）'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
}

//删除某字段：

public function down()
    {$this->dropColumn('{{app_base}}', 'manager_id');}

//删除某张表：

public function down()
    {$this->dropTable('{{%file_storage_item}}');}

/*
2./yii migrate 默认执行 ./yii migrate/up
./yii migrate/down 执行某些撤销对表的操作
./yii migratre/to （迁移文件名）执行某个指定的迁移文件
在创建数据表的过程中可以同时声称多张表，删除多张表
执行过的迁移文件，会在数据库的migration 中生成一条记录，记录此迁移文件已经执行过，下次将执行数据表中不存在的迁移文件
注意：
./yii migrate/down 此命令执行不只删除了对数据库的操作同时也会删除migration数据表中的执行记录*/