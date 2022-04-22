<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShoppingController extends Controller
{
    public function getAll() {
        $shoppings = Shopping::all();

        return response()->json([
            'data' => $shoppings,
        ], 201);
    }

    public function getById($id)
    {
        $shopping = Shopping::find($id);

        return response()->json([
            "message" => "data obtained",
            "data" => $shopping,
        ], 201);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'shopping.createddate' => 'required|date',
            'shopping.name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $shopping = Shopping::create([
            "createddate" => $request->shopping['createddate'],
            "name" => $request->shopping['name']
        ]);

        return response()->json([
            "message" => "data created",
            "data" => [
                "createddate"=> $shopping->createddate,
                "id"=> $shopping->id,
                "name"=> $shopping->name,
            ]
        ], 201);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'shopping.createddate' => 'required|date',
            'shopping.name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $shopping = Shopping::find($id);
        $shopping->update([
            "createddate" => $request->shopping['createddate'],
            "name" => $request->shopping['name']
        ]);

        return response()->json([
            "message" => "data updated",
            "data" => [
                "createddate"=> $shopping->createddate,
                "id"=> $shopping->id,
                "name"=> $shopping->name,
            ]
        ], 201);
    }

    public function delete(Request $request, $id) {
        $shopping = Shopping::find($id);
        $shopping->delete();

        return response()->json([
            "message" => "data deleted",
            "data" => [
                "createddate"=> $shopping->createddate,
                "id"=> $shopping->id,
                "name"=> $shopping->name,
            ]
        ], 201);
    }
}
