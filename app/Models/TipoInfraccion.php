<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoInfraccion extends Model
{
    protected $table = 'tipoinfraccion';
    protected $primaryKey = 'tipoInfraccion';
    public $timestamps = false;
    protected $fillable = ['descripcion'];

    public function detalleInfracciones()
    {
        return $this->hasMany(DetalleInfraccion::class, 'tipoInfraccion', 'tipoInfraccion');
    }
}