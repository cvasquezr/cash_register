<?php

namespace App\Http\Controllers;
use App\Models\Denomination;
use Illuminate\Http\Request;

class DenominationController extends Controller
{
    public function index()
    {
        $denominations = Denomination::all();
        return response()->json([$denominations]);
    }

    public function show($id)
    {
        $denomination = Denomination::find($id);
        return response()->json($denomination);
    }

    public function create(Request $request)
    {
        $Denomination = new Denomination();

        if ($Denomination->validateIfAlreadyExist($request->name, $request->type)) {
            return response()->json(["Message" => "Denomination could not be created, already exist!", "status" => 200]);
        }

        $Denomination->name     = $request->name;
        $Denomination->type     = $request->type;
        $Denomination->save();

        return response()->json(["Message" => "Denomination Successfully Created!", "status" => 201]);
    }

    public function createMany(Request $request)
    {
        $data = $request['Denominations'];
        $duplicated = 0;
        $saved = 0;
        $failed = 0;

        foreach ($data as $key => $request) {
            $Denomination = new Denomination();
            if ($Denomination->validateIfAlreadyExist($request['name'], $request['type'])) {
                $duplicated++;
                continue;
            }

            $Denomination->name     = $request['name'];
            $Denomination->type     = $request['type'];
            if ($Denomination->save()) {
                $saved++;
            } else {
                $failed++;
            }
        }

        return response()->json(["Saved" => $saved, "Duplicated" => $duplicated, "Failed" => $failed, "status" => 201]);
    }


    public function update(Request $request, $id)
    {
        $Denomination = Denomination::find($id);

        if ($Denomination == null) {
            return response()->json(["Message" => "Denomination not found!", "status" => 200]);
        }

        if ($Denomination->validateIfAlreadyExist($request->name, $request->type)) {
            return response()->json(["Message" => "Denomination could not be created, already exist!", "status" => 200]);
        }

        $Denomination->name     = $request->name;
        $Denomination->type    = $request->type;
        $Denomination->save();
        return response()->json(["Message" => "Denomination Successfully Updated!", "status" => 201]);
    }

    public function delete($id)
    {
        $Denomination = Denomination::find($id);

        if ($Denomination == null) {
            return response()->json(["Message" => "Denomination not found!", "status" => 200]);
        }

        $Denomination->delete();

        return response()->json(["Message" => "Denomination sucessfully deleted!", "status" => 200]);
    }

    public function disabled($id)
    {
        $Denomination = Denomination::find($id);

        if ($Denomination == null) {
            return response()->json(["Message" => "Denomination not found!", "status" => 200]);
        }

        $Denomination->is_active  = 0;
        $Denomination->save();
        return response()->json(["Message" => "Denomination Successfully Disabled!", "status" => 200]);
    }
}
