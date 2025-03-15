<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;
    protected $table = 'order_details';
    protected $fillable  = [
        'order_id',
        'moneda',
        'precio',
        'ieps',
        'iva',
        'articulo_id',
        'articulo_nombre',
        'unidad_id',
        'unidad_nombre',
        'cantidad',
        'concepto',
        'subtotal',
        'codigo_concepto',
        'fecha_creacion',
        'fecha_entrega_solicitada',
        'proyecto_nombre',
        'requisicion_id',
        'iva_retenido',
        'autorizador_id',
        'proyecto_codigo'
    ]
    
    protected $dates = ['deteled_at'];
}
