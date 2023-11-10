<?php

namespace App\Http\Controllers;

use App\Models\TariffModel;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function checkEmpty($value){
        if(!isset($value) OR $value=="null" OR (empty($value) AND $value!=0)) return null; else return $value;
    }

    function add(Request $request){

        $request->validate([
            'name' => 'required',
        ]);

        $tariffModel = new TariffModel();

        $tariffModel->name = $request->name;
        $tariffModel->comment=$this->checkEmpty($request->comment);
        $tariffModel->history_duration=$this->checkEmpty($request->history_duration);
        $tariffModel->abon_tariff=$this->checkEmpty($request->abon_tariff);
        $tariffModel->every_tariff=$this->checkEmpty($request->every_tariff);
        $tariffModel->one_time_tariff=$this->checkEmpty($request->one_time_tariff);
        $tariffModel->metal=$this->checkEmpty($request->metal);

        $tariffModel->save();

        return response()->json(["result" => true,"data"=>$tariffModel]);

    }

    function get(Request $request){

        $search = $request->search;

        $offset = 0;
        $limit = 25;
        if(isset($request->offset) AND !empty($request->offset)) $offset=$request->offset;

        $return_arr=[];

        if ($search) {
            $search = "%$search%";
            $return_arr = TariffModel::query()
                ->select('tariffs.*')
                ->where('tariffs.name','LIKE', $search)
                ->limit($limit)
                ->offset($offset)
                ->get();
        } else {
            $currentModel = TariffModel::query()->limit(25)->offset($offset)->get();
            foreach ($currentModel as $value){
              array_push($return_arr,$value);
            }
        }

        return response()->json(["result" => true,"data"=>$return_arr]);

    }

    function change(Request $request){

        $request->validate([
            'name' => 'required',
            'id' => 'required|integer',
        ]);

        $tariffModel = TariffModel::query()->findOrFail($request->id);

        $tariffModel->comment=$this->checkEmpty($request->comment);
        $tariffModel->history_duration=$this->checkEmpty($request->history_duration);
        $tariffModel->abon_tariff=$this->checkEmpty($request->abon_tariff);
        $tariffModel->every_tariff=$this->checkEmpty($request->every_tariff);
        $tariffModel->one_time_tariff=$this->checkEmpty($request->one_time_tariff);
        $tariffModel->metal=$this->checkEmpty($request->metal);

        $tariffModel->save();

        return response()->json(["result" => true,"data"=>$tariffModel]);

    }

    function delete(Request $request){

        $request->validate([
            'id' => 'required|integer',
        ]);

        $currentModel = TariffModel::query()->findOrFail($request->id);
        if(!empty($currentModel)) $currentModel->delete();

        return response()->json(["result" => true]);

    }
}
