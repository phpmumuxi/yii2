<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use backend\models\search\CategorySearch;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {           
        $model = new Category(); 
        if (Yii::$app->request->isPost)  { 
           $data= Yii::$app->request->post("Category");           
           $data['parent_id']=$data['parent_id']==''?0:$data['parent_id'];           
          if ($model->load($data, '') && $model->save()) {      
               return $this->redirect(['view', 'id' => $model->id]);
           }else {
                $this->error('添加失败',['category/create']);
           }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost)  {            
            $data= Yii::$app->request->post("Category");
            $_model=Category::findOne(['parent_id'=>$id]);        
            if($_model){
                if($data['parent_id']!=$model['parent_id']){
                    $this->error('该分类下有子集分类，不能修改其父级分类，只能修改名称',['category/update']);
                }else{
                   if ($model->load($data,'') && $model->save()) {                  
                       return $this->redirect(['view', 'id' => $model->id]);
                   }else{

                       $this->error('修改失败',['category/update','id' => $model->id]);
                   }
                }
            }else{                
                 if ($model->load($data,'') && $model->save()) {
                     return $this->redirect(['view', 'id' => $model->id]);
                }else{
                       $this->error('修改失败',['category/update','id' => $model->id]);
                }
            }               
        
        } else {            
            return $this->render('update', [
                'model' => $model,                
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=Category::findOne(['parent_id'=>$id]);        
        if($model){
           $this->error('该分类下有子集分类，不能删除',['category/index']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
