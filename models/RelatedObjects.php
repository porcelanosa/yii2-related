<?php

namespace porcelanosa\yii2related\models;

use Yii;

/**
 * This is the model class for table "related_objects".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property integer $related_id
 * @property integer $sort
 */
class RelatedObjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'related_objects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'related_id', 'sort'], 'integer'],
            [['model'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model ID'),
            'related_id' => Yii::t('app', 'Related ID'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * @inheritdoc
     * @return \porcelanosa\yii2related\models\query\RelatedObjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \porcelanosa\yii2related\models\query\RelatedObjectsQuery(get_called_class());
    }
}
