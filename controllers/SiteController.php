<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\StoreSchedule;
use app\models\Store;

/**
 * Site Controller.
 *
 * @author Yukal Alexander <yukal.alexander@gmail.com>
 * @link https://github.com/yukal/
 * @copyright 2018 MIT
 * @license https://opensource.org/licenses/MIT
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            // declares "view" action using a configuration array
            'view' => [
                'class' => 'yii\web\ViewAction',
                'viewPrefix' => '',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $queryAttributes = isset(Yii::$app->request->queryParams['StoreSchedule'])
            ? Yii::$app->request->queryParams['StoreSchedule'] : [];

        $modelParams = [
            'attributes' => $queryAttributes,
            'scenario' => StoreSchedule::SCENARIO_SEARCH
        ];

        $model = new StoreSchedule($modelParams);
        $dataProvider = $model->search();

        return $this->render('//index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

}
