<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    protected $table = 'domicilio';
    protected $primaryKey = 'id_domicilio';
    protected $fillable = ['direccionDomi', 'id_distrito', 'tipoDomi'];
    public $timestamps = false;

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'id_distrito', 'id_distrito');
    }

    public function contribuyentes()
    {
        return $this->hasMany(Contribuyente::class, 'id_domicilio', 'id_domicilio');
    }
}
