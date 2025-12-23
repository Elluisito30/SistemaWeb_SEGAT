<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infraccion extends Model
{
    protected $table = 'infraccion';
    protected $primaryKey = 'id_infraccion';
    protected $fillable = ['id_detalleInfraccion', 'montoMulta', 'fechaLimitePago', 'estadoPago', 'documentoAdjunto', 'estado_civil'];
    public $timestamps = false;
    
    // Relación con DetalleInfraccion
    public function detalleInfraccion()
    {
        return $this->belongsTo(DetalleInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }

}