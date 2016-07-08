### yii2-related
Yii2 extenstions - relate the similar entities

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
```php
'relatedBehavior' => [
    'class' => RelatedBehavior::className(),
    'model_name' => $this::className(),
    'model_id_field_name' => 'id', 
    'model_name_field_name' => 'name'
],
```
## Use widget
In admin view:
```php
echo \porcelanosa\yii2related\RelatedWidget::widget(
            [
                'model'        => $model,
                'model_name'        => $model::className(),
                'behaviorName' => 'RelatedBehavior',
                'title'        => 'Похожие модели',
                'placeholder'  => 'Выберите похожие модели ...',
            ]
        );
```