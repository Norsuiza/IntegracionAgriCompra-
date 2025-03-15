<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RequestAgro extends Model
{
    protected $table = 'Requests';
    protected $Fillables = [
        'client_id',
        'request_date'
    ];

}
