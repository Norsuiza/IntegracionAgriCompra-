<?php

namespace App\Http\Controllers;

use App\Models\RequestDetail;
use Illuminate\Http\Request;

class RequestController extends Controller
{

    public function getDetails($id)
    {
        $details = RequestDetail::where('request_id', $id)->get();
        return response()->json($details);
    }

}
