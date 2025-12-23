<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudLimpieza extends Model
{  
    protected $table = 'solicitud';  
    protected $primaryKey = 'id_solicitud';  
    public $timestamps = false;  
    protected $fillable = [  
        'id_detalleSolicitud',
        'id_servicio',
        'prioridad',
        'descripcion',
        'fechaTentativaEjecucion',
        'documentoAdjunto'
    ];  

    public function detalleSolicitud() 
    {
        return $this->belongsTo(DetalleSolicitud::class, 'id_detalleSolicitud', 'id_detalleSolicitud');
    }

    public function servicio() 
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }
}