<?php

namespace frontend\controllers;

use common\models\Product;
use common\models\ProductCart;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class CartController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['like'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            // 'verb' => [
            //     'class' => VerbFilter::class,
            //     'actions' => [
            //         'like' => ['post'],
            //     ]
            // ]
        ];
    }
    
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductCart::find()->andWhere(['user_id' => Yii::$app->user->id])->joinWith(['product'])
        ]);
        
        return $this->render('index' , [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($product_id)
    {
        if (($model = ProductCart::findOne(['id' => $product_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
}
