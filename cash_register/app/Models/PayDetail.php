<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de los pagos
 */
class PayDetail extends Model
{

    protected $guarded = [];
    protected $primaryKey = 'id';

    public function pay()
    {
        return $this->belongsTo(Pay::class, 'pay_id');
    }
}
