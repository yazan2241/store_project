<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property string $product_id
 * @property string $title
 * @property string|null $description
 * @property int|null $status
 * @property string|null $image_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 */
class Product extends \yii\db\ActiveRecord
{

    const STATUS_EMPTY = 0;
    const STATUS_FULL = 1;

    public $image;
    public $like = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product}}';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'title'], 'required'],
            [['description'], 'string'],
            [['status', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['product_id'], 'string', 'max' => 16],
            [['title', 'image_name'], 'string', 'max' => 512],
            [['product_id'], 'unique'],
            [['status'] , 'default' , 'value' => self::STATUS_FULL],
            ['image_name' , 'image' , 'extensions' => ['jpg']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'image_name' => 'Image Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductQuery(get_called_class());
    }


    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert = $this->isNewRecord;
        if ($isInsert) {
            $this->product_id = Yii::$app->security->generateRandomString(8);
            $this->title = $this->image->name;
            $this->image_name = $this->image->name;
        }
        $saved = parent::save($runValidation, $attributeNames);
        if (!$saved) {
            return false;
        }
        if ($isInsert) {
            $imagePath = Yii::getAlias('@frontend/web/storage/images/' . $this->product_id . '.jpg');
            if (!is_dir(dirname($imagePath))) {
                FileHelper::createDirectory(dirname($imagePath));
            }
            $this->image->saveAs($imagePath);
           
        }
        return true;
    }


    public function getImageSrc() {
        return Yii::$app->params['frontendUrl'] . 'storage/images/' .$this->product_id . '.jpg';
    }

    public function getStatusLabels(){
        return [
            self::STATUS_EMPTY => 'empty',
            self::STATUS_FULL => 'full'
        ];
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $imagePath = Yii::getAlias('@frontend/web/storage/images/' . $this->product_id . '.jpg');
        if(file_exists($imagePath))
            unlink($imagePath);
    }


}
