<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getDetails($id)
    {
        $details = OrderDetail::where('order_id', $id)->get();
        return response()->json($details);
    }

}
