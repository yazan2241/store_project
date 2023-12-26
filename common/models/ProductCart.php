<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_cart".
 *
 * @property int $id
 * @property string $product_id
 * @property int $user_id
 * @property int|null $created_at
 *
 * @property Product $product
 * @property User $user
 */
class ProductCart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['product_id'], 'string', 'max' => 16],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'product_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductCartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCartQuery(get_called_class());
    }

    public function getImageSrc() {
        return Yii::$app->params['frontendUrl'] . 'storage/images/' .$this->product_id . '.jpg';
    }


}
