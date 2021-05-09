<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de las denominaciones permitidas
 */
class Denomination extends Model
{

    protected $guarded = [];
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    /**
     * Verifico si una denominacion ya existe
     * @method     validateIfAlreadyExist
     * @author Carlos Vasquez <cvasquezr@outlook.com>
     * @date 2021-05-08
     * @version    1
     * @param      [string]                    $name    Nombre de la denominacion
     * @param      [string]                    $type    Tipo de denomincacion(billete, moneda)
     * @return     [boolean]                   True si ya existe, false si no existe
     */
    public function validateIfAlreadyExist($name, $type)
    {
        return $this->where('name', $name)->where('type', $type)->get()->isEmpty() ? 0 : 1;
    }

    public function getDenomination($name, $type)
    {
        $denomination = $this->where('name', $name)->where('type', $type)->where('is_active', 1)->first();
        if ($denomination == null) return 0;
        return $denomination['id'];
    }
}
