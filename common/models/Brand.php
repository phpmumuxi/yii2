<?php

namespace common\models;

use Yii;
use yii\imagine\Image;
/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $brand_name
 * @property string $brand_img
 * @property string $brand_smallimg
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_name'], 'required'],
            [['brand_name'], 'string', 'max' => 255],
            [['brand_img'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpeg, png, jpg, gif, bmp'],
            ['brand_name', 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_name' => '品牌名称',
            'brand_img' => '品牌logo',
            'brand_smallimg' => '小图片',
        ];
    }

    public function uploadImg($thumb='false',$file='')
    {
        $res=[];
        $_file = '/uploads/'.date('Y-m-d',time()) ;
        $path  = ($file=='')?$_file:$file;
        $_path = $path.'/'.'upload_' .rand(1,1000).time().$this->brand_img->baseName . '.' . $this->brand_img->extension;
        $this->createDir(dirname(Yii::getAlias('@common').$_path));
        $this->brand_img->saveAs(Yii::getAlias('@common').$_path);
        $res['path']=$_path;        
        if ($thumb) {
          $thumb_path = $path.'/'.rand(1,1000).time().'thumb_' .$this->brand_img->baseName . '.' . $this->brand_img->extension;          
          $thumb=Image::thumbnail(Yii::getAlias('@common').$_path, 120, 120)->save(Yii::getAlias('@common').$thumb_path, ['quality' => 100]);
           $res['thumb_path']=$thumb_path;                     
        } 
        return $res;
    }

    public function createDir($path)
    {
         if (!file_exists($path)){
            $this->createDir(dirname($path));
            mkdir($path, 0777);
        } 
    }

}
