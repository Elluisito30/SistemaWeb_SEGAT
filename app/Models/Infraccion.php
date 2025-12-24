<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infraccion extends Model
{
    protected $table = 'infraccion';
    protected $primaryKey = 'id_infraccion';
    public $timestamps = false;
    
    protected $fillable = [
        'id_detalleInfraccion',
        'montoMulta',
        'fechaLimitePago',
        'estadoPago',
        'documentoAdjunto'
    ];

    protected $casts = [
        'fechaLimitePago' => 'datetime',
        'montoMulta' => 'decimal:2'
    ];
    
    /**
     * Relación con DetalleInfraccion
     */
    public function detalleInfraccion()
    {
        return $this->belongsTo(DetalleInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }
}