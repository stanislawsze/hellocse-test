<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $api_secret = $request->api_secret;
        $admin = Administrator::first();
        if(Hash::check($api_secret, $admin->api_secret)){
            $admin->bearer_token = Str::random(60);
            $admin->save();
            return response()->json(['token' => $admin->bearer_token], 200);
        }
       return response()->json(['message' => 'Auth failed'], Response::HTTP_UNAUTHORIZED);
    }
}
