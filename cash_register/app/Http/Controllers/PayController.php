<?php

namespace App\Http\Controllers;
use App\Models\MonetaryBase;
use App\Models\Denomination;
use App\Models\CashRegister;
use App\Models\Pay;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function create(Request $request)
    {
        $data = $request['Pay'];

        // Validar data ingresada
        $cashRegisterId = $this->vaidateCash($data['cash_register']);
        if ($cashRegisterId == 0) return response()->json(["Message" => 'La caja no se encontro', "status" => 404]);
        $amountNumber = $this->isNumeric($data['amount']);
        if ($amountNumber == 0) return response()->json(["Message" => 'El valor ingresado no es un numero', "status" => 200]);

        $Pay = new Pay();
        $Pay->cash_register_id  = $cashRegisterId;
        $Pay->amount            = $data['amount'];
        $Pay->date              = date('Y-m-d H:i:s');

        if ($Pay->save()) {
            $id = $Pay->id;



            return response()->json(["Message" => 'Pago realizado con exito', "status" => 201]);
        }

        // foreach ($data as $key => $request) {
        //     $MonetaryBase = new MonetaryBase();

        //     // Verifico si existe la denominacion ingresada
        //     if (!$Denomination->validateIfAlreadyExist($request['denomination'], $request['type'])) {
        //         $failed++;
        //         continue;
        //     }

        //     // Obtengo el id de la denominacion y de la caja
        //     $denominationId = $Denomination->getDenomination($request['denomination'], $request['type']);

        //     if ($denominationId == 0 or $cashRegisterId == 0) {
        //         $failed++;
        //         continue;
        //     }

        //     // Verifico si existe, si existe actualizo, si no creo
        //     $id = $MonetaryBase->alreadyExist($denominationId, $cashRegisterId);
        //     if ($id) {
        //         $flag = $this->update($request, $id);
        //         if ($flag == 1) {
        //             $saved++;
        //         } else {
        //             $failed++;
        //         }
        //         continue;
        //     }

        //     $MonetaryBase->denomination_id    = $denominationId;
        //     $MonetaryBase->cash_register_id   = $cashRegisterId;
        //     $MonetaryBase->quantity           = $request['quantity'];
        //     if ($MonetaryBase->save()) {
        //         $saved++;
        //     } else {
        //         $failed++;
        //     }
        // }

        // return response()->json(["Saved" => $saved, "Failed" => $failed, "status" => 201]);
    }

    public function vaidateCash($cashRegister)
    {
        $CashRegister = new CashRegister();
        return $CashRegister->getCash($cashRegister);
    }

    public function isNumeric($number)
    {
        return is_numeric($number) ? 1 : 0;
    }
}
