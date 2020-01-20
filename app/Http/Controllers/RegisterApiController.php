<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = \Validator::make($request->json()->all(),
            [
                "name" => "required",
                "email" => "required|email",
                "password" => "required",
                "same_password" => "required|same:password"
            ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "success" => false,
                    "error" => "Validation Error " . $validator->errors()
                ]
            );
        }

        $data = $request->json()->all();
        $data["password"] = \Hash::make($data["password"]);
        $token = User::generateApiToken();
        $data["api_token"] = $token;
        $user = User::create($data);


        return response()->json(
            [
                "success" => true,
                "token" => $token
            ]
        );

    }


    public function login(Request $request)
    {
        $data = $request->json()->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
            $success['token'] = $user->createApiToken();

            $request->session()->put("user_data",
                [
                    "name" => $user->name,
                    "email" => $user->email,
                    "token" => $success['token']
                ]);

            return response()->json(['success' => $success, "key" => $request->session()->all()], 200);

        } else {

            return response()->json(['error' => 'Unauthorised'], 401);
        }

    }

    public function msg_test(Request $request)
    {
        $data = $request->json()->all();
        $user_data = $request->session()->get("user_data");
        if (false and (
            $data["name"] != $user_data["name"] or
            $data["email"] != $user_data["email"] or
            $data["token"] != $user_data["token"])
        ) {
            return response()->json(["error" => "wrong_data"]);
        } else {
            return response()->json([
                "status" => "success",
                "msg" => [
                    "name" => $data["name"],
                    "msg_text" => $data["msg"],
                ],
                "user"=>$request->user(),
                "session" => session()->all()
            ]);
        }
    }


}
