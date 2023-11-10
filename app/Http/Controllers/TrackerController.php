<?php

namespace App\Http\Controllers;

use App\Models\TrackerModel;
use Illuminate\Http\Request;

class TrackerController extends Controller
{
    public function checkEmpty($value){
        if(!isset($value) OR $value=="null" OR (empty($value) AND $value!=0)) return null; else return $value;
    }

    function add(Request $request){

        $request->validate([
            'imei' => 'required',
        ]);

        $trackerModel = new TrackerModel();

        $trackerModel->imei = $request->imei;
        $trackerModel->time = new DateTime();

        $trackerModel->save();

        return response()->json(["result" => true,"data"=>$trackerModel]);
    }


    function get(Request $request){

        $search = $request->search;

        $offset = 0;
        $limit = 25;
        if(isset($request->offset) AND !empty($request->offset)) $offset=$request->offset;

        $return_arr=[];

        if ($search) {
            $search = "%$search%";
            $return_arr = TrackerModel::query()
                ->select('tracker.*')
                ->where('tracker.imei','LIKE', $search)
                ->limit($limit)
                ->offset($offset)
                ->get();
        } else {
            $currentModel = TrackerModel::query()->limit(25)->offset($offset)->get();
            foreach ($currentModel as $value){
              array_push($return_arr,$value);
            }
        }

        return response()->json(["result" => true,"data"=>$return_arr]);
    }

    function change(Request $request){

        $request->validate([
            'id' => 'required|integer',
        ]);

        $trackerModel = TrackerModel::query()->findOrFail($request->id);

        $trackerModel->imei=$this->checkEmpty($request->imei);
        $trackerModel->lat=$this->checkEmpty($request->lat);
        $trackerModel->lon=$this->checkEmpty($request->lon);
        $trackerModel->speed=$this->checkEmpty($request->speed);
        $trackerModel->sats=$this->checkEmpty($request->sats);
        $trackerModel->height=$this->checkEmpty($request->height);
        $trackerModel->temp=$this->checkEmpty($request->temp);

        $trackerModel->save();

        return response()->json(["result" => true,"data"=>$trackerModel]);

    }

    function delete(Request $request){

        $request->validate([
            'id' => 'required|integer',
        ]);

        $currentModel = TrackerModel::query()->findOrFail($request->id);
        if(!empty($currentModel)) $currentModel->delete();

        return response()->json(["result" => true]);

    }
}
