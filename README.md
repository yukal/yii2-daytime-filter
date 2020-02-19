# yii2-daytime-widget-filter
Day and Time filter

<img src="https://image.ibb.co/gCexNc/2018_02_20_17_05_16.png" width="500">

## Directories structure
    controllers/         Controllers directory
    models/              Models directory
    views/               Views directory
    LICENSE              License contents
    README.md            Presentation

## Database structure

```sql
CREATE TABLE `store` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
  PRIMARY KEY (`id`)
);

CREATE TABLE `store_schedule` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `owner_id` INT(11) NOT NULL,
  `open` TIME NOT NULL DEFAULT '09:00:00',
  `close` TIME NOT NULL DEFAULT '18:00:00',
  `days_mask` SMALLINT(1) NOT NULL DEFAULT '64',
  PRIMARY KEY (`id`),
  INDEX `owner_id` (`owner_id`),
  INDEX `open` (`open`),
  INDEX `close` (`close`),
  INDEX `days_mask` (`days_mask`)
);
```

## Search
```php
$queryAttributes = isset(Yii::$app->request->queryParams['StoreSchedule'])
    ? Yii::$app->request->queryParams['StoreSchedule'] : [];

$modelParams = [
    'attributes' => $queryAttributes,
    'scenario' => StoreSchedule::SCENARIO_SEARCH
];

$model = new StoreSchedule($modelParams);
$dataProvider = $model->search();
```

## Widget filter
```php
yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => [
        [
            'attribute' => 'owner_id',
        ], [
            'attribute' => 'name',
        ], [
            'attribute' => 'open',
            'format' => ['time', 'short'],
        ], [
            'attribute' => 'close',
            'format' => ['time', 'short'],
        ], [
            'attribute' => 'days_mask',
            'value' => 'schedule',
            'filter' => $model->attributeDays,
        ],
    ],
]);
```

## Add records
```php
$model = new StoreSchedule();
$model->addSchedule($storeId, $storeOpen, $storeClose, $daysMask);

$model->addSchedule(17, '08:45', '20:00', Store::ON_WORKDAYS);
$model->addSchedule(17, '10:00', '16:30', Store::ON_WEEKENDS);

$model->addSchedule(20, '07:15', '18:00', Store::ON_WHOLEWEEK);
```
