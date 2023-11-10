<?php

namespace App\Http\Controllers;

use App\Models\AccountsModel;
use App\Models\LimitDebtTypeModel;
use App\Models\PayMethodModel;
use App\Models\TariffModel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AccountBalanceHistory;
use App\Models\OperationTypeModel;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function checkEmpty($value){
        if(!isset($value) OR $value=="null" OR (empty($value) AND $value!=0)) return null; else return $value;
    }

    public function get(Request $request){

        $offset=0;

        if(isset($request->offset) AND $request->offset>0) $offset=$request->offset;

        $arr_data=[];
        $arr_id=[];

        $accountsModel = AccountsModel::query()->limit(25)->offset($offset)->get();

        foreach ($accountsModel as $item) {
            $item->users=0;
            $arr_data[$item->id]=$item;
            array_push($arr_id,$item->id);
        }

        if(!empty($arr_id)){
            $usersModel = User::query()->whereIn("account",$arr_id)->get();
            foreach ($usersModel as $item) {
                $arr_data[$item->account]['users']=$arr_data[$item->account]['users']+1;
            }
        }

        $arr_data = array_values($arr_data);

        return response()->json(["result" => true,"data"=>$arr_data]);

    }

    public function init(Request $request){

        $tariffs_arr=[];
        $tariffsModel = TariffModel::query()->get();
        foreach ($tariffsModel as $item) {
            $tariffs_arr[$item->id]=["id"=>$item->id,"name"=>$item->name];
        }

        $pay_method_arr=[];
        $payMethodsModel = PayMethodModel::query()->get();
        foreach ($payMethodsModel as $item) {
            $pay_method_arr[$item->id]=["id"=>$item->id,"name"=>$item->name];
        }

        $limit_debt_arr=[];
        $limitDebtModel = LimitDebtTypeModel::query()->get();
        foreach ($limitDebtModel as $item) {
            $limit_debt_arr[$item->id]=["id"=>$item->id,"name"=>$item->name,"value"=>""];
        }

        return response()->json(["result" => true,"tariffs"=>$tariffs_arr,"pay_methods"=>$pay_method_arr,"limit_debt"=>$limit_debt_arr]);

    }

    public function add(Request $request){

        foreach ($request as $key=>$value) {
            if($value=="null" OR empty($value)) $request[$key]=null;
        }

        $request->validate([
            'name' => 'required',
            'tariff' => 'required|integer',
            'pay_method' => 'required|integer',
            'limit_debt' => 'required|integer',
            'limit_debt_type' => 'required|integer',
            'block' => 'required',
        ]);


        $accountModel = new AccountsModel();
        $accountModel->name = $request->name;
        $accountModel->tariff = $request->tariff;
        $accountModel->pay_method = $request->pay_method;
        $accountModel->limit_debt = $request->limit_debt;
        $accountModel->limit_debt_type = $request->limit_debt_type;
        if($request->block=="true") $accountModel->block = 1; else $accountModel->block = 0;
        if(isset($request->reason_block)) $accountModel->reason_block = $request->reason_block;
        else $accountModel->reason_block = null;

        if(isset($request->comment)) $accountModel->comment = $request->comment;
        else $accountModel->comment = null;

        if(isset($request->full_name)) $accountModel->full_name = $request->full_name;
        else $accountModel->full_name = null;

        $accountModel->save();
        $accountModel->users=0;
        return response()->json(["result" => true,"data"=>$accountModel]);

    }

    public function change(Request $request){

        foreach ($request as $key=>$value) {
            if($value=="null" OR empty($value)) $request[$key]=null;
        }


        $request->validate([
            'name' => 'required',
            'tariff' => 'required|integer',
            'pay_method' => 'required|integer',
            'limit_debt' => 'required|integer',
            'limit_debt_type' => 'required|integer',
            'block' => 'required',
            'id' => 'required|integer'
        ]);

        $accountModel = AccountsModel::query()->findOrFail($request->id);
        $accountModel->name = $request->name;
        $accountModel->tariff = $request->tariff;
        $accountModel->pay_method = $request->pay_method;
        $accountModel->limit_debt = $request->limit_debt;
        $accountModel->limit_debt_type = $request->limit_debt_type;
        if($request->block=="true") $accountModel->block = 1; else $accountModel->block = 0;

        $accountModel->reason_block = $this->checkEmpty($request->reason_block);
        $accountModel->comment = $this->checkEmpty($request->comment);
        $accountModel->full_name = $this->checkEmpty($request->full_name);

        $accountModel->save();
        $accountModel->users=0;

        $usersModel = User::query()->where("account",$accountModel->id);
        foreach ($usersModel as $item) {
            $accountModel->users=$accountModel->users+1;
        }

        return response()->json(["result" => true,"data"=>$accountModel]);

    }

    public function delete(Request $request){

        $request->validate([
            'id' => 'required|integer'
        ]);

        $accountModel = AccountsModel::query()->findOrFail($request->id);
        $accountModel->delete();
        return response()->json(["result" => true]);

    }

    /**
     * @param Request $request
     * @return object
     */
    public function changeBalance(Request $request): object
    {
        $request->validate(['id' => 'required|integer']);

        $accountModel = AccountsModel::query()->findOrFail($request->id);

        DB::transaction(function() use ($accountModel, $request): void {
            $accountModel->balance += $request->amount;
            $accountModel->save();

            $operationType = OperationTypeModel::query()->where("name", $request->operation_type)->firstOrFail();

            $historyModel = new AccountBalanceHistory;
            $historyModel->accounts_id = $accountModel->id;
            $historyModel->operation_types_id = $operationType->id;
            $historyModel->summ = $request->amount;
            $historyModel->balance = $accountModel->balance;
            $historyModel->comment = $request->operation_comment;

            $historyModel->save();
        });

        return response()->json($accountModel);
    }

    /**
     * @param Request $request
     * @return object
     */
    public function getForDropdown(Request $request): object
    {
        $query = AccountsModel::select('id', 'name')->orderBy('name');
        if ($request->search) {
            $query
                ->whereRaw('LOWER(`accounts`.`name`) LIKE ? ', [trim(strtolower($request->search)) . '%'])
                ->orWhere('accounts.name', 'LIKE',  '%' . trim($request->search) . '%');
        }
        return response()->json($query->get());
    }

    /**
     * @param Request $request
     * @param string $id
     * @return object
     */
    public function getBalanceHistory(Request $request, string $id): object
    {
        $offset = 0;
        $data = AccountBalanceHistory::query()
            ->where('accounts_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit(25)
            ->offset($offset)
            ->with('operation_type:id,name')
            ->get();

        return response()->json(['result' => true, 'data'=>$data]);
    }
}
