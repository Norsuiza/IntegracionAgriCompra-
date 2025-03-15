<?php

namespace App\Http\Controllers;
use App\Models\RequestAgro;
use App\Models\RequestDetail;
use App\Models\OrderHeader;
use App\Models\OrderDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $orders = OrderHeader::where('cliente_middleware_id', $userId)
            ->where('status', 1)
            ->orderBy('fecha_compra', 'desc')
            ->get();



        $requestsAgro = RequestAgro::join('request_details', 'requests.id', '=', 'request_details.request_id')
        ->select('requests.id', 'requests.request_date', DB::raw('count(request_details.id) as ordenes'))
        ->where('client_id', $userId)
        ->groupBy('requests.id', 'requests.request_date')
        ->get();

        return view('dashboard', compact('orders', 'requestsAgro'));
    }
}
