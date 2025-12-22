<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Model;

class DetalleSolicitud extends Model  
{  
    protected $table = 'detallesolicitud';  
    protected $primaryKey = 'id_detalleSolicitud';  
    public $timestamps = false;  
    
    protected $fillable = [  
        'id_contribuyente',
        'id_area',
    ];  

    public function contribuyente() 
    {
        return $this->belongsTo(Contribuyente::class, 'id_contribuyente', 'id_contribuyente');
    }

    public function areaVerde() 
    {
        return $this->belongsTo(AreaVerde::class, 'id_area', 'id_area');
    }

    public function solicitudes() 
    {
        return $this->hasMany(SolicitudLimpieza::class, 'id_detalleSolicitud', 'id_detalleSolicitud');
    }
}