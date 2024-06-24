<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_tarifa".
 *
 * @property int $id_tipo_tarifa
 * @property string $name
 * @property int $fecha_inicio
 * @property int $fecha_fin
 * @property int $valor_tarifa
 *
 * @property Apartamentos[] $apartamentos
 */
class TipoTarifasModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_tarifa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'fecha_inicio', 'fecha_fin', 'valor_tarifa'], 'required'],
            [['fecha_inicio', 'fecha_fin', 'valor_tarifa'], 'integer'],
            [['name'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_tarifa' => 'Id Tipo Tarifa',
            'name' => 'Name',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'valor_tarifa' => 'Valor Tarifa',
        ];
    }

    /**
     * Gets query for [[Apartamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApartamentos()
    {
        return $this->hasMany(ApartamentosModel::class, ['id_tarifa' => 'id_tipo_tarifa']);
    }
}
