<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroInfraccion extends Model
{
    protected $table = 'registroinfraccion';
    protected $primaryKey = 'id_detalleInfraccion';
    protected $fillable = ['fechaHoraEmision', 'estado', 'idtrabajador'];
    public $timestamps = false;

    public function detalleInfraccion()
    {
        return $this->belongsTo(DetalleInfraccion::class, 'id_detalleInfraccion', 'id_detalleInfraccion');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'idtrabajador', 'idtrabajador');
    }
}
