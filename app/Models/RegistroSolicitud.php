<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroSolicitud extends Model
{
    protected $table = 'registrosolicitud';
    protected $primaryKey = 'id_detalleSolicitud';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_detalleSolicitud',
        'id_trabajador',
        'fechaHoraEmision',
        'estado'
    ];

    protected $casts = [
        'fechaHoraEmision' => 'datetime',
    ];

    // ========================================
    // RELACIONES
    // ========================================

    /**
     * Relación con DetalleSolicitud
     */
    public function detalleSolicitud()
    {
        return $this->belongsTo(DetalleSolicitud::class, 'id_detalleSolicitud', 'id_detalleSolicitud');
    }

    /**
     * Relación con Trabajador
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'id_trabajador', 'idtrabajador');
    }
}
