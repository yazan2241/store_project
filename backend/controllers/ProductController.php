<?php

namespace backend\controllers;

use common\models\product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\DbManager;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for product model.
 */
class ProductController extends Controller
{

    public $FRONT_END_URL = '';
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@']
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!$this->checkRole()) {
            Yii::$app->user->logout();
            return $this->redirect($this->FRONT_END_URL);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => product::find()->creator(Yii::$app->user->id)->latest(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'product_id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single product model.
     * @param string $product_id Product ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($product_id)
    {
        if (!$this->checkRole()) {
            Yii::$app->user->logout();
            return $this->redirect($this->FRONT_END_URL);
        }
        return $this->render('view', [
            'model' => $this->findModel($product_id),
        ]);
    }

    /**
     * Creates a new product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!$this->checkRole()) {
            Yii::$app->user->logout();
            return $this->redirect($this->FRONT_END_URL);
        }
        $model = new product();
        $model->image = UploadedFile::getInstanceByName('image');


        if ($this->request->isPost) {
            if ($model->save()) {
                return $this->redirect(['update', 'product_id' => $model->product_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $product_id Product ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($product_id)
    {
        if (!$this->checkRole()) {
            Yii::$app->user->logout();
            return $this->redirect($this->FRONT_END_URL);
        }
        $model = $this->findModel($product_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $product_id Product ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($product_id)
    {
        if (!$this->checkRole()) {
            Yii::$app->user->logout();
            return $this->redirect($this->FRONT_END_URL);
        }

        $this->findModel($product_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $product_id Product ID
     * @return product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id)
    {
        if (($model = product::findOne(['product_id' => $product_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // public function beforeAction($action)
    // {
    //     // action-specific
    //     if (in_array($action->id, ['not', 'allowed', 'actions']))
    //         Yii::$app->user->loginUrl = ["controller/product"];

    //     // controller-wide
    //     Yii::$app->user->loginUrl = '';

    //     if (!parent::beforeAction($action)) {
    //         return false;
    //     }

    //     return true;
    // }

    public function checkRole()
    {
        if (Yii::$app->user->isGuest) return false;
        $auth = new DbManager();
        $getRolesByUser = $auth->getRolesByUser(Yii::$app->user->getId());
        $Role = array_keys($getRolesByUser)[0];
        if ($Role == 'admin') return true;
        else return false;
    }
}
