<?php  
namespace App\Models;  
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model  
{  
    protected $table = 'trabajadores';  
    protected $primaryKey = 'idtrabajador';  
    public $timestamps = false;  
    
    protected $fillable = [  
        'user_id',
        'nombres',
        'apellidos',
        'edad',
        'email',
        'sexo',
        'estado_civil'
    ];  

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}