<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestDetail extends Model
{
    protected $table = 'request_details'
    protected $fillable = [
        'request_id',
        'order_id'
    ];
}
