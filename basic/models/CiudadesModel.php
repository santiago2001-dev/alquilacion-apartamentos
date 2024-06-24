<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ciudades".
 *
 * @property int $id_ciudad
 * @property string $nombre
 *
 * @property Apartamentos[] $apartamentos
 */
class CiudadesModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ciudades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ciudad' => 'Id Ciudad',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Apartamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApartamentos()
    {
        return $this->hasMany(ApartamentosModel::class, ['id_ciudad' => 'id_ciudad']);
    }
}
