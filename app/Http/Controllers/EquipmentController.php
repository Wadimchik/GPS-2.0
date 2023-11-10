<?php

namespace App\Http\Controllers;

use App\Models\AccountsModel;
use App\Models\BrandsEquipmentModel;
use App\Models\EquipmentBrandModel;
use App\Models\EquipmentModel;
use App\Models\EquipmentModelsModel;
use App\Models\EquipmentTypeModel;
use App\Models\ModelsEquipmentModel;
use App\Models\ObjectsModel;
use App\Models\TypeEquipmentModel;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function checkEmpty($value){
        if(!isset($value) OR $value=="null" OR (empty($value) AND $value!=0)) return null; else return $value;
    }

    public function get(Request $request){

        $offset=0;

        if(isset($request->offset) AND $request->offset>0) $offset=$request->offset;

        $arr_data=[];
        $objects_arr=[];
        $arr_id=[];

        $equipmentModel = EquipmentModel::query()->limit(25)->offset($offset)->get();

        foreach ($equipmentModel as $item) {
            array_push($arr_data,$item);
            if(isset($item->object) AND $item->object>0){
                array_push($arr_id,$item->object);
            }
        }

        $objectsModel = ObjectsModel::query()->whereIn("id",$arr_id)->get();

        foreach ($objectsModel as $item) {
            $objects_arr[$item->id]=["id"=>$item->id,"name"=>$item->name];
        }

        return response()->json(["result" => true,"data"=>$arr_data,"objects"=>$objects_arr]);

    }

    public function init(Request $request){

        $types_arr=[];
        $brands_arr=[];
        $models_arr=[];
        $accounts_arr=[];
        $all_arr=[];
        $dop_arr=[];

        $typeModel = EquipmentTypeModel::query()->get();
        foreach ($typeModel as $value){
            $types_arr[$value->id]=["id"=>$value->id,"name"=>$value->name];
            $all_arr[$value->id]=["id"=>$value->id,"name"=>$value->name,"brands"=>[]];
        }

        $brandsModel = EquipmentBrandModel::query()->get();
        foreach ($brandsModel as $value){
            $brands_arr[$value->id]=["id"=>$value->id,"name"=>$value->name];
            $dop_arr[$value->id]=["id"=>$value->id,"name"=>$value->name,"models"=>[],"type"=>$value->type];
        }

        $modelsModel = EquipmentModelsModel::query()->get();
        foreach ($modelsModel as $value){
            $models_arr[$value->id]=["id"=>$value->id,"name"=>$value->name];
            $dop_arr[$value->brand]['models'][$value->id]=["id"=>$value->id,"name"=>$value->name];
        }

        $accountsModel = AccountsModel::query()->get();
        foreach ($accountsModel as $value){
            $accounts_arr[$value->id]=["id"=>$value->id,"name"=>$value->name];
        }

        foreach ($dop_arr as $value){
            $all_arr[$value['type']]['brands'][$value['id']]=["name"=>$value['name'],"id"=>$value['id'],"models"=>$value['models']];
        }

        return response()->json(["result" => true,"brands"=>$brands_arr,"types"=>$types_arr,"models"=>$models_arr,"all"=>$all_arr,"accounts"=>$accounts_arr]);

    }

    public function add(Request $request){

        $request->validate([
            'account' => 'required|integer',
            'type' => 'required|integer',
        ]);


        $equipmentModel = new EquipmentModel();
        $equipmentModel->account = $request->account;
        $equipmentModel->type = $request->type;

        $equipmentModel->owner=$this->checkEmpty($request->owner);
        $equipmentModel->reason_use=$this->checkEmpty($request->reason_use);
        $equipmentModel->date_sale=$this->checkEmpty($request->date_sale);
        $equipmentModel->work=$this->checkEmpty($request->work);
        $equipmentModel->date_work=$this->checkEmpty($request->date_work);
        $equipmentModel->comment=$this->checkEmpty($request->comment);
        $equipmentModel->brand=$this->checkEmpty($request->brand);
        $equipmentModel->model=$this->checkEmpty($request->model);
        $equipmentModel->serial_number=$this->checkEmpty($request->serial_number);
        $equipmentModel->imei=$this->checkEmpty($request->imei);
        $equipmentModel->firmware=$this->checkEmpty($request->firmware);
        $equipmentModel->config=$this->checkEmpty($request->config);
        $equipmentModel->login=$this->checkEmpty($request->login);
        $equipmentModel->password=$this->checkEmpty($request->password);
        $equipmentModel->sim_owner=$this->checkEmpty($request->sim_owner);
        $equipmentModel->sim_operator=$this->checkEmpty($request->sim_operator);
        $equipmentModel->sim_number=$this->checkEmpty($request->sim_number);
        $equipmentModel->sim_iccid=$this->checkEmpty($request->sim_iccid);
        $equipmentModel->sim_comment=$this->checkEmpty($request->sim_comment);
        $equipmentModel->installation_location=$this->checkEmpty($request->installation_location);

        if (EquipmentModel::query()->where('imei', $request->imei)->exists()) {
            return response()->json([
                'message' => 'Оборудование с данным IMEI уже есть в базе', 'result' => false],
                status: 422
            );
        };

        $equipmentModel->save();
        return response()->json(["result" => true,"data"=>$equipmentModel]);

    }

    public function change(Request $request){

        $request->validate([
            'account' => 'required|integer',
            'type' => 'required|integer',
            'id' => 'required|integer'
        ]);

        $equipmentModel = EquipmentModel::query()->findOrFail($request->id);
        $equipmentModel->account = $request->account;
        $equipmentModel->type = $request->type;

        $equipmentModel->owner=$this->checkEmpty($request->owner);
        $equipmentModel->reason_use=$this->checkEmpty($request->reason_use);
        $equipmentModel->date_sale=$this->checkEmpty($request->date_sale);
        $equipmentModel->work=$this->checkEmpty($request->work);
        $equipmentModel->date_work=$this->checkEmpty($request->date_work);
        $equipmentModel->comment=$this->checkEmpty($request->comment);
        $equipmentModel->brand=$this->checkEmpty($request->brand);
        $equipmentModel['model'] =$this->checkEmpty($request->model);
        $equipmentModel->serial_number=$this->checkEmpty($request->serial_number);
        $equipmentModel->imei=$this->checkEmpty($request->imei);
        $equipmentModel->firmware=$this->checkEmpty($request->firmware);
        $equipmentModel->config=$this->checkEmpty($request->config);
        $equipmentModel->login=$this->checkEmpty($request->login);
        $equipmentModel->password=$this->checkEmpty($request->password);
        $equipmentModel->sim_owner=$this->checkEmpty($request->sim_owner);
        $equipmentModel->sim_operator=$this->checkEmpty($request->sim_operator);
        $equipmentModel->sim_number=$this->checkEmpty($request->sim_number);
        $equipmentModel->sim_iccid=$this->checkEmpty($request->sim_iccid);
        $equipmentModel->sim_comment=$this->checkEmpty($request->sim_comment);
        $equipmentModel->installation_location=$this->checkEmpty($request->installation_location);

        if (EquipmentModel::query()->where('imei', $request->imei)->exists()) {
            return response()->json([
                'message' => 'Оборудование с данным IMEI уже есть в базе', 'result' => false],
                status: 422
            );
        };

        $equipmentModel->save();

        return response()->json(["result" => true,"data"=>$equipmentModel]);

    }

    public function delete(Request $request){

        $request->validate([
            'id' => 'required|integer'
        ]);

        $equipmentModel = EquipmentModel::query()->findOrFail($request->id);
        $equipmentModel->delete();
        return response()->json(["result" => true]);

    }

    public function freeEquipment(Request $request){

    }
}
