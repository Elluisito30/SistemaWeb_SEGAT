<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipo_documento';
    protected $primaryKey = 'id_TipoDocumento';
    public $timestamps = false;
    protected $fillable = ['descripcionTipoD'];

    public function contribuyentes()
    {
        return $this->hasMany(Contribuyente::class, 'id_tipoDocumento', 'id_TipoDocumento');
    }
}
