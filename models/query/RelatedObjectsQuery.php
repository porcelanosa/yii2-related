<?php

namespace porcelanosa\yii2related\models\query;

/**
 * This is the ActiveQuery class for [[\porcelanosa\yii2related\models\RelatedObjects]].
 *
 * @see \porcelanosa\yii2related\models\RelatedObjects
 */
class RelatedObjectsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \porcelanosa\yii2related\models\RelatedObjects[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \porcelanosa\yii2related\models\RelatedObjects|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
