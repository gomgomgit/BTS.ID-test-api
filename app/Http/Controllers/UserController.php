<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAll() {
        $users = User::all();

        return response()->json([
            "message" => "data obtained",
            "data" => $users,
        ], 201);
    }
}
