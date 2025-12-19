<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoInfraccion extends Model
{
    protected $table = 'tipoinfraccion';
    protected $primaryKey = 'tipoInfraccion';
    protected $fillable = ['descripcion'];
    public $timestamps = false;

    // Relación: Un tipo de infracción puede tener muchos detalles de infracción
    public function detallesInfraccion()
    {
        return $this->hasMany(DetalleInfraccion::class, 'tipoInfraccion', 'tipoInfraccion');
    }

    // Método útil: Contar cuántas infracciones de este tipo existen
    public function totalInfracciones()
    {
        return $this->detallesInfraccion()->count();
    }
}
