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
    public function getPendingOrders(){
        $pendingOrders = OrderHeader::where('status', 1)->get();
        return response()->json($pendingOrders);
    }
}
