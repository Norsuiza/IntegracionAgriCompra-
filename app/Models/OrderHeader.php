<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class OrderHeader extends Model
{
    protected $table = 'order_header';
    protected $fillable = [
        'orden_compra',
        'dias_credito',
        'fecha_compra',
        'total_general',
        'sucursal_nombre',
        'sucursal_id',
        'proveedor_nombre',
        'proveedor_tienda_id',
        'proveedor_rfc',
        'comprador_rfc',
        'direccion_envio_id',
        'uso_cfdi_id',
        'metodo_pago_id',
        'forma_pago_id',
        'isr_retenido',
        'status',
        'cliente_middleware_id',
        'orden_cancelada'
    ];
}
