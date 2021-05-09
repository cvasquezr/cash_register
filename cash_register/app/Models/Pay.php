<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de los pagos
 */
class Pay extends Model
{

    protected $guarded = [];
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function payDetails()
    {
        return $this->hasMany(PayDetails::class, 'pay_id');
    }
}
