<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Model;

class Contribuyente extends Model  
{  
    protected $table = 'contribuyente';  
    protected $primaryKey = 'id_contribuyente';  
    public $timestamps = false;  
    protected $fillable = ['user_id', 'id_tipoDocumento', 'numDocumento', 'genero', 'telefono', 'celula', 'email',
        'tipoContribuyente',
        'id_domicilio'
    ];  

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detalleSolicitudes() 
    {
        return $this->hasMany(DetalleSolicitud::class, 'id_contribuyente', 'id_contribuyente');
    }

    // Relación con TipoDocumento
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_tipoDocumento', 'id_TipoDocumento');
    }

    /** Relación con DetalleInfraccion
     * Un contribuyente puede tener muchas infracciones
     */
    public function detalleInfracciones()
    {
        return $this->hasMany(DetalleInfraccion::class, 'id_contribuyente', 'id_contribuyente');
    }

    /**
     * Relación con Domicilio
     */
    public function domicilio()
    {
        return $this->belongsTo(Domicilio::class, 'id_domicilio', 'id_domicilio');
    }


}