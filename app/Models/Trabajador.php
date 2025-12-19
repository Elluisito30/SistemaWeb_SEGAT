<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';
    protected $primaryKey = 'idtrabajador';
    protected $fillable = ['nombres', 'apellidos', 'edad', 'email', 'sexo', 'estado_civil'];
    public $timestamps = false;

}
