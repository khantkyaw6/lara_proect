<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AdminController extends Controller
{

    public function register(RegisterRequest  $request)
    {
        $validator = $request->validated();
        $validator['password'] = Hash::make($validator['password']);
        // $validator['password'] = bcrypt($validator['password']);
        $validator['token'] = uniqid(base64_encode(Str::random(21)));
        $admin = Admin::create($validator);

        return response()->json([
            "error" => false,
            "message" => "Admin register successfully",
            // "token" => $token,
            "data" => $admin,
        ]);
    }
    //
    public function login(AdminLoginRequest $request)
    {

        $validator = $request->validated();
        $admin = Admin::where('email', $validator['email'])->first(['fullname', 'email', 'password']);


        if ($admin && Hash::check($validator['password'], $admin->password)) {
            $admin->token = uniqid(base64_encode(Str::random(21)));
            $admin->save();
            return response()->json([
                'error' => false,
                "message" => "Admin Login Successfully",
                "data" => $admin
            ]);
        } else {
            return Response([
                'error' => true,
                "message" => "Email or Password is incorrect",
            ]);
        }
    }

    public function logout(Request $request)
    {

        Admin::where("id", $request->admin_id)->update(['token' => null]);
        return response()->json([
            "error" => false,
            "message" => "Logout success",
        ]);
    }
}
