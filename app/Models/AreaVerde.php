<?php  
namespace App\Models;  
use Illuminate\Database\Eloquent\Model;

class AreaVerde extends Model  
{  
    protected $table = 'areaverde';  
    protected $primaryKey = 'id_area';  
    public $timestamps = false;  
    
    protected $fillable = [  
        'id_distrito',
        'nombre',
        'tamaño',
        'referencia'
    ];  

    public function distrito() 
    {
        return $this->belongsTo(Distrito::class, 'id_distrito', 'id_distrito');
    }

    public function detalleSolicitudes() 
    {
        return $this->hasMany(DetalleSolicitud::class, 'id_area', 'id_area');
    }
}