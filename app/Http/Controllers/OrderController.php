<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\OrderHeader;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function getDetails($id)
    {
        $details = OrderDetail::where('order_id', $id)->get();
        return response()->json($details);
    }
    public function getOrders(){

        $user = auth()->user();

        $userId = $user->company_id;

        $orders = OrderHeader::where('cliente_middleware_id', $userId)
            ->orderBy('fecha_compra', 'desc')
            ->get();

        return response()->json($orders);
    }
}
