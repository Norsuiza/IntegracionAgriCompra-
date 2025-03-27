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
        $user = auth()->user();

        $userId = $user->company_id;


        $requestsAgro = RequestAgro::join('request_details', 'requests.id', '=', 'request_details.request_id')
            ->select('requests.id', 'requests.request_date', DB::raw('count(request_details.id) as ordenes'))
            ->where('requests.client_id',$userId) // Usar el company_id en el filtro
            ->groupBy('requests.id', 'requests.request_date')
            ->get();

        return view('dashboard', compact('requestsAgro'));
    }
}
