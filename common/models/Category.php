<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $cat_name
 * @property integer $parent_id
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['parent_id'], 'integer'],
            [['cat_name'], 'string', 'max' => 255],
            [['cat_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => '分类名',
            'parent_id' => '父级ID',
        ];
    }
    

    public function getParentNames()
    {
        $sql='select * from Category';
        $data=Category::findBySql($sql)->asArray()->all();
        $res=$this->trees($data);
        if(empty($res)){
          return [];
        }
        $res=ArrayHelper::map($res,'id','cat_name');        
        return $res;
    }

    public function trees($date,&$res=array(),$pid=0,$level=0)
    {        
        if(!is_array($date) || empty($date)){
          return [];
        }
        $level=$level+1; 
        foreach ($date as $key => $value) {
            if($value['parent_id']==$pid){
               if($value['parent_id']!=0){                   
                   $value['cat_name']=str_repeat('----/',$level).$value['cat_name'];
               }
               $res[]=$value;                  
               $this->trees($date,$res,$value['id'],$level);
            }            
        }

        return $res;
    }

}
