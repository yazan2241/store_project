<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
        // add "createProduct" permission
        $createProduct = $auth->createPermission('createProduct');
        $createProduct->description = 'Create a Product';
        $auth->add($createProduct);

        // add "updateProduct" permission
        $updateProduct = $auth->createPermission('updateProduct');
        $updateProduct->description = 'Update Product';
        $auth->add($updateProduct);

        // Persmission to view asset
        $viewProduct = $auth->createPermission('viewProduct');
        $viewProduct->description = 'View Products';
        $auth->add($viewProduct);

        // add "author" role and give this role the "createProduct" permission
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $viewProduct);

        // add "admin" role and give this role the "updateProduct" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createProduct);
        $auth->addChild($admin, $updateProduct);
        $auth->addChild($admin, $viewProduct);
        $auth->addChild($admin, $user);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }
}