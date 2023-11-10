<?php

namespace App\Http\Controllers;

use App\Models\AccountsModel;
use App\Models\EquipmentBrandModel;
use App\Models\EquipmentModel;
use App\Models\EquipmentModelsModel;
use App\Models\EquipmentTypeModel;
use App\Models\ObjectsModel;
use App\Models\SiteOptionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObjectController extends Controller
{
    public function checkEmpty($value){
        if(!isset($value) OR $value=="null" OR (empty($value) AND $value!=0)) return null; else return $value;
    }

    public function get(Request $request)
    {
        $offset=0;

        if(isset($request->offset) AND $request->offset>0) $offset=$request->offset;

        $arr_data=[];
        $arr_id=[];
        $equipment_arr=[];
        $dop_arr=[];

        $objectsModel = ObjectsModel::query()->limit(25)->offset($offset)->get();

        foreach ($objectsModel as $item) {
            $arr_data[$item->id]=$item;
            $arr_data[$item->id]['equipment']=[];
            array_push($arr_id,$item->id);
        }

        $equipmentModel = EquipmentModel::query()->whereIn("object",$arr_id)->get();

        foreach ($equipmentModel as $item){
            if(!isset($dop_arr[$item->object])) $dop_arr[$item->object]=[];
            array_push($dop_arr[$item->object],$item->id);

            $equipment_arr[$item->id]=["id"=>$item->id,"type"=>$item->type,"brand"=>$item->brand,
                "model"=>$item->model,"imei"=>$item->imei,"sim_number"=>$item->sim_number,"serial_number"=>$item->serial_number,"firmware"=>$item->firmware];
        }

        foreach ($dop_arr as $key=>$item) {
            $arr_data[$key]['equipment'] = $item;
        }

        $arr_data = array_values($arr_data);

        return response()->json(["result" => true,"data"=>$arr_data,"equipment"=>$equipment_arr]);
    }

    /**
     * @param Request $request
     * @return object
     */
    public function getForDropdown(Request $request): object
    {
        $query = ObjectsModel::select('id', 'name')->orderBy('name');
        if ($request->search) {
            $query
                ->whereRaw('LOWER(`objects`.`name`) LIKE ? ', [trim(strtolower($request->search)) . '%'])
                ->orWhere('objects.name', 'LIKE',  '%' . trim($request->search) . '%');
        }
        return response()->json($query->get());
    }

    public function init(Request $request){

        $types_arr=[];
        $brands_arr=[];
        $models_arr=[];
        $accounts_arr=[];

        $typeModel = EquipmentTypeModel::query()->get();
        foreach ($typeModel as $value){
            $types_arr[$value->id]=["id"=>$value->id,"name"=>$value->name];
        }

        $brandsModel = EquipmentBrandModel::query()->get();
        foreach ($brandsModel as $value){
            $brands_arr[$value->id]=["id"=>$value->id,"name"=>$value->name];
        }

        $modelsModel = EquipmentModelsModel::query()->get();
        foreach ($modelsModel as $value){
            $models_arr[$value->id]=["id"=>$value->id,"name"=>$value->name];
        }

        $accountsModel = AccountsModel::query()->get();
        foreach ($accountsModel as $value){
            $accounts_arr[$value->id]=["id"=>$value->id,"name"=>$value->name];
        }

        return response()->json(["result" => true,"brands"=>$brands_arr,"types"=>$types_arr,"models"=>$models_arr,"accounts"=>$accounts_arr]);

    }

    public function add(Request $request){

        $request->validate([
            'account' => 'required|integer',
            'name' => 'required',
        ]);

        $objectModel = new ObjectsModel();
        $objectModel->account = $request->account;
        $objectModel->name = $request->name;

        $objectModel->user_name = $this->checkEmpty($request->user_name);
        $objectModel->comment = $this->checkEmpty($request->comment);
        $objectModel->type = $this->checkEmpty($request->type);
        $objectModel->brand = $this->checkEmpty($request->brand);
        $objectModel->model = $this->checkEmpty($request->model);
        $objectModel->state_number = $this->checkEmpty($request->state_number);
        $objectModel->vin = $this->checkEmpty($request->vin);
        $objectModel->block = $this->checkEmpty($request->block);
        $objectModel->note = $this->checkEmpty($request->note);
        $objectModel->save();

        if(isset($request->equipment) AND !empty($request->equipment)){
            EquipmentModel::query()->where('object', $objectModel->id)->whereNotIn("id",json_decode($request->equipment,true))->update(["object"=>null]);
            EquipmentModel::query()->whereIn("id",json_decode($request->equipment,true))->update(["object"=>$objectModel->id]);
        }
        else{
            EquipmentModel::query()->where('object', $objectModel->id)->update(["object"=>null]);
            $objectModel->equipment=[];
        }

        return response()->json(["result" => true,"data"=>$objectModel]);

    }

    public function change(Request $request){

        $request->validate([
            'account' => 'required|integer',
            'name' => 'required',
            'id' => 'required|integer',
        ]);

        $objectModel = ObjectsModel::query()->findOrFail($request->id);
        $objectModel->account = $request->account;
        $objectModel->name = $request->name;

        $objectModel->user_name = $this->checkEmpty($request->user_name);
        $objectModel->comment = $this->checkEmpty($request->comment);
        $objectModel->type = $this->checkEmpty($request->type);
        $objectModel->brand = $this->checkEmpty($request->brand);
        $objectModel['model'] = $this->checkEmpty($request->model);
        $objectModel->state_number = $this->checkEmpty($request->state_number);
        $objectModel->vin = $this->checkEmpty($request->vin);
        $objectModel->block = $this->checkEmpty($request->block);
        $objectModel->note = $this->checkEmpty($request->note);
        $objectModel->save();

        if(isset($request->equipment) AND !empty($request->equipment)){
            EquipmentModel::query()->where('object', $objectModel->id)->whereNotIn("id",json_decode($request->equipment,true))->update(["object"=>null]);
            EquipmentModel::query()->whereIn("id",json_decode($request->equipment,true))->update(["object"=>$objectModel->id]);
            $objectModel->equipment=json_decode($request->equipment,true);
        }
        else{
            EquipmentModel::query()->where('object', $objectModel->id)->update(["object"=>null]);
            $objectModel->equipment=[];
        }

        return response()->json(["result" => true,"data"=>$objectModel]);

    }

    public function delete(Request $request){

        $request->validate([
            'id' => 'required|integer'
        ]);

        $equipmentModel = ObjectsModel::query()->findOrFail($request->id);
        $equipmentModel->delete();
        return response()->json(["result" => true]);

    }

    public function freeEquipment(Request $request){

        $request->validate([
            'warehouse' => 'required',
        ]);

        $equipmentModel = null;
        $arr_data=[];
        $ids_arr=[];

        if($request->warehouse=="true"){

            $options_model = SiteOptionsModel::query()->where("name","warehouse_account")->firstOrFail();

            $warehouseAccount = $options_model->value;

            $equipmentModel = EquipmentModel::query()->where("account",$warehouseAccount)->whereNull("object")->get();

        }
        else{

            if(!isset($request->account) OR $request->account<0){
                return response()->json(["result" => false,"code"=>"empty_account"]);
            }

            $equipmentModel = EquipmentModel::query()->where("account",$request->account)->whereNull("object")->get();

        }

        foreach ($equipmentModel as $item) {
            $arr_data[$item->id]=["id"=>$item->id,"type"=>$item->type,"brand"=>$item->brand,
                "model"=>$item->model,"imei"=>$item->imei,"sim_number"=>$item->sim_number,"serial_number"=>$item->serial_number,"firmware"=>$item->firmware];
            array_push($ids_arr,$item->id);
        }

        return response()->json(["result" => true,"data"=>$arr_data,"free_id"=>$ids_arr]);

    }

    /**
     * @param Request $request
     * @return object
     */
    public function getUserObjects(Request $request): object
    {
        $query = ObjectsModel::with(['equipments.lastMessage', 'userObject']);
        ObjectsModel::addCheckPermissionViewByObjectCondition($query, $request->user()->id);
        if ($request->targets) {
            $query->whereIn('objects.id', explode(',', $request->targets));
        }
        if ($request->search) {
            $query
                ->whereRaw('LOWER(`objects`.`name`) LIKE ? ', [trim(strtolower($request->search)) . '%'])
                ->orWhere('objects.name', 'LIKE',  '%' . trim($request->search) . '%');
        }
        return response()->json($query->get());
    }

    /**
     * @param Request $request
     * @return object
     */
    public function getUserObjectsForDropdown(Request $request): object
    {
        $query = ObjectsModel::select('objects.id', 'objects.name')->orderBy('name');
        ObjectsModel::addCheckPermissionViewByObjectCondition($query, $request->user()->id);
        return response()->json($query->get());
    }

    /**
     * @param Request $request
     * @return object
     */
    public function getUserObject(Request $request): object
    {
        $query = ObjectsModel::with(['equipments.lastMessage', 'userObject'])->where(['objects.id' => $request->id]);
        ObjectsModel::addCheckPermissionViewByObjectCondition($query, $request->user()->id);
        return response()->json($query->first());
    }

    public function getCommonReportMessageTabData(Request $request)
    {
        list($from, $to) = $this->getReportPeriodParams($request);
        $data = DB::table('tracker')
            ->select(DB::raw(
                "id, time, course, speed, null as position, null as additional_info, lat, lon,
                CONCAT('Ш: ', CAST(lat as char), ' Д: ', CAST(lon as char), ' (', CAST(sats as char), ')') as coords"
            ))
            ->where('imei', $request->imei)
            ->whereBetween(
                'time',
                [gmdate('Y-m-d H:i:s', $from), gmdate('Y-m-d H:i:s', $to)]
            )
            ->orderBy('time')
            ->get();
        return response()->json($data);
    }

    public function getCommonReportStatisticsTabData(Request $request)
    {
        list($from, $to) = $this->getReportPeriodParams($request);
        $result = DB::table('tracker')
            ->select(DB::raw(
                'MIN(time) as interval_start_at, MAX(time) as interval_finish_at, COUNT(time) as msgs_count,
                null as mileage_by_msgs, null as mileage_by_trips, MAX(speed) as max_speed,
                ROUND(AVG(speed), 2) as avg_speed, null as stops_count, null as parkings_count,
                null as parkings_duration, MAX(time) as last_msgs_time,
                null as last_position, null as moto_hours'
            ))
            ->where('imei', $request->imei)
            ->whereBetween(
                'time',
                [gmdate('Y-m-d H:i:s', $from), gmdate('Y-m-d H:i:s', $to)]
            )
            ->first();
        $data = [
            'interval_start_at' => [
                'label' => 'Начало интервала', 'value' => null, 'prefix' => null
            ],
            'interval_finish_at' => [
                'label' => 'Конец интервала', 'value' => null, 'prefix' => null
            ],
            'msgs_count' => [
                'label' => 'Количество сообщений', 'value' => null, 'prefix' => null
            ],
            'mileage_by_msgs' => [
                'label' => 'Пробег по всем сообщениям', 'value' => null, 'prefix' => null
            ],
            'mileage_by_trips' => [
                'label' => 'Пробег в поездках', 'value' => null, 'prefix' => null
            ],
            'max_speed' => [
                'label' => 'Максимальная скорость', 'value' => null, 'prefix' => 'км/ч'
            ],
            'avg_speed' => [
                'label' => 'Средняя скорость', 'value' => null, 'prefix' => 'км/ч'
            ],
            'stops_count' => [
                'label' => 'Количество стоянок', 'value' => null, 'prefix' => null
            ],
            'parkings_count' => [
                'label' => 'Количество остановок', 'value' => null, 'prefix' => null
            ],
            'parkings_duration' => [
                'label' => 'Продолжительность стоянок', 'value' => null, 'prefix' => null
            ],
            'last_msgs_time' => [
                'label' => 'Время последнего сообщения', 'value' => null, 'prefix' => null
            ],
            'last_position' => [
                'label' => 'Последнее местоположение', 'value' => null, 'prefix' => null
            ],
            'moto_hours' => [
                'label' => 'Последнее местоположение', 'value' => null, 'prefix' => null
            ],
        ];
        if ($result) {
            foreach ($data as $rowKey => $row) {
                if ($result->{$rowKey}) {
                    $data[$rowKey]['value'] = $result->{$rowKey};
                }
            }
        }
        return response()->json($data);
    }

    private function getReportPeriodParams(Request $request)
    {
        $from = $request->from ?? strtotime(' -1 hours');
        $to = $request->to ?? strtotime('now');
        return [$from, $to];
    }
}
