<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionApiController extends Controller
{
    public function getAll(Request $request)
    {
        $transWithShop = DB::table('transactions')
            ->join('shops', 'transactions.shop_id', '=', 'shops.id')
            ->select('transactions.*', 'shops.name as shop_name')
            ->get();
        $transactions = Transaction::all();
        return response()->json($transWithShop);
    }
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                "shop_id" => "required|exists:shops,id",
                "data_time" => "required",
                "sum" => "required",
            ]);
            if ($request->hasFile("doc")) {
                $file = $request->file("doc")->store("public/checks");
                $data = Carbon::parse($validate["data_time"])->format('Y-m-d H:i:s');
                $Transaction = Transaction::create(["data_time" => $data, "sum" => $validate["sum"], "shop_id" => $validate["shop_id"], "doc" =>  '/storage/' . str_replace('public/', '',  $file)]);
                return response()->json(
                    'Transaction created successfully'
                );
            }
            return response()->json('doc not found', 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    public function delete(Request $request)
    {
        try {
            $validate = $request->validate(["id" => "required|exists:transactions,id"]);
            Transaction::where("id", $request->id)->delete();
            return response()->json('Transaction deleted successfully');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
