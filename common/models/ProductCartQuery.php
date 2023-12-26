<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductCart]].
 *
 * @see ProductCart
 */
class ProductCartQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductCart[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductCart|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
