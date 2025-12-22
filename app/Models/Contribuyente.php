<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Model;

class Contribuyente extends Model  
{  
    protected $table = 'contribuyente';  
    protected $primaryKey = 'id_contribuyente';  
    public $timestamps = false;  
    
    protected $fillable = [  
        'user_id',
        'id_tipoDocumento',
        'numDocumento',
        'genero',
        'telefono',
        'celula',
        'email',
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
}