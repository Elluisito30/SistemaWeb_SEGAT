<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoInfraccion extends Model
{
    protected $table = 'tipoinfraccion';
    protected $primaryKey = 'tipoInfraccion';
    public $timestamps = false;
    public $incrementing = false; // Porque la PK no es autoincremental
    
    protected $fillable = [
        'tipoInfraccion',
        'descripcion'
    ];

    /**
     * Relación con DetalleInfraccion
     */
    public function detallesInfraccion()
    {
        return $this->hasMany(DetalleInfraccion::class, 'tipoInfraccion', 'tipoInfraccion');
    }
}