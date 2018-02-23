<?php

use app\models\Store;

/* @var $this yii\web\View */

$this->title = 'Search store';
?>
<div class="site-index">
    <div class="body-content">

        <?= yii\grid\GridView::widget([
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
        ]); ?>

    </div>
</div>
