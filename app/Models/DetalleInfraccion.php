<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleInfraccion extends Model
{
    protected $table = 'detalleinfraccion';
    protected $primaryKey = 'id_detalleInfraccion';
    public $timestamps = false;
    protected $fillable = ['id_contribuyente', 'lugarOcurrencia', 'fechaHora', 'tipoInfraccion'];
    protected $casts = [
        'fechaHora' => 'datetime',
    ];

    
    //  Relación con Contribuyente (el infractor)
    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class, 'id_contribuyente', 'id_contribuyente');
    }

    // Relación con TipoInfraccion (renombrado para evitar conflicto con el campo)
    public function tipo()
    {
        return $this->belongsTo(TipoInfraccion::class, 'tipoInfraccion', 'tipoInfraccion');
    }

    /**
     * Relación con Infraccion (uno a uno)
     * Un detalle de infracción tiene una infracción (con el monto de multa)
     */
    public function infraccion()
    {
        return $this->hasOne(Infraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }

    
    // Relación con RegistroInfraccion
    public function registroInfraccion()
    {
        return $this->hasOne(RegistroInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }
}