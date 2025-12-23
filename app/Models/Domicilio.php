<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    protected $table = 'domicilio';
    protected $primaryKey = 'id_domicilio';
    public $timestamps = false;

    protected $fillable = ['direccionDomi', 'id_distrito', 'tipoDomi'];

    /**
     * Relación con Distrito
     */
    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'id_distrito', 'id_distrito');
    }

    /**
     * Relación con Contribuyente
     * Un domicilio puede tener muchos contribuyentes
     */
    public function contribuyentes()
    {
        return $this->hasMany(Contribuyente::class, 'id_domicilio', 'id_domicilio');
    }
}