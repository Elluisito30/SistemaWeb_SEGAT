<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Infraccion extends Model
{
    protected $table = 'infraccion';
    protected $primaryKey = 'id_infraccion';
    protected $fillable = ['id_detalleInfraccion', 'montoMulta', 'fechaLimitePago', 'estadoPago', 'documentoAdjunto'];
    public $timestamps = false;

    // Relación: Una infracción pertenece a un detalle de infracción
    public function detalleInfraccion()
    {
        return $this->belongsTo(DetalleInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }
    
    // Relación indirecta: Acceso rápido al contribuyente a través del detalle
    public function contribuyente()
    {
        return $this->hasOneThrough(
            Contribuyente::class,           // Modelo final
            DetalleInfraccion::class,       // Modelo intermedio
            'id_detalleInfraccion',         // Foreign key en tabla intermedia
            'id_contribuyente',             // Foreign key en tabla final
            'id_detalleInfraccion',         // Local key en esta tabla
            'id_contribuyente'              // Local key en tabla intermedia
        );
    }
    
    // Relación: Una infracción puede tener registros de infracción (actas/resoluciones)
    public function registrosInfraccion()
    {
        return $this->hasMany(RegistroInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');  //Falta RegistroInfraccion
    }
    
    // Relación: Una infracción puede tener una deuda a fraccionar
    public function deudaFraccionar()
    {
        return $this->hasOne(DeudaFraccionar::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }
    
}
