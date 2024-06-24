<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apartamentos".
 *
 * @property int $id_apartamento
 * @property string $nombre
 * @property string $direccion
 * @property int $tipo_apartamento
 * @property int $id_ciudad
 * @property int $id_tarifa
 * @property string $imagen
 *
 * @property Ciudades $ciudad
 * @property Reservas[] $reservas
 * @property TipoTarifa $tarifa
 */
class ApartamentosModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apartamentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'direccion', 'tipo_apartamento', 'id_ciudad', 'id_tarifa', 'imagen'], 'required'],
            [['tipo_apartamento', 'id_ciudad', 'id_tarifa'], 'integer'],
            [['imagen'], 'string'],
            [['nombre', 'direccion'], 'string', 'max' => 200],
            [['id_ciudad'], 'exist', 'skipOnError' => true, 'targetClass' => CiudadesModel::class, 'targetAttribute' => ['id_ciudad' => 'id_ciudad']],
            [['id_tarifa'], 'exist', 'skipOnError' => true, 'targetClass' => TipoTarifasModel::class, 'targetAttribute' => ['id_tarifa' => 'id_tipo_tarifa']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_apartamento' => 'Id Apartamento',
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
            'tipo_apartamento' => 'Tipo Apartamento',
            'id_ciudad' => 'Id Ciudad',
            'id_tarifa' => 'Id Tarifa',
            'imagen' => 'Imagen',
        ];
    }

    /**
     * Gets query for [[Ciudad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(CiudadesModel::class, ['id_ciudad' => 'id_ciudad']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(ReservasModel::class, ['apartamento' => 'id_apartamento']);
    }

    /**
     * Gets query for [[Tarifa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTarifa()
    {
        return $this->hasOne(TipoTarifasModel::class, ['id_tipo_tarifa' => 'id_tarifa']);
    }
}
