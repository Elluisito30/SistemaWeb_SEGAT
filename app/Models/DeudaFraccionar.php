<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeudaFraccionar extends Model
{
    protected $table = 'deudafraccionar';
    protected $primaryKey = 'id_detalleInfraccion';
    protected $fillable = ['año', 'montoFraccion'];
    public $timestamps = false;

    public function detalleInfraccion()
    {
        return $this->belongsTo(DetalleInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }

    public function fraccionamiento()
    {
        return $this->belongsTo(Fraccionamiento::class, 'id_fraccionamiento', 'id_fraccionamiento');
    }
}
