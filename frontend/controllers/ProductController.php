<?php

namespace frontend\controllers;

use common\models\Product;
use common\models\ProductCart;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ProductController extends \yii\web\Controller
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
        

        $products = Product::find()
        ->full()
        ->latest();


        $dataProvider = new ActiveDataProvider([
            'query' => $products
        ]);

        foreach(array_values($dataProvider->getModels()) as $index => $product){

            $like = ProductCart::find()
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['product_id' => $product->product_id])
            ->all();
    
            $product->like = sizeof($like);
        }
        
        return $this->render('index' , [
            'dataProvider' => $dataProvider
        ]);
        }  


    public function actionLike($id)
    {
        

        $product = $this->findProduct($id);
        $userId = Yii::$app->user->id;
        $productCart = new ProductCart();
        $productCart->product_id = $id;
        $productCart->user_id = $userId;
        $productCart->created_at = time();
        if($productCart->save()){
            return "<span class='added-to-cart'>Added</span>";
        }else{

        }
    }

    protected function findProduct($id)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException("Product not found");
        }
        return $product;
    }
    

}
