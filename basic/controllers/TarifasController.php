<?php

namespace app\controllers;


use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\Cors;


class TarifasController extends ActiveController
{

    public $modelClass = 'app\models\TipoTarifasModel';




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
}
