<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoInfraccion extends Model
{
    protected $table = 'pago_infraccion';
    protected $primaryKey = 'id_pago';
    public $timestamps = false;
    
    protected $fillable = [
        'id_infraccion',
        'id_contribuyente',
        'montoPagado',
        'fechaPago',
        'metodoPago',
        'numeroOperacion',
        'entidadFinanciera',
        'comprobanteAdjunto',
        'observaciones',
        'estado',
        'fechaRegistro'
    ];

    protected $casts = [
        'fechaPago' => 'datetime',
        'fechaRegistro' => 'datetime',
        'montoPagado' => 'decimal:2'
    ];

    // Relación con Infraccion
    public function infraccion()
    {
        return $this->belongsTo(Infraccion::class, 'id_infraccion', 'id_infraccion');
    }

    // Relación con Contribuyente
    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class, 'id_contribuyente', 'id_contribuyente');
    }
}
