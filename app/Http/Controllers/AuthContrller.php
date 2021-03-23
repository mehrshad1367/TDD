<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthContrller extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $atr = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|unique:users,email",
            "password" => "required|string|confirmed|min:3"
        ]);

        $user = User::create([
            "name" => $atr["name"],
            "email" => $atr["email"],
            "password" => bcrypt($atr["password"])
        ]);

        return $this->success([
            "token" => $user->createToken("API Token")->plainTextToken
        ]);
    }

    public function login(Request $request)
    {
        $atr = $request->validate([
            "email" => "required|string|email",
            "password" => "required|string"
        ]);

        if (!Auth::attempt($atr)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->$this->success([
            "token" => auth()->user()->createToken("API Token")->plainTextTken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
          "message" => "Token Revoke"
        ];
    }
}
