### yii2-related
Yii2 extenstions - relate the similar entities
[![Latest Stable Version](https://poser.pugx.org/porcelanosa/yii2-related/v/stable)](https://packagist.org/packages/porcelanosa/yii2-related)
[![Total Downloads](https://poser.pugx.org/porcelanosa/yii2-related/downloads)](https://packagist.org/packages/porcelanosa/yii2-related)
## Install 

```php
composer require porcelanosa/yii2-related
```
Run migration
```bash
$ php yii migrate/up --migrationPath=@vendor/porcelanosa/yii2-related/migrations
```

## Set Behavior
For model set Behavior

> **model_id_field_name** - field name of primary key 
> **model_name_field_name** - field name of Name model - for example, 'name' or 'title' 
> **post_name** - POST attribute for send data 
```php
public function behaviors()
{
    return [
        'relatedBehavior' => [
            'class' => RelatedBehavior::className(),
            'model_name' => $this::className(),
            'model_id_field_name' => 'id', 
            'model_name_field_name' => 'name',
            'post_name' => 'related_objects',
            'whereCondition' => 'deleted!=1' // Conditions for list of related entities
        ],
    ......
    ]
}    
```
## Use widget
In admin view:
```php
echo \porcelanosa\yii2related\RelatedWidget::widget(
    [
        'model'        => $model,
        'model_name'   => $model::className(),
        'behaviorName' => 'relatedBehavior',
        'title'        => 'Похожие модели',
        'placeholder'  => 'Выберите похожие модели ...',
    ]
);
```

## Usage
Get related models

```php
<?
use yii\helpers\Html;
$brand = Brands::findOne(1);
foreach($brand->related as $rel) { 
    echo Html::a($rel->name, $rel->slug); 
    echo '<br>';
}
?>
```