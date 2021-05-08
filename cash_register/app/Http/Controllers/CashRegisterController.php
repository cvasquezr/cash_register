<?php

namespace App\Http\Controllers;
use App\Models\CashRegister;
use Illuminate\Http\Request;

class CashRegisterController extends Controller
{
    public function index()
    {
        $cashRegistes = CashRegister::all();
        return response()->json([$cashRegistes]);
    }

    public function show($id)
    {
        $cashRegiste = CashRegister::find($id);
        return response()->json($cashRegiste);
    }

    public function create(Request $request)
    {
        $data = $request['CashRegister'];
        $duplicated = 0;
        $saved = 0;
        $failed = 0;

        foreach ($data as $key => $request) {
            $CashRegister = new CashRegister();
            if ($CashRegister->validateIfAlreadyExist($request['name'])) {
                $duplicated++;
                continue;
            }

            $CashRegister->name     = $request['name'];
            if ($CashRegister->save()) {
                $saved++;
            } else {
                $failed++;
            }
        }

        return response()->json(["Saved" => $saved, "Duplicated" => $duplicated, "Failed" => $failed, "status" => 201]);
    }


    public function update(Request $request, $id)
    {

        $CashRegister = CashRegister::find($id);

        if ($CashRegister == null) {
            return response()->json(["Message" => "CashRegister not found!", "status" => 200]);
        }

        if ($CashRegister->validateIfAlreadyExist($request->name)) {
            return response()->json(["Message" => "CashRegister could not be created, already exist!", "status" => 200]);
        }

        $CashRegister->name     = $request->name;
        $CashRegister->save();
        return response()->json(["Message" => "CashRegister Successfully Updated!", "status" => 201]);
    }

    public function delete($id)
    {
        $CashRegister = CashRegister::find($id);

        if ($CashRegister == null) {
            return response()->json(["Message" => "CashRegister not found!", "status" => 200]);
        }

        $CashRegister->delete();

        return response()->json(["Message" => "CashRegister sucessfully deleted!", "status" => 200]);
    }
}
