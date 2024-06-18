<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopApiController extends Controller
{
    public function showAll()
    {
        try {
            return response()->json(Shop::all());
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required',
            ]);
            if (Shop::get()->where('name', $validate['name'])->first()) {
                return response()->json("Магазин с таким названием уже существует", 400, [], JSON_UNESCAPED_UNICODE);
            }
            Shop::create($validate);
            return response()->json([
                'message' => 'Shop created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
