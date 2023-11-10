<?php

namespace App\Http\Controllers;

use App\Models\OperationTypeModel;
use Illuminate\Http\Request;

class OperationTypeController extends Controller{
    public function get(Request $request){
        $operations = OperationTypeModel::query()->orderBy("name")->get();

        return response()->json($operations);
    }
}
