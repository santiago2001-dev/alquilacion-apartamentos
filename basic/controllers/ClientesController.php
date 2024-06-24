<?php

namespace app\controllers;

use app\models\ClientesModel;
use yii\rest\ActiveController;
use Yii;
use yii\web\Response;


class ClientesController extends ActiveController
{
    public $modelClass = 'app\models\ClientesModel';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
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
    public function actionCreate(): array
    {

        try {
            $data = Yii::$app->request->post();

            $tratadoData = $this->tratarDatos($data);

            $model = new ClientesModel();
            $valid = $this->validacionEmail($tratadoData['email']);

            if (!$valid['isValid']) {
                Yii::$app->response->statusCode = 400;
                return [
                    'status' => 'error',
                    'message' => $valid['message'],
                ];
            }

            if ($model->load(['Clientes' => $tratadoData]) && $model->validate()) {
                if ($model->save()) {
                    Yii::$app->response->statusCode = 200;
                    return [
                        'status' => 'success',
                        'message' => 'Cliente creado de forma correcta'
                    ];
                } else {
                    Yii::$app->response->statusCode = 400;
                    return [
                        'status' => 'error',
                        'message' => 'Error al crear cliente'
                    ];
                }
            }

            Yii::$app->response->statusCode = 400;
            return [
                'status' => 'error',
                'message' => 'Datos inválidos',
                'errors' => $model->errors,
            ];
        } catch (\Exception $e) {
            \Yii::$app->response->statusCode = 500;
            return [
                'status' => 'error',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param string $email
     * 
     * @return array
     */
    public function validacionEmail(string $email): array
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !$email) {
            return [
                'isValid' => false,
                'message' => 'Formato de email no es válido',
            ];
        }

        $emails = ClientesModel::find()
            ->where(['email' => $email])
            ->asArray()
            ->all();

        if (!empty($emails)) {
            return [
                'isValid' => false,
                'message' => 'El email ya está registrado',
            ];
        }

        return [
            'isValid' => true,
            'message' => 'El email es válido',
        ];
    }



    /**
     * Tratamiento de los datos recibidos del JSON
     *
     * @param array $data
     * @return array
     */
    protected function tratarDatos(array $data): array
    {

        $data['email'] = trim(strtolower($data['email']));
        $data['nombre'] = trim(ucwords($data['nombre']));

        return $data;
    }
}
