1、在yii批处理文件所在目录下执行
$ yii migrate/create init_services_table
2、执行完成后，会在console/migrations目录下生成名为*init_services_table.php的文件
修改文件
$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
 // utf8_unicode_ci 改为 utf8_general_ci 
3、执行migration命令，会在对应数据库中创建该表。
yii migrate