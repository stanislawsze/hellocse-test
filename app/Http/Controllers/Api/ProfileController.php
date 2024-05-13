<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return ProfileResource::collection(Profil::whereStatus('active')->get());
    }
}
