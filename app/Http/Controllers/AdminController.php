<?php

namespace App\Http\Controllers;

use App\Models\DeviceTypeModel;
use App\Models\TariffModel;
use App\Models\TypeEquipmentModel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //=======================================Tariff=====================================================================

    function addTariff(Request $request){

        $request->validate([
            'name' => 'required',
        ]);

        $currentModel = new TariffModel();

        $currentModel->name = $request->name;
        if(isset($request->comment)) $currentModel->comment = $request->comment;
        if(isset($request->history_duration)) $currentModel->history_duration = $request->history_duration;
        if(isset($request->abon_tariff)) $currentModel->abon_tariff = $request->abon_tariff;
        if(isset($request->every_tariff)) $currentModel->every_tariff = $request->every_tariff;
        if(isset($request->one_time_tariff)) $currentModel->one_time_tariff = $request->one_time_tariff;
        if(isset($request->metal)) $currentModel->metal = $request->metal;

        $currentModel->save();

        return response()->json(["result" => true,"data"=>$currentModel]);

    }

    function getTariff(Request $request){

        $offset = 0;
        if(isset($request->offset) AND !empty($request->offset)) $offset=$request->offset;

        $currentModel = TariffModel::query()->limit(25)->offset($offset)->get();

        $return_arr=[];

        foreach ($currentModel as $value){
            array_push($return_arr,$value);
        }

        return response()->json(["result" => true,"data"=>$return_arr]);

    }

    function changeTariff(Request $request){

        $request->validate([
            'name' => 'required',
            'id' => 'required|integer',
        ]);

        $currentModel = TariffModel::query()->findOrFail($request->id);

        $currentModel->name = $request->name;
        if(isset($request->comment)) $currentModel->comment = $request->comment;
        if(isset($request->history_duration)) $currentModel->history_duration = $request->history_duration;
        if(isset($request->abon_tariff)) $currentModel->abon_tariff = $request->abon_tariff;
        if(isset($request->every_tariff)) $currentModel->every_tariff = $request->every_tariff;
        if(isset($request->one_time_tariff)) $currentModel->one_time_tariff = $request->one_time_tariff;
        if(isset($request->metal)) $currentModel->metal = $request->metal;

        $currentModel->save();

        return response()->json(["result" => true]);

    }

    function deleteTariff(Request $request){

        $request->validate([
            'id' => 'required|integer',
        ]);

        $currentModel = TariffModel::query()->findOrFail($request->id);
        if(!empty($currentModel)) $currentModel->delete();

        return response()->json(["result" => true]);

    }

    //==================================================================================================================
    //=======================================TypeEquipment=====================================================================

    function addTypeEquipment(Request $request){

        $request->validate([
            'type' => 'required|integer',
        ]);

        $currentModel = new TypeEquipmentModel();

        $currentModel->type = $request->type;
        if(isset($request->comment)) $currentModel->comment = $request->comment;
        if(isset($request->brand)) $currentModel->brand = $request->brand;
        if(isset($request->model_t)) $currentModel->model_t = $request->model_t;
        if(isset($request->server_t)) $currentModel->server_t = $request->server_t;
        if(isset($request->port_t)) $currentModel->port_t = $request->port_t;
        if(isset($request->params)) $currentModel->params = $request->params;

        $currentModel->save();

        return response()->json(["result" => true,"data"=>$currentModel]);

    }

    function getTypeEquipment(Request $request){

        $offset = 0;
        if(isset($request->offset) AND !empty($request->offset)) $offset=$request->offset;

        $currentModel = TypeEquipmentModel::query()->orderBy("id","DESC")->limit(25)->offset($offset)->get();

        $return_arr=[];

        foreach ($currentModel as $value){
            array_push($return_arr,$value);
        }

        $devices_type_array=[];
        $deviceTypeModel = DeviceTypeModel::query()->get();
        foreach ($deviceTypeModel as $value){
            $devices_type_array[$value->id] = $value;
        }

        return response()->json(["result" => true,"data"=>$return_arr,"device_type"=>$devices_type_array]);

    }

    function changeTypeEquipment(Request $request){

        $request->validate([
            'type' => 'required|integer',
            'id' => 'required|integer',
        ]);

        $currentModel = TypeEquipmentModel::query()->findOrFail($request->id);

        $currentModel->type = $request->type;
        if(isset($request->comment)) $currentModel->comment = $request->comment;
        if(isset($request->brand)) $currentModel->brand = $request->brand;
        if(isset($request->model_t)) $currentModel->model_t = $request->model_t;
        if(isset($request->server_t)) $currentModel->server_t = $request->server_t;
        if(isset($request->port_t)) $currentModel->port_t = $request->port_t;
        if(isset($request->params)) $currentModel->params = $request->params;

        $currentModel->save();

        return response()->json(["result" => true]);

    }

    function deleteTypeEquipment(Request $request){

        $request->validate([
            'id' => 'required|integer',
        ]);

        $currentModel = TypeEquipmentModel::query()->findOrFail($request->id);
        if(!empty($currentModel)) $currentModel->delete();

        return response()->json(["result" => true]);

    }

    //==================================================================================================================

}
