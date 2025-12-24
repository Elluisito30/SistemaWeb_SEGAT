<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleInfraccion extends Model
{
    protected $table = 'detalleinfraccion';
    protected $primaryKey = 'id_detalleInfraccion';
    public $timestamps = false;
    
    protected $fillable = [
        'id_contribuyente',
        'tipoInfraccion',
        'lugarOcurrencia',
        'fechaHora'
    ];

    protected $casts = [
        'fechaHora' => 'datetime',
    ];

    /**
     * Relación con Contribuyente
     */
    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class, 'id_contribuyente', 'id_contribuyente');
    }

    /**
     * Relación con TipoInfraccion
     */
    public function tipoInfraccion()
    {
        return $this->belongsTo(TipoInfraccion::class, 'tipoInfraccion', 'tipoInfraccion');
    }

    /**
     * Relación con Infraccion (la multa)
     */
    public function infraccion()
    {
        return $this->hasOne(Infraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }

    /**
     * Relación con RegistroInfraccion (validación del trabajador)
     */
    public function registroInfraccion()
    {
        return $this->hasOne(RegistroInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }
}