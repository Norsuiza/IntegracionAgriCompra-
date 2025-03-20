<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\RequestDetail;
use App\Models\RequestAgro;
use App\Models\OrderHeader;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class RequestController extends Controller
{

    public function getDetails($id)
    {
        $details = RequestDetail::where('request_id', $id)->get();
        return response()->json($details);
    }

    public function reactivate($id){
        $affectedRows = DB::table('order_header')
        ->join('request_details', 'order_header.id', '=', 'request_details.order_id')
        ->join('requests', 'request_details.request_id', '=', 'requests.id')
        ->where('requests.id', $id)
        ->update(['status' => 1]);

        return response()->json(['affected' => $affectedRows]);
    }
}
