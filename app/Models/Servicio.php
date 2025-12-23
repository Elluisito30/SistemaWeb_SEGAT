<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model  
{  
    protected $table = 'servicio';  
    protected $primaryKey = 'id_servicio';  
    public $timestamps = false;  
    protected $fillable = ['descripcionServicio'];  

    public function solicitudes() 
    {
        return $this->hasMany(Solicitud::class, 'id_servicio', 'id_servicio');
    }
}