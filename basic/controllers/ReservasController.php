<?php

namespace app\controllers;

use app\models\ApartamentosModel;
use app\models\ReservasModel;
use yii\rest\ActiveController;
use Yii;
use yii\web\Response;

class ReservasController extends ActiveController
{
    public $modelClass = 'app\models\ReservasModel';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['index']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
    
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:4200'], // Cambia esto al origen permitido
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Allow-Headers' => ['Content-Type', 'Authorization'],
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                'Access-Control-Max-Age' => 3600,
            ],
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
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $query = ReservasModel::find()
                ->with(['apartamento', 'cliente']);

            return [
                'status' => 'success',
                'data' => $query->asArray()->all()
            ];
        } catch (\Exception $e) {
            \Yii::$app->response->statusCode = 500;
            return [
                'status' => 'error',
                'message' => 'An error occurred while fetching the data.',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * @return array
     */
    public function actionCreate(): array
    {
        try {
            $data = Yii::$app->request->post();

            if (empty($data['apartamento']) || empty($data['fecha_inicio']) || empty($data['fecha_fin'])) {
                Yii::$app->response->statusCode = 400;
                return [
                    'status' => 'error',
                    'message' => 'Los campos apartamento, fecha_inicio y fecha_fin son requeridos.',
                ];
            }


            if (!$this->validarDisponibilidadFechas($data)) {
                Yii::$app->response->statusCode = 400;
                return [
                    'status' => 'error',
                    'message' => 'Las fechas seleccionadas no están disponibles para el apartamento especificado.',
                ];
            }

            $resultado = $this->asginarValor($data);

            if ($resultado['status'] === 'error') {
                return $resultado;
            }

            $reserva = new ReservasModel();
            $reserva->id_reserva =  $this->generarStringAleatorio();
            $reserva->apartamento = $data['apartamento'];
            $reserva->fecha_inicio = $data['fecha_inicio'];
            $reserva->fecha_fin = $data['fecha_fin'];
            $reserva->alquiler =  $resultado['alquiler'];
            $reserva->tasa_servicio = $resultado['tasa_servicio'];
            $reserva->cliente = $data['cliente'];


            if ($reserva->save()) {
                Yii::$app->response->statusCode = 201;
                return array_merge([
                    'status' => 'success',
                    'message' => 'Reserva creada de forma correcta'
                ], $resultado);
            } else {
                Yii::$app->response->statusCode = 400;
                return [
                    'status' => 'error',
                    'message' => 'Error al crear la reserva',
                    'errors' => $reserva->errors,
                ];
            }
        } catch (\Exception $e) {
            \Yii::$app->response->statusCode = 500;
            return [
                'status' => 'error',
                'message' => 'An error occurred while fetching the data.',
                'error' => $e->getMessage(),
            ];
        }
    }


    /**
     * @param array $data
     * @return array
     */
    public function asginarValor(array $data)
    {
        $apartamento = ApartamentosModel::find()
            ->where(['id_apartamento' => $data['apartamento']])
            ->with('tarifa')
            ->asArray()
            ->one();

        if (empty($apartamento)) {
            \Yii::$app->response->statusCode = 404;
            return [
                'status' => 'error',
                'message' => 'Apartamento no encontrado',
            ];
        }

        if (!isset($apartamento['tarifa']) || empty($apartamento['tarifa'])) {
            \Yii::$app->response->statusCode = 400;
            return [
                'status' => 'error',
                'message' => 'El apartamento no tiene definida la tarifa',
            ];
        }

        $tarifa = $apartamento['tarifa'];

        if (!isset($tarifa['id_tipo_tarifa']) || !isset($tarifa['valor_tarifa'])) {
            \Yii::$app->response->statusCode = 400;
            return [
                'status' => 'error',
                'message' => 'La tarifa del apartamento no tiene definidos el ID de tarifa o el valor de tarifa',
            ];
        }

        $idTarifa = $apartamento['tipo_apartamento'];
        $valorTarifa = $tarifa['valor_tarifa'];

        $dias = $this->calcularDias($data);


        switch ($idTarifa) {
            case 1: // Corporativo
                if ($dias < 30) {
                    \Yii::$app->response->statusCode = 400;
                    return [
                        'status' => 'error',
                        'message' => 'Escogiste un apartamento corporativo, la reserva debe ser de mínimo un mes',
                    ];
                }
                $alquiler = $valorTarifa * $dias;
                $tasaServicio = $alquiler * 0.03;
                return [
                    'status' => 'success',
                    'alquiler' => $alquiler,
                    'tasa_servicio' => $tasaServicio,
                ];
                break;

            case 2: // Turístico
                $alquiler = $valorTarifa * $dias;
                $tasaReserva = 150;
                return [
                    'status' => 'success',
                    'alquiler' => $alquiler,
                    'tasa_reserva' => $tasaReserva,
                ];
                break;

            default: // Tipo de tarifa desconocido
                \Yii::$app->response->statusCode = 400;
                return [
                    'status' => 'error',
                    'message' => 'Tipo de tarifa desconocido',
                ];
                break;
        }
    }


    /**
     * Calcula la diferencia en días entre dos fechas
     *
     * @param array $data
     * @return int
     */
    private function calcularDias(array $data): int
    {
        $fechaInicio = new \DateTime($data['fecha_inicio']);
        $fechaFin = new \DateTime($data['fecha_fin']);
        $interval = $fechaInicio->diff($fechaFin);
        return $interval->days;
    }



    /**
     * @param int $length
     * 
     * @return string
     */
    function generarStringAleatorio($length = 4): string
    {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }


    /**
     * @param array $data
     * 
     * @return bool
     */
    private function validarDisponibilidadFechas(array $data): bool
    {
        $fechaInicio = new \DateTime($data['fecha_inicio']);
        $fechaFin = new \DateTime($data['fecha_fin']);

        $query = ReservasModel::find()
            ->where(['apartamento' => $data['apartamento']])
            ->andWhere([
                'or',
                ['and', ['<=', 'fecha_inicio', $fechaInicio->format('Y-m-d')], ['>=', 'fecha_fin', $fechaInicio->format('Y-m-d')]],
                ['and', ['<=', 'fecha_inicio', $fechaFin->format('Y-m-d')], ['>=', 'fecha_fin', $fechaFin->format('Y-m-d')]],
                ['and', ['>=', 'fecha_inicio', $fechaInicio->format('Y-m-d')], ['<=', 'fecha_fin', $fechaFin->format('Y-m-d')]]
            ]);

        return !$query->exists();
    }
}
