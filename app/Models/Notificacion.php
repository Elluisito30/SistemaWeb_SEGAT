<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    
    const UPDATED_AT = null; // Solo usa created_at
    
    protected $fillable = [
        'user_id',
        'tipo',
        'titulo',
        'mensaje',
        'url',
        'leida'
    ];

    protected $casts = [
        'leida' => 'boolean',
        'created_at' => 'datetime'
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Marcar como leída
    public function marcarComoLeida()
    {
        $this->leida = true;
        $this->save();
    }

    // Scope para notificaciones no leídas
    public function scopeNoLeidas($query)
    {
        return $query->where('leida', 0);
    }
    
    // Método helper para notificar a todos los trabajadores
    public static function notificarTrabajadores($tipo, $titulo, $mensaje, $url = null)
    {
        $trabajadores = \App\Models\User::where('role', 'trabajador')->get();
        
        foreach ($trabajadores as $trabajador) {
            self::create([
                'user_id' => $trabajador->id,
                'tipo' => $tipo,
                'titulo' => $titulo,
                'mensaje' => $mensaje,
                'url' => $url
            ]);
        }
    }
}