<?php

namespace App\Http\Controllers;
use App\Models\MonetaryBase;
use App\Models\Denomination;
use App\Models\CashRegister;
use Illuminate\Http\Request;

class MonetaryBaseController extends Controller
{
    public function index()
    {
        $monetaryBases = MonetaryBase::with('cashRegister', 'denomination')->get();
        $monetaryBases = MonetaryBase::processData($monetaryBases);
        return response()->json([$monetaryBases]);
    }

    public function create(Request $request)
    {
        $Denomination = new Denomination();
        $CashRegister = new CashRegister();
        $data = $request['MonetaryBase'];
        $saved = 0;
        $failed = 0;

        foreach ($data as $key => $request) {
            $MonetaryBase = new MonetaryBase();

            // Verifico si existe la denominacion ingresada
            if (!$Denomination->validateIfAlreadyExist($request['denomination'], $request['type'])) {
                $failed++;
                continue;
            }

            // Obtengo el id de la denominacion y de la caja
            $denominationId = $Denomination->getDenomination($request['denomination'], $request['type']);
            $cashRegisterId = $CashRegister->getCash($request['cash']);

            if ($denominationId == 0 or $cashRegisterId == 0) {
                $failed++;
                continue;
            }

            // Verifico si existe, si existe actualizo, si no creo
            $id = $MonetaryBase->alreadyExist($denominationId, $cashRegisterId);
            if ($id) {
                $flag = $this->update($request, $id);
                if ($flag == 1) {
                    $saved++;
                } else {
                    $failed++;
                }
                continue;
            }

            $MonetaryBase->denomination_id    = $denominationId;
            $MonetaryBase->cash_register_id   = $cashRegisterId;
            $MonetaryBase->quantity           = $request['quantity'];
            if ($MonetaryBase->save()) {
                $saved++;
            } else {
                $failed++;
            }
        }

        return response()->json(["Saved" => $saved, "Failed" => $failed, "status" => 201]);
    }

    public function update($request, $id)
    {
        $MonetaryBase = MonetaryBase::find($id);
        if ($MonetaryBase == null) return 0;

        $MonetaryBase->quantity = $request['quantity'];
        if ($MonetaryBase->save()) return 1;
        return 0;
    }

    public function delete()
    {
        MonetaryBase::truncate();
        return response()->json(["Message" => "La caja fue vaciada!", "status" => 200]);
    }
}
