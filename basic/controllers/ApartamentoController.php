<?php

namespace app\controllers;

use app\models\ApartamentosModel;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

class ApartamentoController extends ActiveController
{
    public $modelClass = 'app\models\ApartamentosModel';


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }




    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }
    /**
     * @return array
     */
    public function actionIndex(): array
    {
        try {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $queryParams = Yii::$app->request->queryParams;
            $query = ApartamentosModel::find()
                ->with(['ciudad', 'tarifa']);
    
            if (isset($queryParams['ciudad']) && !empty($queryParams['ciudad'])) {
                $query->joinWith(['ciudad'])
                    ->andWhere([
                        'OR',
                        ['=', 'ciudades.nombre', $queryParams['ciudad']],
                        ['LIKE', 'ciudades.nombre', '%' . $queryParams['ciudad'] . '%', false],
                    ]);
            }
    
            Yii::$app->response->statusCode = 200;
            return [
                'status' => 'success',
                'data' => $query->asArray()->all()
            ];
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return [
                'status' => 'error',
                'error' => $e->getMessage(),
            ];
        }
    }
    
}
