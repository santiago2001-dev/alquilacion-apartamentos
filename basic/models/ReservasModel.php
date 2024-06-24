<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservas".
 *
 * @property string $id_reserva
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property int $apartamento
 * @property int $cliente
 * @property int $alquiler
 * @property int $tasa_servicio
 *
 * @property Apartamentos $apartamento0
 * @property Clientes $cliente0
 */
class ReservasModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_reserva', 'fecha_inicio', 'fecha_fin', 'apartamento', 'cliente', 'alquiler', 'tasa_servicio'], 'required'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['apartamento', 'cliente', 'alquiler', 'tasa_servicio'], 'integer'],
            [['id_reserva'], 'string', 'max' => 4],
            [['id_reserva'], 'unique'],
            [['apartamento'], 'exist', 'skipOnError' => true, 'targetClass' => ApartamentosModel::class, 'targetAttribute' => ['apartamento' => 'id_apartamento']],
            [['cliente'], 'exist', 'skipOnError' => true, 'targetClass' => ClientesModel::class, 'targetAttribute' => ['cliente' => 'id_cliente']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_reserva' => 'Id Reserva',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'apartamento' => 'Apartamento',
            'cliente' => 'Cliente',
            'alquiler' => 'Alquiler',
            'tasa_servicio' => 'Tasa Servicio',
        ];
    }

    /**
     * Gets query for [[Apartamento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApartamento()
    {
        return $this->hasOne(ApartamentosModel::class, ['id_apartamento' => 'apartamento']);
    }

    /**
     * Gets query for [[Cliente0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(ClientesModel::class, ['id_cliente' => 'cliente']);
    }
}
