<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroInfraccion extends Model
{
    protected $table = 'registroinfraccion';
    protected $primaryKey = 'id_detalleInfraccion';
    public $timestamps = false;
    protected $fillable = ['id_detalleInfraccion', 'idtrabajador', 'fechaHoraEmision', 'estado'];
    protected $casts = [
        'fechaHoraEmision' => 'datetime',
    ];

    
    // Relación con DetalleInfraccion

    public function detalleInfraccion()
    {
        return $this->belongsTo(DetalleInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }

    /**
     * Relación con Trabajador
     * El trabajador que registró/validó la infracción
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'idtrabajador', 'idtrabajador');
    }
}