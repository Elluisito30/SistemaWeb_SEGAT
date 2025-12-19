<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleInfraccion extends Model
{
    protected $table = 'detalleinfraccion';
    protected $primaryKey = 'id_detalleInfraccion';
    protected $fillable = ['id_contribuyente', 'lugarOcurrencia', 'fechaHora', 'tipoInfraccion'];
    public $timestamps = false;

    // Relación: Un detalle pertenece a un contribuyente
    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class, 'id_contribuyente', 'id_contribuyente');
    }

    // Relación: Un detalle pertenece a un tipo de infracción
    public function tipoInfraccion()
    {
        return $this->belongsTo(TipoInfraccion::class, 'tipoInfraccion', 'tipoInfraccion');
    }

    // Relación: Un detalle tiene una infracción principal
    public function infraccion()
    {
        return $this->hasOne(Infraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }

    // Relación: Un detalle puede tener múltiples registros de infracción
    public function registrosInfraccion()
    {
        return $this->hasMany(RegistroInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }

    // Relación: Un detalle puede tener una deuda a fraccionar
    public function deudaFraccionar()
    {
        return $this->hasOne(DeudaFraccionar::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }

}
