<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de la base monetaria
 */
class MonetaryBase extends Model
{

    protected $guarded = [];
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function denomination()
    {
        return $this->belongsTo(Denomination::class, 'denomination_id');
    }

    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class, 'cash_register_id');
    }

    public function alreadyExist($denomination_id, $cash_register_id)
    {
        $base = $this->where('denomination_id', $denomination_id)->where('cash_register_id', $cash_register_id)->first();
        return $base != null ? $base['id'] : 0;
    }

    public static function processData($monetaryBases)
    {
        $total = 0;
        $monetaryBasesProcess = [];
        foreach ($monetaryBases as $key => $monetaryBase) {
            $monetaryBasesProcess[$key]['caja'] = $monetaryBase['cashRegister']['name'];
            $monetaryBasesProcess[$key]['denominacion'] = $monetaryBase['denomination']['name'];
            $monetaryBasesProcess[$key]['cantidad'] = $monetaryBase['quantity'];
            $total += $monetaryBase['quantity'] * $monetaryBase['denomination']['name'];
        }

        $monetaryBasesProcess['totalDinero'] = $total;
        return $monetaryBasesProcess;
    }
}
