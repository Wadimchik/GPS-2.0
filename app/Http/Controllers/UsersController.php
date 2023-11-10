<?php

namespace App\Http\Controllers;

use App\Models\AccountsModel;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function checkEmpty($value){
        if(!isset($value) OR $value=="null" OR (empty($value) AND $value!=0)) return null; else return $value;
    }

    public function get(Request $request)
    {

        $offset = 0;
        $limit = 25;

        $search = $request->search;

        if (!empty($request->offset)) {
            $offset = $request->offset;
        }

        if ($search) {
            $search = "%$search%";
            $data = User::query()
                ->leftjoin('roles','roles.id', 'users.role')
                ->select('users.*')
                ->leftjoin('accounts','accounts.id','users.account')
                ->where('users.name','LIKE', $search)
                ->orWhere('roles.name','LIKE', $search)
                ->orWhere('accounts.name','LIKE', $search)
                ->limit($limit)
                ->offset($offset)
                ->get();
        } else {
            $data = User::query()->limit($limit)->offset($offset)->get();
        }

        return response()->json(['result' => true, 'data' => $data]);
    }

    public function init(Request $request){

        $roles_arr=[];
        $rolesModel = UserRolesModel::query()->get();
        foreach ($rolesModel as $item) {
            $roles_arr[$item->id]=["id"=>$item->id,"name"=>$item->name];
        }

        $accounts_arr=[];
        $accountsModel = AccountsModel::query()->get();
        foreach ($accountsModel as $item) {
            $accounts_arr[$item->id]=["id"=>$item->id,"name"=>$item->name];
        }

        return response()->json(["result" => true,"roles"=>$roles_arr,"accounts"=>$accounts_arr]);

    }

    public function add(Request $request){

        foreach ($request as $key=>$value) {
            if($value=="null" OR empty($value)) $request[$key]=null;
        }

        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'role' => 'required|integer',
        ]);

        if(User::query()->where("email",$request->email)->exists()){
            return response()->json(["result" => false,"code"=>"email_exist"]);
        }

        $userModel = new User();
        $userModel->name = $request->name;
        $userModel->password = $request->password;
        $userModel->email = $request->email;
        $userModel->role = $request->role;
        $userModel->last_login=null;
        $userModel->last_action=null;
        if($request->block=="true") $userModel->block = 1; else $userModel->block = 0;
        if($request->change_password=="true") $userModel->change_password = 1; else $userModel->change_password = 0;
        if(isset($request->reason_block)) $userModel->reason_block = $request->reason_block;
        else $userModel->reason_block = null;

        if(isset($request->comment)) $userModel->comment = $request->comment;
        else $userModel->comment = null;

        if(isset($request->phone)) $userModel->phone = $request->phone;
        else $userModel->phone = null;

        if(isset($request->account)) $userModel->account = $request->account;
        else $userModel->account = null;

        $userModel->save();
        return response()->json(["result" => true,"data"=>$userModel]);

    }

    public function change(Request $request){

        foreach ($request as $key=>$value) {
            if($value=="null" OR empty($value)) $request[$key]=null;
        }

        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'role' => 'required|integer',
            'id' => 'required|integer',
        ]);

        $userModel = User::query()->findOrFail($request->id);
        $userModel->name = $request->name;
        $userModel->password = $request->password;
        $userModel->email = $request->email;
        $userModel->role = $request->role;
        $userModel->last_login=null;
        $userModel->last_action=null;
        if($request->block=="true") $userModel->block = 1; else $userModel->block = 0;
        if($request->change_password=="true") $userModel->change_password = 1; else $userModel->change_password = 0;

        $userModel->reason_block = $this->checkEmpty($request->reason_block);
        $userModel->comment = $this->checkEmpty($request->comment);
        $userModel->phone = $this->checkEmpty($request->phone);
        $userModel->account = $this->checkEmpty($request->account);

        $userModel->save();
        return response()->json(["result" => true,"data"=>$userModel]);

    }

    public function delete(Request $request){

        $request->validate([
            'id' => 'required|integer'
        ]);

        $userModel = User::query()->findOrFail($request->id);
        $userModel->delete();
        return response()->json(["result" => true]);

    }
}
