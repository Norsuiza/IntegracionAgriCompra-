<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RequestAgro extends Model
{
    protected $table = 'requests';
    protected $fillable = [
        'client_id',
        'request_date'
    ];

}
