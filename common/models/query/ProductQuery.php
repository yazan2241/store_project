<?php

namespace common\models\query;

use common\models\Product;

/**
 * This is the ActiveQuery class for [[\common\models\Product]].
 *
 * @see \common\models\Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function creator($userId){
        return $this->andWhere(['created_by' => $userId]);
    }

    public function latest(){
        return $this->orderBy(['created_at' => SORT_DESC]);
    }

    public function full(){
        return $this->andWhere(['status' => Product::STATUS_FULL]);
    }
}
