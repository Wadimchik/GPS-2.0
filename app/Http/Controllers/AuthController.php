<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AccountsModel;
use App\Models\VerifyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'login' => 'required|string|max:255',
            'device_name' => 'required',
        ]);

        $user = User::where('name', $request->login)->first();

        if (!$user || $request->password != $user->password) {
            return response()->json(['result' => false, 'code' => 'error_data']);
        }

        if ($user->account) {
            $mainAccount = AccountsModel::where('id', $user->account)->first();
            if ($mainAccount && $mainAccount->block) {
                $message = $mainAccount->reason_block
                    ? "Пользователь \"{$user->email}\" был заблокирован по причине \"{$mainAccount->reason_block}\""
                    : "Пользователь \"{$user->email}\" был заблокирован";
                return response()->json(['result' => false, 'code' => 'blocked', 'message' => $message]);
            }
        }

        if ($user->block) {
            $message = $user->reason_block
                ? "Пользователь \"{$user->email}\" был заблокирован по причине \"{$user->reason_block}\""
                : "Пользователь \"{$user->email}\" был заблокирован";
            return response()->json(['result' => false, 'code' => 'blocked', 'message' => $message]);
        }

        $user->last_login = now();
        $user->save();

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'result' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role_id' => $user->role
            ]
        ]);
    }

    public function Reg(Request $request){

        $request->validate([
            'password' => 'required|min:6',
            'email' => 'required|email',
            'login' => 'required',
            'name' => 'required',
            'device_name' => 'required'
        ]);

        if (User::where("email",$request->email)->exists()) return response()->json(array("result"=>false,"code"=>"exist_email"));
        if (User::where("login",$request->login)->exists()) return response()->json(array("result"=>false,"code"=>"exist_login"));

        $userModel= new User();
        $userModel->email=$request->email;
        $userModel->password=Hash::make($request->password);
        $userModel->name=$request->name;
        $userModel->login=$request->login;

        $userModel->save();

        $token = md5(rand(10, 30) . microtime());

        $emailVerify = new VerifyModel();
        $emailVerify->email=$request->email;
        $emailVerify->token=$token;
        $emailVerify->id_user=$userModel->id;

        $emailVerify->save();

        $userModel->sendValidEmail($token,$userModel->id);

        $token = $userModel->createToken($request->device_name)->plainTextToken;

        return response()->json(["result" => true,"token"=>$token]);

    }

    public function VerifyEmail(Request $request){

        $request->validate([
            'id' => 'required|int',
            'token' => 'required|min:10',
        ]);

        $verifyModel = VerifyModel::query()->where("id_user",$request->id);

        if($verifyModel->token == $request->token){
            $usersModel = User::query()->find($request->id);
            $usersModel->email_verified=1;
            $usersModel->save();
            return response()->json(["result" => true]);
        }

    }

    public function check(Request $request){

        $user=$request->user();

        return response()->json(["result" => true,"role"=>$user->role]);

    }
}
