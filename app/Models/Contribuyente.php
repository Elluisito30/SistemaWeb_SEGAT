<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribuyente extends Model
{
    protected $table = 'contribuyente';
    protected $primaryKey = 'id_contribuyente';
    protected $fillable = ['id_tipoDocumento', 'numDocumento', 'genero', 'telefono', 'celula', 'email', 'tipoContribuyente', 'id_domicilio'];
    public $timestamps = false;

    // Relación: Un contribuyente pertenece a un tipo de documento
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_tipoDocumento', 'id_TipoDocumento');
    }

    // Relación: Un contribuyente pertenece a un domicilio
    public function domicilio()
    {
        return $this->belongsTo(Domicilio::class, 'id_domicilio', 'id_domicilio');
    }

    // Relación: Un contribuyente puede tener múltiples detalles de infracciones
    public function detallesInfraccion()
    {
        return $this->hasMany(DetalleInfraccion::class, 'id_contribuyente', 'id_contribuyente');
    }

    // Relación indirecta: Todas las infracciones del contribuyente
    public function infracciones()
    {
        return $this->hasManyThrough(
            Infraccion::class,              // Modelo final
            DetalleInfraccion::class,       // Modelo intermedio
            'id_contribuyente',             // Foreign key en tabla intermedia
            'id_detalleInfraccion',         // Foreign key en tabla final
            'id_contribuyente',             // Local key en esta tabla
            'id_detalleInfraccion'          // Local key en tabla intermedia
        );
    }

    // Método útil: Verificar si es reincidente
    public function esReincidente()
    {
        return $this->infracciones()->count() > 1;
    }

    // Método útil: Obtener total de deuda pendiente
    public function deudaPendiente()
    {
        return $this->infracciones()
            ->where('estadoPago', '!=', 'Pagado')
            ->sum('montoMulta');
    }
}
